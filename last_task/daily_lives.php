<?php

session_start();

if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
  }

require "funcs.php";
$pdo = db_conn();
// DB接続処理済
// 1) 問題全部取得
$stmt = $pdo->prepare("SELECT * FROM alps_problems_index AS apix
INNER JOIN
(
    SELECT 
    id
    FROM
    alps_problems_index
    ORDER BY RAND() 
    LIMIT 0 , 10
    ) AS randam
    
    ON (apix.id = randam.id)");
$status = $stmt->execute(); 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
<h1>読み書きテスト</h1>
<form method="post" action="answer.php">
<div class="container_1">
    <div class="container-jumbotron">
        <?php foreach($stmt as $q){?>
            <!-- nameでDBのidを指定することでradioボタンのグループ化 -->
            <input type="hidden" name="question[<?php echo $q["id"]?>]" value=<?php echo $q["id"]?>>
            <div class="problem"><?php echo $q['problem'];?></div>
            <div class="answer"><input type="radio" name="answer[<?php echo $q["id"]?>]" value="1"><?php echo $q['answer_1'];?></div>
            <div class="answer"><input type="radio" name="answer[<?php echo $q["id"]?>]" value="2"><?php echo $q['answer_2'];?></div>
            <div class="answer"><input type="radio" name="answer[<?php echo $q["id"]?>]" value="3"><?php echo $q['answer_3'];?></div>
            <div class="answer"><input type="radio" name="answer[<?php echo $q["id"]?>]" value="4"><?php echo $q['answer_4'];?></div>
    </div>
    <?php } ?>
    <div class="container answer"><input type="submit" name="submit" value="答え合わせ"></div>
</div>
</form>
    
</body>
</html>