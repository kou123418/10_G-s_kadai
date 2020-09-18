<?php

ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);

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
  ,subq_1.user_answer
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
        ,:user_answer_0 AS user_answer
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
        ,:user_answer_1 AS user_answer
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
        ,:user_answer_2 AS user_answer
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
        ,:user_answer_3 AS user_answer
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
        ,:user_answer_4 AS user_answer
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
        ,:user_answer_5 AS user_answer
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
        ,:user_answer_6 AS user_answer
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
        ,:user_answer_7 AS user_answer
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
        ,:user_answer_8 AS user_answer
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
        ,:user_answer_9 AS user_answer
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

$count = $stmt->rowCount();
//echo $count;
$i = 0;
$make_sql = '';
$make_sql = 'INSERT INTO alps_user_answer_table (user_id, question_id, user_answer, correct_answer, create_at) VALUES ';
foreach($stmt as $row) {
  $i++;
  if ($count == $i) {
  // 配列最後の場合
    $make_sql .= '('. $user_id . ',' . $row['id'] . ',' . $row['user_answer'] . ',' . $row['right_answer'] . ',sysdate());';
  } else {
    $make_sql .= '('. $user_id . ',' . $row['id'] . ',' . $row['user_answer'] . ',' . $row['right_answer'] . ',sysdate()),';
  }
}
echo $make_sql;


// var_dump($aryInsert);

// INSERT文を変数に格納
// $sql = "INSERT INTO citys (name, population, created) VALUES (:name, :population, now())";

// $sql2 = "INSERT INTO alps_user_answer_table (user_id, question_id, user_answer, correct_answer) VALUES
// (:tmp_user_id, :tmp_question_id, ,:tmp_user_answer, :tmp_correct_answer)";

// var_dump($sql2);

// 挿入する値は空のまま、SQL実行の準備をする
// $stmt2 = $pdo->prepare($make_sql);

// 挿入する値を連想配列に格納する
//$arrayValues = array('user_id' => $user_id, 'question_id' => $row['id'], 'user_answer' => $row['user_answer'], 'correct_answer' => $row['right_answer']);
//$arrayValues = array('座間'=>129400, '綾瀬'=>84000);

// foreachで挿入する値を1つずつループ処理
// foreach ($arrayValues as $key => $val) {
//    // 連想配列のキーを :name に、値を :population にセットし、executeでSQLを実行
//   $stmt2->execute(array(':name' => $key, ':population' => $val));
// }

// 回答履歴データ登録用INSERT文生成
//$arrayValues = "";
// foreach ($aryInsert as $data) {
//   var_dump($data);
//   // $tmp_user_id   = $data['user_id'];
//   // $tmp_question_id = $data['question_id'];
//   // $tmp_user_answer = $data['user_answer'];
//   // $tmp_correct_answer = $data['correct_answer'];
//   // $tmp_create_at = 'sysdate()';
// //  $stmt2->execute(array(':name' => $key, ':population' => $val));
// $status2 = $stmt2->execute(array(':tmp_user_id' => (int)$data['user_id'], ':tmp_question_id' => (int)$data['question_id'], ':tmp_user_answer' => (int)$data['user_answer'], ':tmp_correct_answer' => (int)$data['correct_answer']));
// if($status2==false){
//   sql_error($stmt2);
//   exit;
// } 
// }
// foreach ($aryInsert as $data) {
//   // $tmp_user_id   = $data['user_id'];
//   // $tmp_question_id = $data['question_id'];
//   // $tmp_user_answer = $data['user_answer'];
//   // $tmp_correct_answer = $data['correct_answer'];
//   // $tmp_create_at = 'sysdate()';
// //  $stmt2->execute(array(':name' => $key, ':population' => $val));
//   $stmt2->bindValue(':tmp_user_id', $data['user_id'], PDO::PARAM_INT);
//   $stmt2->bindValue(':tmp_question_id', $data['question_id'], PDO::PARAM_INT);
//   $stmt2->bindValue(':tmp_user_answer', $data['user_answer'], PDO::PARAM_INT);
//   $stmt2->bindValue(':tmp_correct_answer', $data['correct_answer'], PDO::PARAM_INT);
//   $stmt2->execute(array(':tmp_user_id', ':tmp_question_id', ':tmp_user_answer', ':tmp_correct_answer'));
// //  $stmt2->execute(array(':tmp_user_id' => $data['user_id'], ':tmp_question_id' => $data['question_id'], ':tmp_user_answer' => $data['user_answer'], ':tmp_correct_answer' => $data['correct_answer']));
// if($status2==false){
//   sql_error($stmt2);
//   exit;
// } 
// }


// 挿入する値を連想配列に格納する
//$arrayValues = array('user_id' => $user_id, 'question_id' => $row['id'], 'user_answer' => $row['user_answer'], 'correct_answer' => $row['right_answer']);
//$arrayValues = array('座間'=>129400, '綾瀬'=>84000);
// foreachで挿入する値を1つずつループ処理
// foreach ($arrayValues as $key => $val) {
//    // 連想配列のキーを :name に、値を :population にセットし、executeでSQLを実行
//   $stmt2->execute(array(':name' => $key, ':population' => $val));
// }
// 回答履歴データ登録用INSERT文生成
//$arrayValues = "";
//foreach ($aryInsert as $data) {
  // $tmp_user_id   = $data['user_id'];
  // $tmp_question_id = $data['question_id'];
  // $tmp_user_answer = $data['user_answer'];
  // $tmp_correct_answer = $data['correct_answer'];
  // $tmp_create_at = 'sysdate()';
//  $stmt2->execute(array(':name' => $key, ':population' => $val));
  // $stmt2->bindValue(':tmp_user_id', $data['user_id'], PDO::PARAM_INT);
  // $stmt2->bindValue(':tmp_question_id', $data['question_id'], PDO::PARAM_INT);
  // $stmt2->bindValue(':tmp_user_answer', $data['user_answer'], PDO::PARAM_INT);
  // $stmt2->bindValue(':tmp_correct_answer', $data['correct_answer'], PDO::PARAM_INT);
  // $stmt2->execute(array(':tmp_user_id', ':tmp_question_id', ':tmp_user_answer', ':tmp_correct_answer'));
//  $stmt2->execute(array(':tmp_user_id' => $data['user_id'], ':tmp_question_id' => $data['question_id'], ':tmp_user_answer' => $data['user_answer'], ':tmp_correct_answer' => $data['correct_answer']));


//}

$stmt2 = $pdo->prepare($make_sql);
$status2 = $stmt2->execute();
// SQL実行時にエラーがある場合STOP
if($status2==false){
    sql_error($stmt2);
    exit;
}  

$analysis = $pdo->prepare("SELECT
  subq_2.answer_results
  ,subq_2.score
  FROM(
    SELECT
    
  )
")

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php foreach($stmt as $row_1) { ?>
    <div>
        <p>id<span>：</span><?php echo h($row_1['id']); ?></p>
    </div>
    <div>
        <p>answer_results<span>：</span><?php echo h($row_1['answer_results']); ?></p>
    </div>
    <div>
        <p>right_answer<span>：</span><?php echo h($row_1['right_answer']); ?></p>
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