<?php

session_start();

if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
  }

// DB接続
require "funcs.php";
$pdo = db_conn();

// postで送られたデータの受け取り口
// それぞれ問題IDと答えた問題の回答番号を記述済
$q_no = filter_input(INPUT_POST,"question",FILTER_DEFAULT,FILTER_REQUIRE_ARRAY); 
$answer = filter_input(INPUT_POST,"answer",FILTER_DEFAULT,FILTER_REQUIRE_ARRAY); 
// var_dump($answer);

// var_dump($q_no);
// var_dump($answer);

$array_q_no = array();
foreach($q_no as $key=>$val){
    array_push($array_q_no, $val);
}

$array_answer = array();
foreach($answer as $key=>$val){
    array_push($array_answer, $val);
}

// var_dump($array_q_no);
// var_dump($array_answer);

// えふしんさんアドバイス
// 問題のIDと答えた問題のデータをもってきて、DBと突合して正解を照合すること
// sql文書くけど正しいのわからん。。、

$stmt = $pdo->prepare("SELECT
  subq_1.id
  ,subq_1.answer_results
  ,subq_1.right_answer
  FROM
  (
      SELECT
        id
        ,CASE
        WHEN right_answer = :user_answer_0
            THEN 'correct'
          ELSE 'incorrect'
        END AS answer_results
        ,right_answer
      FROM
        alps_problems_index
      WHERE
        id = :q_no_0
      UNION ALL
      
      SELECT
        id
        ,CASE
      WHEN right_answer = :user_answer_1
          THEN 'correct'
        ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
        alps_problems_index
      WHERE
        id = :q_no_1
      UNION ALL
      
      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_2
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_2
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_3
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_3
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_4
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_4
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_5
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_5
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_6
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_6
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_7
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_7
      UNION ALL

      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_8
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_8
      UNION ALL


      SELECT
      id
      ,CASE
      WHEN right_answer = :user_answer_9
      THEN 'correct'
      ELSE 'incorrect'
      END AS answer_results
      ,right_answer
      FROM
      alps_problems_index
      WHERE
      id = :q_no_9
) subq_1");


$stmt->bindValue(':q_no_0', $array_q_no[0], PDO::PARAM_INT);
$stmt->bindValue(':q_no_1', $array_q_no[1], PDO::PARAM_INT);
$stmt->bindValue(':q_no_2', $array_q_no[2], PDO::PARAM_INT);
$stmt->bindValue(':q_no_3', $array_q_no[3], PDO::PARAM_INT);
$stmt->bindValue(':q_no_4', $array_q_no[4], PDO::PARAM_INT);
$stmt->bindValue(':q_no_5', $array_q_no[5], PDO::PARAM_INT);
$stmt->bindValue(':q_no_6', $array_q_no[6], PDO::PARAM_INT);
$stmt->bindValue(':q_no_7', $array_q_no[7], PDO::PARAM_INT);
$stmt->bindValue(':q_no_8', $array_q_no[8], PDO::PARAM_INT);
$stmt->bindValue(':q_no_9', $array_q_no[9], PDO::PARAM_INT);

$stmt->bindValue(':user_answer_0', $array_answer[0], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_1', $array_answer[1], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_2', $array_answer[2], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_3', $array_answer[3], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_4', $array_answer[4], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_5', $array_answer[5], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_6', $array_answer[6], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_7', $array_answer[7], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_8', $array_answer[8], PDO::PARAM_INT);
$stmt->bindValue(':user_answer_9', $array_answer[9], PDO::PARAM_INT);

$status = $stmt->execute();
// SQL実行時にエラーがある場合STOP
if($status==false){
  sql_error($stmt);
  exit;
}


$aryInsert = [];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[0], 'user_answer' => $array_answer[0]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[1], 'user_answer' => $array_answer[1]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[2], 'user_answer' => $array_answer[2]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[3], 'user_answer' => $array_answer[3]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[4], 'user_answer' => $array_answer[4]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[5], 'user_answer' => $array_answer[5]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[6], 'user_answer' => $array_answer[6]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[7], 'user_answer' => $array_answer[7]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[8], 'user_answer' => $array_answer[8]];
$aryInsert[] = ['user_id' => $user_id, 'question_id' => $array_q_no[9], 'user_answer' => $array_answer[9]];
$arrayValues = "";
foreach ($aryInsert as $data) {
    $user_id   = $data['user_id'];
    $question_id = $data['question_id'];
    $user_answer = $data['user_answer'];
    $correct_answer = $data['correct_answer'];
    $arrayValues[] = "('{$user_id}', '{$question_id}', '{$user_answer}', '{$correct_answer}')";
}
$sql = "INSERT INTO hogeTable (user_id, question_id, user_answer, correct_answer, creata_at) VALUES " 
        .join(",", $arrayValues);

echo $sql;

$stmt2 = $pdo->prepare($sql);
$status2 = $stmt2->execute();
// SQL実行時にエラーがある場合STOP
if($status2==false){
    sql_error($stmt2);
    exit;
}  

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php foreach($stmt as $row) { ?>
    <div>
        <p>id<span>：</span><?php echo h($row['id']); ?></p>
    </div>
    <div>
        <p>answer_results<span>：</span><?php echo h($row['answer_results']); ?></p>
    </div>
    <div>
        <p>right_answer<span>：</span><?php echo h($row['right_answer']); ?></p>
    </div>
<?php } ?> 

    <h1>答え合わせ・解説</h1>
    <?php foreach($answer as $val){?>
    <p>あなたの答え<br>
    <?php echo htmlspecialchars($val);?>
    </p>
    <?php
    }
    ?>
</body>
</html>