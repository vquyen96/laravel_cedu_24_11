<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = [];

    public function exam(){
        return $this->belongsTo('App\Models\Exam','exam_id');
    }
    public function answer()
    {
        return $this->hasMany('App\Models\Answer','ques_id','id');
    }
}
