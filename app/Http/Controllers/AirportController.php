<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * 空港別の商品一覧ページを表示
     */
    public function show(Request $request, $airport)
    {
        // 空港名のマッピング
        $airportNames = [
            'tokyo' => '東京成田/羽田機場',
            'osaka' => '大阪國際關西機場',
            'nagoya' => '名古屋中部國際機場',
            'fukuoka' => '福岡機場',
            'hokkaido' => '北海道新千歲機場',
            'okinawa' => '沖繩那霸機場',
        ];

        // 無効な空港の場合は404
        if (!isset($airportNames[$airport])) {
            abort(404);
        }

        $airportName = $airportNames[$airport];

        // 商品を取得（空港フィールドでフィルタリング）
        $query = Product::where('airport', $airport);

        // カテゴリによるフィルタリング
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // 商品名による検索
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('airport.show', compact('airport', 'airportName', 'products'));
    }
}

