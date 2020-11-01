<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassProgress extends Model
{
    public function lesson_step(){
        return $this->belongsTo('App\LessonStep');
    }
}
