<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quotations = auth()->user()->quotations()->latest()->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    public function create()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'カートが空です。');
        }

        return view('quotations.create', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'カートが空です。');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        $quotation = Quotation::create([
            'user_id' => auth()->id(),
            'quotation_date' => now(),
            'valid_until' => now()->addDays(30),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'notes' => $request->notes,
        ]);

        foreach ($cartItems as $cartItem) {
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
                'subtotal' => $cartItem->product->price * $cartItem->quantity,
            ]);
        }

        // Clear cart
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('quotations.show', $quotation)->with('success', '見積書を作成しました。');
    }

    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation);

        $quotation->load('items.product');

        return view('quotations.show', compact('quotation'));
    }

    public function download(Quotation $quotation)
    {
        $this->authorize('view', $quotation);

        $quotation->load('items.product', 'user');

        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))
            ->setOption('enable-font-subsetting', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('fontDir', storage_path('fonts'))
            ->setOption('fontCache', storage_path('fonts'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('quotation-' . $quotation->quotation_number . '.pdf');
    }
}
