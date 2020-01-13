<?php 
session_start();

//セッション変数内のカウントが未設定の場合は0を設定
if (isset($_SESSION['count']) !== true) {
        $_SESSION['count'] = 0;
}

//出力するメッセージをセット
if (isset($_GET['keyword']) === true && $_GET['keyword'] !== '') {
        $_SESSION['count']++;
        $message = 'あなたが入力したキーワードは[' . $_GET['keyword'] . ']です。<br />';
} else {
        $message = 'あなたが入力したのは' . $_SESSION['count'] . '回目です。';
}

//キーワード入力フォームを出力
echo <<<EOF
<html>
    <head>
        <title>キーワード表示画面</title>
    </head>
    <body>
        {$message}<br />
        <br />
        <form action="">
            <input type="text" name="keyword" value="" />
            <input type="submit" value="投稿" />
        </form>
    </body>
</html>
EOF;
?>
