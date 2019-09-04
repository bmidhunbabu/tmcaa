<?php

class Result extends Model
{
    public static $table = "results";

    public function exam()
    {
        return $this->belongsTo('results', 'exam_id', 'exams', 'id', 'Exam');
    }

    public function user()
    {
        return $this->belongsTo('results', 'user_id', 'users', 'id', 'User');
    }
}
