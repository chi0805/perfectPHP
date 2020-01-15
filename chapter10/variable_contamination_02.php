<?php 

//ブラックリストとしてスーパーグローバル変数の変数名を設定
$black_list = array('GLOBALS', '_SERVER', '_GET', '_POST', '_FILES', '_COOKIES', '_REQUEST', '_SESSION', '_ENV');

//リクエストのキーがスーパーグローバル変数の変数名なら終了
foreach (array($_GET, $_POST, $_COOKIE) as $request) {
    foreach ($black_list as $super_global) {
        if (isset($request[$super_global]) === true) {
            exit();
        }
    }
}

//register_globalsの対応として、GET変数を展開する
foreach ($_GET as $key => $value) {
    $$key = $value;
}

//GET変数を利用した処理:開始
//...
//GET変数を利用した処理:終了

echo 'あなたのIPアドレスは"' . $_SERVER['REMOTE_ADDR'] . '"です';
?>
