<?php

class Attendance extends Model
{
    public static $table = "attendance";

    public static function create(array $data)
    {
        global $mysqli;
        $course_id = $data['course_id'];
        $students = $data['status'];
        $date = $data['date'];
        $created_at = date("Y-m-d H:i:s"); 
        $result = 0;
        foreach ($students as $key => $value) {
            if(Attendance::existsWith(['student_id' => $key,'course_id' => $course_id,'date' => $date])) {
                $sql = "update attendance set status = '$value',updated_at = '$created_at' where student_id = '$key' and course_id = '$course_id' and date ='$date'";
            } else {
                $sql = "insert into attendance(student_id,course_id,date,status,created_at,updated_at) values('$key','$course_id','$date','$value','$created_at','$created_at')";
            }
            $result = $mysqli->query($sql);
        }
        return $result;
    }
}