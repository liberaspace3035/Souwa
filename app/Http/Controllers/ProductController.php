<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isAdminRequest($request)) {
            $products = Product::latest()->paginate(20);
            return view('products.admin_index', compact('products'));
        }

        $query = $this->buildFilteredQuery($request);
        $products = $query->paginate(12);
        $products = $this->transformProducts($products);

        return view('products.index', compact('products'));
    }

    /**
     * 管理者リクエストかどうかを判定
     */
    private function isAdminRequest(Request $request): bool
    {
        return auth()->check() 
            && auth()->user()->isAdmin() 
            && $request->route()->getName() === 'admin.products.index';
    }

    /**
     * リクエストパラメータに基づいてフィルタリングされたクエリを構築
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Product::query();

        // カテゴリによるフィルタリング
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // 商品名による検索
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // フラグによるフィルタリング
        if ($request->has('bestselling') && $request->boolean('bestselling')) {
            $query->where('is_featured', true);
        }

        if ($request->has('new') && $request->boolean('new')) {
            $query->where('is_new', true);
            dump('new');
        }

        if ($request->has('limited') && $request->boolean('limited')) {
            $query->where('is_limited', true);
        }
        return $query;
    }

    /**
     * 商品データを整形（attributesのみを抽出し、castsを適用）
     */
    private function transformProducts($products)
    {
        $products->getCollection()->transform(function ($product) {
            $attributes = $product->getAttributes();
            
            // モデルのcastsで定義された値を取得（boolean変換などが適用される）
            $attributes['is_featured'] = $product->is_featured;
            $attributes['is_limited'] = $product->is_limited;
            $attributes['is_new'] = $product->is_new;
            $attributes['price'] = $product->price;
            $attributes['image_url'] = $product->image_url;
            
            return (object) $attributes;
        });

        return $products;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        
        $validated = $this->processProductData($request, $validated);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', '商品を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->getValidationRules());
        
        $validated = $this->processProductData($request, $validated, $product);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', '商品を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->deleteProductImage($product);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }

    /**
     * バリデーションルールを取得
     */
    private function getValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:255',
            'airport' => 'nullable|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_limited' => 'boolean',
            'is_new' => 'boolean',
        ];
    }

    /**
     * 商品データを処理（画像アップロード、フラグ処理）
     */
    private function processProductData(Request $request, array $validated, ?Product $product = null): array
    {
        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $disk = config('filesystems.images', 'public');
            
            // 更新時は既存の画像を削除
            if ($product && $product->image) {
                Storage::disk($disk)->delete($product->image);
            }
            
            $validated['image'] = $request->file('image')->store('products', $disk);
        }

        // チェックボックスのフラグを処理
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_limited'] = $request->has('is_limited');
        $validated['is_new'] = $request->has('is_new');

        return $validated;
    }

    /**
     * 商品画像を削除
     */
    private function deleteProductImage(Product $product): void
    {
        if ($product->image) {
            $disk = config('filesystems.images', 'public');
            Storage::disk($disk)->delete($product->image);
        }
    }
}
