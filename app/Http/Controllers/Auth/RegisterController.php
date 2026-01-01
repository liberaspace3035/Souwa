<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'], // 企業名
            'region' => ['required', 'string', 'max:255'], // 區域
            'address' => ['required', 'string'], // 地址
            'phone_number' => ['required', 'string', 'max:255'], // 電話號碼
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // 郵箱
            'person_in_charge' => ['required', 'string', 'max:255'], // 負責人
            'position' => ['nullable', 'string', 'max:255'], // 職位
            'company_size' => ['nullable', 'string', 'max:255'], // 企業規模
            'company_website' => ['nullable', 'url', 'max:255'], // 企業網址
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'region' => $request->region,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'person_in_charge' => $request->person_in_charge,
            'position' => $request->position,
            'company_size' => $request->company_size,
            'company_website' => $request->company_website,
        ]);

        auth()->login($user);

        return redirect()->route('home')->with('success', '登録が完了しました。');
    }
}
