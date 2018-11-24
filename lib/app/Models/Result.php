<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $guarded = [];

    public function exam(){
        return $this->belongsTo('App\Models\Exam','exam_id');
    }
    public function acc()
    {
        return $this->belongsTo('App\Models\Account','acc_id');
    }
}
