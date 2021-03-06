<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\status;
use Auth;

class StaticPagesController extends Controller
{
    // 主页
    public function home() 
    {
        //print_r(parse_url(getenv("DATABASE_URL")));
        
        // 获取当前用户的微博数据
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }
    	return view('static_pages/home',compact('feed_items'));
    }
    // 帮助页
    public function help()
    {
    	return view('static_pages/help');
    }
    // 关于页
    public function about() 
    {
    	return view('static_pages/about');
    }
}
