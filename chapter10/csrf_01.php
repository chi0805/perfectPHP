<?php 

//管理者かチェックする関数
function ia_admin() {
    if (isset($_SESSION['is_admin']) === true && $_SESSION['is_admin'] === true) {
        $is_admin = true;
    } else {
        $is_admin = false;
    }
    return $is_admin;
}

//セッション開始
session_start();

//POSTだった場合は、指定された処理を実行。
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //管理者かチェック
    if(isset($_POST['op']) === true && $_POST['op'] === 'delete' && is_admin() == true) {
        //管理者ならば削除を行う。
        echo '記事の削除を行いました。';
    } elseif (isset($_POST['op']) ===true && $_POST['op'] === 'login') {
        //ログイン処理を実行。
        $_SESSION['is_admin'] = true;
        echo '管理者としてログインしました';
    } else {
        //管理者以外なのでエラー表示
        echo '権限がありません';
    }
}

//記事削除画面を表示
echo <<<EOF
<html>
    <head>
        <title>記事削除画面</title>
    </head>
    <body>
        <fieldset>
            <legend>管理者ログインフォーム</legend>
            <form action="" method="post">
                <input type="hidden" name="op" value="login" />
                <input type="submit" value="管理者としてログインする" />
            </form>
        </fieldset>
        <fieldset>
            <legend>記事削除フォーム</legend>
            <form action="" method="post">
                <input type="hidden" name="op" value="delete" />
                <input type="submit" value="記事を削除" />
            </form>
        </fieldset>
    </body>
</html>
EOF;

?>
