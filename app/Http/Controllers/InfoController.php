<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    /**
     * 日本直送についてのページを表示
     */
    public function japanDirect()
    {
        return view('info.japan_direct');
    }

    /**
     * フォローするページを表示（同じ内容）
     */
    public function follow()
    {
        return view('info.japan_direct');
    }

    /**
     * ABOUT SOUWAのページを表示
     */
    public function aboutSowa()
    {
        return view('info.about_sowa');
    }
}

