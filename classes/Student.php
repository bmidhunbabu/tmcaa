<?php

class Student extends Model
{
    public static $table = 'students';

    public function course()
    {
        return $this->belongsTo('students', 'course_id', 'courses', 'id', 'Course');
    }
}
