<?php

class User extends Model
{
    public static $table = 'users';

    public static function is_admin()
    {
        global $mysqli;
        if (Auth::is_logged_in()) {
            $role_id = $_SESSION['user']['role_id'];
            return (Role::getName($role_id) == 'admin') ? true : false;
        }
        return false;
    }

    public static function is_staff()
    {
        global $mysqli;
        if (Auth::is_logged_in()) {
            $role_id = $_SESSION['user']['role_id'];
            return (Role::getName($role_id) == 'staff') ? true : false;
        }
        return false;
    }

    public static function is_student()
    {
        global $mysqli;
        if (Auth::is_logged_in()) {
            $role_id = $_SESSION['user']['role_id'];
            return (Role::getName($role_id) == 'student') ? true : false;
        }
        return false;
    }

    public static function count()
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table where role_id != (select id from roles where name = 'admin')";
        $result = $mysqli->query($sql);
        return $result->num_rows;
    }

    public static function all($order_by = 'created_at', $order = 'asc')
    {
        return self::get(
            array("role_id != (select id from roles where name = 'admin')"),
            $order_by,
            $order
        );
    }

    public function student()
    {
        return $this->hasOne('users', 'id', 'students', 'user_id', 'Student');
    }

    public function role()
    {
        return $this->belongsTo('users', 'role_id', 'roles', 'id', 'Role');
    }
}
