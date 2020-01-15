<?php 

//アップロードディレクトリは、ドキュメントルートの外側
$upload_dir = '/var/www/uploads';
if (empty($_FILES) === false && empty($_FILES['upfile']) === false) {
    if (is_uploaded_file($_FILES['upfile']['tmp_name']) === true) {
        move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            $upload_dir . date('YmdHis') . '_'
            .md5(microtime() . $_FILES['upfile']['tmp_name'])
        );
    //元のファイル名と保存したファイル名をDBなどに保存する
    //処理自体は省略
    //アップロード成功画面を出力
    echo <<<EOF
<html>
    <head>
        <title>アップロード成功</title>
    </head>
    <body>
        ファイルのアップロードに成功しました
    </body>
</html>
EOF;
    } else {
        echo 'ファイルのアップロード攻撃を受けた可能性があります';
        echo 'ファイル名'
            .htmlspecialchars($_FILES['upfile']['name'], ENT_QUOTES, 'UTF-8')
            . ' / ';
    }
}   

//ファイルアップロードフォームを出力
echo <<<EOF
<html>
    <head>
        <title>ファイルアップロード</title>
    </head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- 最大サイズ -->
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <input type="file" name="upfile" />
            <input type="submit" value="アップロード" />
        </form>
    </body>
</html>
EOF;
?>
