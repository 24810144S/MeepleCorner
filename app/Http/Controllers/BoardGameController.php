<?php

namespace App\Http\Controllers;

use App\Models\BoardGame;

class BoardGameController extends Controller
{
    public function index()
        {
            $boardGames = BoardGame::where('is_available', true)->get();
            return view('board-games', compact('boardGames'));
        }
}