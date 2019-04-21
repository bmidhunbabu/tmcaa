<?php

class Exam extends Model
{
    public static $table = "exams";

    public function startDate()
    {
        if (isset($this->attributes['start_date'])) {
            $date = new DateTime($this->attributes['start_date']);
            return $date->format('M d, Y');
        } else {
            return null;
        }
    }

    public function endDate()
    {
        if (isset($this->attributes['end_date'])) {
            $date = new DateTime($this->attributes['end_date']);
            return $date->format('M d, Y');
        } else {
            return null;
        }
    }
    public function course()
    {
        return $this->belongsTo('exams', 'course_id', 'courses', 'id', 'Course');
    }
}
