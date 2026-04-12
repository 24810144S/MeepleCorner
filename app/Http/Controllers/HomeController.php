<?php

namespace App\Http\Controllers;

use App\Models\BoardGame;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 取得所有「可借閱/可預約」的遊戲 (is_available = true)
        $boardGames = BoardGame::where('is_available', true)->get();

        // 人氣遊戲：這裡暫時用 play_time_minutes 或 id 做範例，您可以換成自己的熱門指標 (例如遊玩次數)
        // 如果沒有專門的計數欄位，可以隨機取 4 款或依 id 倒序
        $popularBoardGames = BoardGame::where('is_available', true)
                            ->inRandomOrder()  // 隨機展示 4 款，讓每次刷新不同
                            ->take(4)
                            ->get();

        return view('home', compact('boardGames', 'popularBoardGames'));
    }
}