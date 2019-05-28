<?php

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/../classes/' . $class . '.php';
});

function alert($message, $type)
{
    echo '<div class="alert alert-' . $type . '">';
    echo $message;
    echo '</div>';
}

function input($key, $value = '')
{
    return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $value;
}

function upload($file, $target_dir, $prefix = '')
{
    if (!file_exists($target_dir)) {
        mkdir($target_dir);
    }
    $count = 2;
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $name = $prefix . date('Ymd') . time();
    $target_file = $target_dir . $name;
    while (file_exists($target_file . '.' . $ext)) {
        $name .= "$count";
        $target_file = $target_dir . $name;
        $count++;
    }
    $new_file = $target_file . '.' . $ext;
    $file_name = $name . '.' . $ext;
    $result =  move_uploaded_file($file["tmp_name"], $new_file);
    return $result ? $file_name : false;
}
