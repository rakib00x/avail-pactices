<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;
use Cookie;

class StoreController extends Controller
{
    public function categoryListView()
    {
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        return view('frontEnd.store.categoryListView')->with('category_slider', $category_slider);
    }

    public function categoryGridView()
    {
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        return view('frontEnd.store.categoryGridView')->with('category_slider', $category_slider);
    }
}
