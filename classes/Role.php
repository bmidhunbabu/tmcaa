<?php

class Role extends Model
{
    public static $table = 'roles';

    public static function getName($id)
    {
        global $mysqli;
        $sql = "select * from roles where id = '$id'";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $role = $result->fetch_assoc();
            return $role['name'];
        }
        return false;
    }
}
