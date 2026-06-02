<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        $produtos = Produto::limit(8)->get();

        return view('home', compact('banners', 'produtos'));
    }
}
