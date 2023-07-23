<?php
//1.DB接続*** 外部ファイルを読み込む ***
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table;");
$status = $stmt->execute();

//３．データ表示
$view="";
$view .= '<table border="1" id="fav-table">';
$view .= '<tr>
  <th>登録日</th><th>ジャンル</th><th>タイトル</th><th>書籍情報</th><th>感想</th><th> </th><th> </th>
  </tr>';

if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
    
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){   
    $view .= '<tr>';
    $view .= '<td>'.h($res['indate']).'</td>';
    $view .= '<td>'.h($res['book_genre']).'</td>';
    $view .= '<td>'.h($res['book_title']).'</td>';
    $view .= '<td><a href='.h($res['book_url']).'>Google Book</a></td>';
    $view .= '<td>'.h($res['book_comment']).'</td>';
    $view .= '<td><button><a href="detail.php?id='.h($res["id"]).'">';
    $view .= 'Update';
    $view .= '</a></button></td>';
    $view .= '<td><button class="delete-btn" data-id="' . h($res["id"]) . '">';
    $view .= 'Delete';
    $view .= '</button></td>';
    
    $view .= '</tr>';
  }
}

$view .= '</table>';

echo <<<EOM
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 削除ボタンクリック時の処理
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('本当に削除しますか？')) {
            location.href = 'delete.php?id=' + id;
        }
    });
});
</script>
EOM;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BOOKデータ表示</title>
<!-- <link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>

</html>
