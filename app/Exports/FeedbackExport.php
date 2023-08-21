<?php

namespace App\Exports;
use App\Models\Feedback;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;


class FeedbackExport implements FromCollection
{
    use Exportable;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function collection(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array
    {
       $feedbacks =  Feedback::query();
       $feedbacks
           ->whereIn('id' ,$this->array)
          ->get();
       return $feedbacks->get();
    }
}

