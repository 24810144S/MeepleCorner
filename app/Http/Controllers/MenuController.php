<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
        public function index()
    {
        $menuItems = MenuItem::where('is_available', true)->get();
        $groupedMenu = $menuItems->groupBy('category');
        return view('menu', compact('groupedMenu'));
    }
}