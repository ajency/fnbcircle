<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class AdminModerationController extends Controller
{
    public function listingApproval(Request $request)
    {
        $parent_categ = Category::whereNull('parent_id')->orderBy('order')->orderBy('name')->get();
        return view('admin-dashboard.listing_approval')->with('parents', $parent_categ);
    }
}
