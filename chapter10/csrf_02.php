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

//ワンタイムトークンを生成する関数
function get_token($key = '') {
    $_SESSION['key'] = $key;
    $token = sha1($key);
    return $token;
}

//ワンタイムトークンをチェックする関数
function check_token($token = '') {
    return ($token === sha1($_SESSION['key']));
}

//ワンタイムトークン生成用文字列
$Seed = 'secret';

//セッション開始
session_start();

//POSTだった場合は、指定された処理を実行。
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //管理者かチェック
    if(isset($_POST['op']) === true && $_POST['op'] === 'delete' && is_admin() == true) {
        //管理者ならばワンタイムトークンを確認
        if (isset($_POST['token']) === false || check_token($_POST['token']) === false) {
            //ワンタイムトークンは不正のため削除は行わない
            echo 'CSRF攻撃を受けた可能性があります';
        } else {
            //ワンタイムトークンが問題なければ削除処理を行う
            echo '記事の削除を行いました';
            //セッション内のワンタイムトークン文字列を削除
            unset($_SESSION['key']);
        }
    } elseif (isset($_POST['op']) ===true && $_POST['op'] === 'login') {
        //ログイン処理を実行。
        $_SESSION['is_admin'] = true;
        echo '管理者としてログインしました';
    } else {
        //管理者以外なのでエラー表示
        echo '権限がありません';
    }
}

//ワンタイムトークン取得
$key = $seed . '_' . microtime();
$token = get_token($key);

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
