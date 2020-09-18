<?php
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function db_conn(){
    try{
       return new PDO('mysql:dbname=alps;charset=utf8;host=localhost','root','root');
} catch (PDOException $e){
        exit('DB Connection Error:'.$e->getMessage());
    }
}
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

?>