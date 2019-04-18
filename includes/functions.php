<?php

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/../classes/' . $class . '.php';
});

function alert($message,$type) 
{
    echo '<div class="alert alert-'.$type.'">';
    echo $message;
    echo '</div>';
}