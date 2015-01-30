<?php

/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/1/5
 * Time: 22:56
 */
namespace App\Http\Composer;

use App\Repositories\Board\BoardRepository;
use Illuminate\Contracts\View\View;
use Auth;

class NavbarComposer
{
    public function __construct()
    {
        $this->board = new BoardRepository();
    }

    public function compose(View $view)
    {
        $view->with('top_boards', $this->board->getTopBoards())
            ->with('user', Auth::user());
    }
}