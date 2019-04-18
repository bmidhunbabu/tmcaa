<?php

class Model
{
    public $attributes = array();

    public static function exists($key, $value)
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table where $key = '$value'";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            return true;
        }
        return false;
    }

    public static function existsWith(array $fields)
    {
        global $mysqli;
        $arr = [];
        foreach ($fields as $key => $value) {
            $arr[] = "$key = '$value'";
        }
        $where = implode(' and ', $arr);
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table where $where";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            return true;
        }
        return false;
    }

    public static function create(array $fields)
    {
        global $mysqli;
        $keys = $values = '';
        foreach ($fields as $key => $value) {
            $keys .= "$key,";
            $values .= "'$value',";
        }
        $created_at = date("Y-m-d H:i:s");
        $keys .= "updated_at,created_at";
        $values .= "'$created_at','$created_at'";
        $class = get_called_class();
        $table = $class::$table;
        $sql = "insert into $table($keys) values($values)";
        $result = $mysqli->query($sql);
        if ($result) {
            return $mysqli->insert_id;
        }
        return false;
    }

    public static function update(array $fields, $id)
    {
        global $mysqli;
        $updates = '';
        $updated_at = date("Y-m-d H:i:s");
        foreach ($fields as $key => $value) {
            $updates .= "$key = '$value',";
        }
        $updates .= "updated_at = '$updated_at'";
        $class = get_called_class();
        $table = $class::$table;
        $sql = "update $table set $updates where id = '$id'";
        $result = $mysqli->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    public static function delete($id)
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "delete from $table where id = '$id'";
        $result = $mysqli->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    public function hasOne($primary_table, $primary_key, $foreign_table, $foreign_key, $model)
    {
        global $mysqli;
        $id = $this->attributes['id'];
        $sql = "select f.* from $foreign_table f inner join $primary_table p on f.$foreign_key = p.$primary_key where p.id = '$id'";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $row =  $result->fetch_assoc();
            $table = new $model();
            $table->attributes = $row;
            return $table;
        } else {
            return null;
        }
    }

    public function belongsTo($foreign_table, $foreign_key, $primary_table, $primary_key, $model)
    {
        global $mysqli;
        $id = $this->attributes['id'];
        $sql = "select p.* from $foreign_table f inner join $primary_table p on f.$foreign_key = p.$primary_key where f.id = '$id'";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $table = new $model();
            $table->attributes = $row;
            return $table;
        } else {
            return null;
        }
    }

    public function hasMany($primary_table, $primary_key, $foreign_table, $foreign_key, $model)
    {
        global $mysqli;
        $id = $this->attributes['id'];
        $sql = "select f.* from $foreign_table f inner join $primary_table p on f.$foreign_key = p.$primary_key where p.id = '$id'";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $out = array();
            while ($row =  $result->fetch_assoc()) {
                $table = new $model();
                $table->attributes = $row;
                $out[] = $table;
            }
            return $out;
        } else {
            return null;
        }
    }

    public static function all($order_by = 'id', $order = 'asc')
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table order by $order_by $order";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $out = array();
            while ($row =  $result->fetch_assoc()) {
                $class = new $class();
                $class->attributes = $row;
                $out[] = $class;
            }
            return $out;
        } else {
            return null;
        }
    }

    public static function find($id)
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table where id = '$id'";
        $result = $mysqli->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $class = new $class();
            $class->attributes = $row;
            return $class;
        } else {
            return null;
        }
    }

    /**
     * Counts the number of records in a table.
     */
    public static function count()
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table";
        $result = $mysqli->query($sql);
        return $result->num_rows;
    }

    public static function get(array $where, $order_by = 'id', $order = 'asc')
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $condition = '';
        $condition = implode(' and ', $where);
        $sql = "select * from $table where $condition order by $order_by $order";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $out = array();
            while ($row =  $result->fetch_assoc()) {
                $class = new $class();
                $class->attributes = $row;
                $out[] = $class;
            }
            return $out;
        } else {
            return null;
        }
    }

    public static function paginate($offset, $limit, array $where = null, $order_by = 'id', $order = 'asc')
    {
        global $mysqli;
        $class = get_called_class();
        $table = $class::$table;
        $sql = "select * from $table";
        if ($where != null) {
            $condition = '';
            $condition = implode(' and ', $where);
            $sql .= " where $condition";
        }
        $sql .= " order by $order_by $order limit $offset,$limit";
        $result = $mysqli->query($sql);
        if ($result->num_rows) {
            $out = array();
            while ($row =  $result->fetch_assoc()) {
                $class = new $class();
                $class->attributes = $row;
                $out[] = $class;
            }
            return $out;
        } else {
            return null;
        }
    }

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }
}
