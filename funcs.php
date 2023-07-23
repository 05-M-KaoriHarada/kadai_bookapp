<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function db_conn(){
    try {
        //localhost（XAMMP）の場合
        $db_name = "gs_db";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト

        //localhost以外（さくらサーバーにデプロイする時）＊＊自分で書き直してください！！＊＊
        if($_SERVER["HTTP_HOST"] != 'localhost'){
            $db_name = "kaoriharada_gs_db";  //データベース名
            $db_id   = "kaoriharada";  //アカウント名（さくらコントロールパネルに表示されています）
            $db_pw   = "kaochi8897";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
            $db_host = "mysql57.kaoriharada.sakura.ne.jp"; //例）mysql**db.ne.jp...
        }
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }  
        //⭐️後で消す！！！！！
        //try~catchやってみてエラーが出たら表示する関数。
        //PDOは、3つの引数を指定する。('接続するmysqlの場所','root'(一番権限の強いユーザー名のこと),''(PWはXAMPPではブランクでOK)
        //Password:MAMP='root',XAMPP=''
        // 開発時用
        // $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
        
        // デプロイ時
    //     $pdo = new PDO('mysql:dbname=kaoriharada_gs_db;charset=utf8;host=mysql57.kaoriharada.sakura.ne.jp','kaoriharada','kaochi8897');
    // } catch (PDOException $e) {
    //     exit('DB Connection Error:'.$e->getMessage());
    // }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}


//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    // (変更前）header("Location: index.php");
    header("Location: ".$file_name);
}

