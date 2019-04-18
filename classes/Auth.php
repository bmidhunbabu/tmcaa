<?php

class Auth
{
    public static function login($username, $password)
    {
        global $mysqli;
        $password = md5($password);
        $sql = "select * from users where ((username  = '$username' and password = '$password') or (email  = '$username' and password = '$password')) and status = '1'";
        $result = $mysqli->query($sql);
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['logged_in'] = 1;
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public static function user()
    {
        return isset($_SESSION['logged_in']) ? User::find($_SESSION['user']['id']) : false;
    }

    public static function userId()
    {
        return isset($_SESSION['logged_in']) ? $_SESSION['user']['id'] : false;
    }

    public static function userName()
    {
        return isset($_SESSION['logged_in']) ? $_SESSION['user']['name'] : false;
    }

    public static function userFirstName()
    {
        $name = explode(' ', $_SESSION['user']['name']);
        return $name[0];
    }

    public static function is_logged_in()
    {
        return isset($_SESSION['logged_in']) ? true : false;
    }

    public static function logout()
    {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function admin_login($username, $password)
    {
        global $mysqli;
        $password = md5($password);
        $sql = "select * from admins where email  = '$username' and password = '$password'";
        $result = $mysqli->query($sql);
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['admin_logged_in'] = 1;
            $_SESSION['admin'] = $user;
            return true;
        }
        return false;
    }

    public static function is_admin_logged_in()
    {
        return isset($_SESSION['admin_logged_in']) ? true : false;
    }

    public static function admin()
    {
        return isset($_SESSION['admin_logged_in']) ? $_SESSION['admin'] : false;
    }

    public static function adminId()
    {
        return isset($_SESSION['admin_logged_in']) ? $_SESSION['admin']['id'] : false;
    }

    public static function adminName()
    {
        return isset($_SESSION['admin_logged_in']) ? $_SESSION['admin']['name'] : false;
    }

    public static function adminFirstName()
    {
        $name = explode(' ', $_SESSION['admin']['name']);
        return $name[0];
    }

    public static function admin_logout()
    {
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin']);
        session_destroy();
    }
}
