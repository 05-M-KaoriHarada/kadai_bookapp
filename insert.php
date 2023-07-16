<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$book_title = $_POST['book_title'];
$book_genre = $_POST['book_genre'];
$book_url = $_POST['book_url'];
$book_comment = $_POST['book_comment'];


//2. PHP側からDB接続する下準備！(いまからここのDBに指示を出すよ、このDBのSQL文を実行してくださいね、と言う指示)
try {   //try~catchやってみてエラーが出たら表示する関数。
  //PDOは、3つの引数を指定する。('接続するmysqlの場所','root'(一番権限の強いユーザー名のこと),''(PWはXAMPPではブランクでOK)
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB Connection Error:'.$e->getMessage());
}


//３．データ登録SQL作成⭐️⭐️⭐️
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(book_title,book_genre,book_url,book_comment,indate)VALUES(:book_title, :book_genre, :book_url, :book_comment, sysdate());");
$stmt->bindValue(':book_title', $book_title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_genre', $book_genre, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//解説
// 1行目： 今からこのSQL文を実行する準備をする(prepare)。VALUESには、:xxxを入れますよ
// 2行目： :nameには、1.POSTデータで取得した変数$nameを、文字列(PDO::PARAM_STR)としてくっつけます(baindValue)
// 3行目： :emailには、、、
// 4行目： :naiyouには、、、
// 5行目： $stmt(1〜4行目)を実行した結果を、表示するための変数を $status


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: success.php");
  exit();

}
?>
