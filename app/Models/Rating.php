<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;
    protected $table = 'ratings';
    public $timestamps = false;

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
