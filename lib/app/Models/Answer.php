<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $guarded = [];

    public function ques(){
        return $this->belongsTo('App\Models\Question','ques_id');
    }

}
