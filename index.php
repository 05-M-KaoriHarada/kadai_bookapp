<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <style>
    div{padding: 10px;font-size:16px;}
    .name{width: 150px}
    .author{width: 100px}
    .url{width: 300px}
    img{width: 50px}
  </style>

</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>お気に入りBOOK管理DB</legend>
     <label>タイトル：<input type="text" name="book_title"></label><br>
     <label>ジャンル:<input type="text" name="book_genre"></label><br>
     <label>Google BooksのURL:<input type="text" name="book_url"></label><br>
     <label>感想:<textArea name="book_comment" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="登録">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

<!-- URL検索 -->
<div>
  <p>URL検索</p>
  <input type="text" id="key">
  <button id="send">検索</button>
</div>

<table border="1" id="list">
  <tr>
    <td class="name">書籍名</td>
    <td class="author">著者</td>
    <td class="thum">表紙</td>
    <td class="url">URL</td>
  </tr>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
  $("#list").hide();

  $("#send").on("click", function(){
    $("#list").show();
    const url = "https://www.googleapis.com/books/v1/volumes?q=" + $("#key").val();

    $.ajax({
      url: url,
      dataType: "json"
    }).done(function(data) {
      let html = "";
      for (let i = 0; i < data.items.length; i++) {
        const book = data.items[i];
        const title = book.volumeInfo.title;
        const authors = book.volumeInfo.authors;
        const thumbnail = book.volumeInfo.imageLinks.thumbnail;
        const infoLink = book.volumeInfo.infoLink;

        html += `
          <tr>
            <td>${title}</td>
            <td>${authors}</td>
            <td><img src="${thumbnail}"></td>
            <td>
              <button class="copy-button">URLコピー</button>
              <span class="url">${infoLink}</span>
            </td>
          </tr>
        `;
      }
      $("#list").append(html);

      // 「URLコピー」ボタンをクリックした際にURLをコピーする処理を追加
      $(".copy-button").on("click", function() {
        const url = $(this).siblings(".url").text();
        copyToClipboard(url);
      });
    });
  });

  // テキストをクリップボードにコピーする関数
  function copyToClipboard(text) {
    const tempInput = $("<input>").val(text).appendTo("body").select();
    document.execCommand("copy");
    tempInput.remove();
    alert("URLがコピーされました: " + text);
  }
</script>

</body>
</html>
