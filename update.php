<?php
//1. POSTデータ取得
$id = $_POST['id'];
$book_title = $_POST['book_title'];
$book_genre = $_POST['book_genre'];
$book_url = $_POST['book_url'];
$book_comment = $_POST['book_comment'];
$indate = $_POST['indate'];

//*** 外部ファイルを読み込む ***
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成⭐️⭐️⭐️
$stmt = $pdo->prepare("UPDATE gs_bm_table SET book_title=:book_title, book_genre=:book_genre, book_url=:book_url, book_comment=:book_comment WHERE id=:id");
$stmt->bindValue(':book_title', $book_title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_genre', $book_genre, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();// 実行

//解説
// 1行目： 今からこのSQL文を実行する準備をする(prepare)。VALUESには、:xxxを入れますよ
// 2行目： :nameには、1.POSTデータで取得した変数$nameを、文字列(PDO::PARAM_STR)としてくっつけます(baindValue)
// 3行目： :emailには、、、
// 4行目： :naiyouには、、、
// 5行目： $stmt(1〜4行目)を実行した結果を、表示するための変数を $status


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);

}else{
  //５．リダイレクト
  redirect("select.php");
  exit();
}
?>
