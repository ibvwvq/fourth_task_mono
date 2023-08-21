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
        // перебираем по 100 записей из таблицы с пользователями
        ->chunk(100, function ($users) {
            $array = []; // переменная, для хранения нужных id отзывов
            foreach ($users as $user) {
                $ratings = DB::table('ratings')->where('user_id', $user->id)->get(); // все рейтинги одного пользователя
                $products = DB::table('products')->where('priceProduct', '>', 3000)->get(); // продукты цена которых больше 3000
                $countRating = 0; // переменная для среднего рейтинга
                $count = 0; // переменная для счета кол-ва нужных рейтингов

                // просчитываем средний рейтинг
                foreach ($ratings as $rating) {
                    $countRating += $rating->numberRating;
                }

                // первый запрос - Получить все отзывы, оставленные пользователями из Самары или Волгограда, отзывы которых были полезны для более чем 10 пользователей,
                if ($user->cityUser == 'Volgograd' || $user->cityUser == 'Samara') {
                    foreach ($ratings as $rating) {
                        $rat = Rating::find($rating->id); // ищем конкретный рейтинг
                        $feed = $rat->feedback; // находим отзыв у рейтинга (один рейтинг - один отзыв)

                        // проверяем на кол-во отметок "отзыв полезен" - если больше 10, то добавляем в массив
                        if ($feed->countMarkFeedback > 10) {
                            $array[] = $feed->id;
                        }
                    }
                } // второй запрос - которые оставили более 10 отзывов на товары стоимостью более 3 т.р., при среднем рейтинге всех отзывов пользователя на такие товары более 4.
                else{
                    foreach ($ratings as $rating) {
                        // перебираем продукты
                        foreach ($products as $product) {
                            // просчитываем сколько пользователь оставлял рейтингов на продукты с ценником больше 3000
                            if ($rating->product_id == $product->id) {
                                $count++;
                            }
                        }

                        $rat = Rating::find($rating->id);
                        $feed = $rat->feedback; // находим отзыв у рейтинга (один рейтинг - один отзыв)

                        // если пользователь оставил больше чем 10 рейтингов на товары стоимостью больше 300 и если средний рейтинг больше 4
                        if ($count > 10 && $countRating / ($ratings->count()) > 4) {
                            $array[] = $feed->id;
                        }
                    }
                }
            }
            // передаем массив с id нужных отзывов в новый обьект FeedbackExport, сохраняем обьект в feedback.csv, сохраняется в ..\storage\framework\cache\
            Excel::download(new FeedbackExport($array), 'feedback.csv');
        });
})->purpose('4 задание для собеседования в компанию MONO');


