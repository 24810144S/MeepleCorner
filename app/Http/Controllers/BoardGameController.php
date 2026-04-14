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

    // Change this method
    public function show($id)
    {
        $boardGame = BoardGame::findOrFail($id);
        return view('game_info', compact('boardGame'));
    }
}