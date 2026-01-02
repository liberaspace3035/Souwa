<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * カテゴリ別の商品一覧ページを表示
     */
    public function show(Request $request, $category)
    {
        // カテゴリ名のマッピング（URLスラッグ -> 表示名）
        $categoryNames = [
            'fresh-vegetables' => '新鮮野菜',
            'fruits' => '美味しい果物',
            'meat' => '肉類',
            'eggs-dairy' => '卵・乳製品',
            'honey-tea' => '蜂蜜・茶類',
            'seafood' => '魚類・海鮮',
            'rice-grains' => '米・穀類',
            'seasonings-processed' => '調味料・加工品',
        ];

        // 無効なカテゴリの場合は404
        if (!isset($categoryNames[$category])) {
            abort(404);
        }

        $categoryName = $categoryNames[$category];

        // カテゴリ名を取得（データベースに保存されている値）
        $dbCategoryName = $categoryNames[$category];

        // 商品を取得（カテゴリでフィルタリング）
        $query = Product::where('category', $dbCategoryName);

        // 空港によるフィルタリング
        if ($request->has('airport') && $request->airport) {
            $query->where('airport', $request->airport);
        }

        // 商品名による検索
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('category.show', compact('category', 'categoryName', 'products'));
    }
}

