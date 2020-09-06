<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonStep extends Model
{
    public function syllabus(){
        return $this->belongsTo('App\Syllabus');
    }
}
