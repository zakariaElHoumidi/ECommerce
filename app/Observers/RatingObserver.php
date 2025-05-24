<?php

namespace App\Observers;

use App\Models\Rating;

class RatingObserver
{
    public function saving(Rating $rating) {
        $isAuth = auth("sanctum")->check();

        if ($isAuth) {
            $rating->user_id = auth("sanctum")->user()->id;
        }
    }
}
