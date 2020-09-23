<?php

namespace App\Service;


class GameStart
{
    public function gameIsExist($user)
    {
        $gameIsExist = $user->getGame();
        // dump($gameIsExist).die();
        if(is_null($gameIsExist)) {
            return 1;
        } else {
            return 2;
        }
    }
}