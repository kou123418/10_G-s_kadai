<?php
session_start();

$email = $_POST["email"];
$pw = $_POST["pw"];

include("funcs.php");
$pdo = db_conn();

$stmt =$pdo->prepare("SELECT * FROM alps_user_table WHERE email=:email");
$stmt ->bindValue(':email', $email, PDO::PARAM_STR);
// $stmt->bindValue(':pw',$pw ,PDO::PARAM_STR); 

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}

$val = $stmt->fetch();

// var_dump($val);

if(password_verify($pw, $val["password"])){
    
    $_SESSION["chk_ssid"] =session_id();
    // $_SESSION["kanri_flg"] =$val['kanri_flg'];
    $_SESSION["email"] =$val['email'];
    // echo "ログイン認証に成功しました。";

    $_SESSION["user_id"] =$val['id'];

    // echo $_SESSION["user_id"];

    header("Location: select.php");
    exit;
}else{
    // echo "ログイン認証に失敗しました。";
    header("Location: login.php");
    exit;
}

exit();

?>