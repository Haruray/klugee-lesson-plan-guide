<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonStep extends Model
{
    public function syllabus(){
        return $this->belongsTo('App\Syllabus');
    }
    public function class_progress(){
        return $this->hasOne('App\ClassProgress');
    }
}
