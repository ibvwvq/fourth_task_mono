<?php

use App\Exports\FeedbackExport;
use App\Models\Rating;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('fourth_task_mono', function () {
    DB::table('users')
        ->orderBy('id')
        ->chunk(100, function ($users) {
            $array = [];
            foreach ($users as $user) {
                $ratings = DB::table('ratings')->where('user_id', $user->id)->get();
                $products = DB::table('products')->where('priceProduct', '>', 3000)->get();
                $countRating = 0;
                $count = 0;

                foreach ($ratings as $rating) {
                    $countRating += $rating->numberRating;
                }

                if ($user->cityUser == 'Volgograd' || $user->cityUser == 'Samara') {
                    foreach ($ratings as $rating) {
                        $rat = Rating::find($rating->id);
                        $feed = $rat->feedback;

                        if ($feed->countMarkFeedback > 10) {
                            $array[] = $feed->id;
                        }
                    }
                }
                else{
                    foreach ($ratings as $rating) {
                        foreach ($products as $product) {
                            if ($rating->product_id == $product->id) {
                                $count++;
                            }
                        }
                        $rat = Rating::find($rating->id);
                        $feed = $rat->feedback;

                        if ($count > 10 && $countRating / $ratings->count() > 4) {
                            $array[] = $feed->id;
                        }
                    }
                }
            }
            Excel::download(new FeedbackExport($array), 'feedback.xlsx');
        });
})->purpose('4 задание для собеседования в компанию MONO');


