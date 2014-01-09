<?php

$db_host = 'localhost';
$db_user = 'corpjuk';
$db_pass = 'grools2!';
$db_name = 'test';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

print_r(fetchRows('SELECT something from some_table WHERE some_id = ?', 'i', 1));

function traceVar($a, $b) {
    print_r(array($b => $a));
}

function fetchRows(){
        error_reporting(E_ALL+E_NOTICE);
        $args = func_get_args();
        $sql = array_shift($args);
        traceVar($sql, "Query");

        // Keep the column types for bind_param.
        // $colTypes = array_shift($args);

        // Column types were originally passed here as a second
        // argument, and stored in the statement object, I suppose.
        if (!$query = $GLOBALS['mysqli']->prepare($sql)){ //, $colTypes)) {
                die('Please check your sql statement : unable to prepare');
        }
        if (count($args)){
                traceVar($args,'Binding params with');

                // Just a quick hack to pass references in order to
                // avoid errors.
                foreach ($args as &$v) {
                    $v = &$v;
                }

                // Replace the bindParam function of the original
                // abstraction layer.
                call_user_func_array(array($query,'bind_param'), $args); //'bindParam'), $args);
        }

        $query->execute();

        $meta = $query->result_metadata();
        while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
        }
        traceVar($params,'Binding results with');
        call_user_func_array(array($query, 'bind_result'), $params);

        while ($query->fetch()) {
                traceVar($row,'After fetch');
                $temp = array();
                foreach($row as $key => $val) {
                        $temp[$key] = $val;
                } 
                $result[] = $temp;
        }

        $meta->free();
        $query->close(); 
        //self::close_db_conn(); 
        return $result;
}