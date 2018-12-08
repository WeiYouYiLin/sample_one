<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    // 用户登录构造器
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => 'create',
        ]);
    }

    // 用户登录页面
    public function create()
    {
    	return view('session.create');
    }
    // 用户登录数据处理
    public function store(Request $request)
    {
    	$credentials = $this->validate($request,[
    		'email' => 'required|email|max:255',
    		'password' => 'required',
		]);
		if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->activated) {               
    			session()->flash('success','欢迎回来！');
    			return redirect()->intended(route('users.show',[Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning','您的账号未激活，请检查邮箱中的注册邮件进行激活');
                return redirect('/');
            }
		} else {
			session()->flash('danger','抱歉，你的邮箱和密码不匹配！');
			return redirect()->back();
		}
		return;
    }
    // 用户退出登录
    public function destroy()
    {
    	Auth::logout();

    	session()->flash('success','您已成功退出！');

    	return redirect('login');
    }
}
