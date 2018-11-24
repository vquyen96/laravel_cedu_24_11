<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $guarded = [];
    const PASS = 0.7;

    public function cou(){
        return $this->belongsTo('App\Models\Course','cou_id');
    }
    public function ques()
    {
        return $this->hasMany('App\Models\Question','exam_id','id');
    }
}
