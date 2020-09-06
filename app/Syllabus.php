<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    public function lesson_steps(){
        return $this->hasMany('App\LessonStep');
    }
}
