<?php

use App\Exports\FeedbackExport;
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

Artisan::command('first_command', function () {
    $feedbacks = DB::table('feedback')->get();
    DB::table('users')
        ->orderBy('id')
        ->where('cityUser', 'Volgograd')
        ->orWhere('cityUser', 'Samara')
        ->chunk(10, function ($users) use ($feedbacks) {
            foreach ($users as $user) {
                $ratings = DB::table('ratings')->where('user_id', $user->id)->get();
                foreach ($ratings as $rating) {
                    foreach ($feedbacks as $key => $feedback) {
                        if ($feedback->rating_id == $feedback->countMarkFeedback > 10) {
                            $feedbacks->where('rating_id',  $rating->id);
                        }
                    }
                }
            }
        });

    var_dump($feedbacks);
    Excel::download(new FeedbackExport($feedbacks), 'feedback.csv');

})->purpose('4 задание для собеседования в компанию MONO');


