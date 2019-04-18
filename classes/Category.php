<?php

class Category extends Model
{
    public static $table = 'categories';

    public function parent()
    {
        return $this->belongsTo('categories', 'parent_id', 'categories', 'id');
    }

    public function children()
    {
        return  $this->hasMany('categories', 'id', 'categories', 'parent_id');
    }
}
