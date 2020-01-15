<?php 
//プログラム内でエラーレポートの設定を行い脆弱性に対応

//エラーレポートの設定を最初に行う
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php/php_error.log');

//GET変数名で指定があった場合は出力する$string変数にセット
if (isset($_GET['string']) === true) {
    $string = $_GET['string'];
} else {
    $string = '';
}

//$string変数をエスケープして出力
echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
?>
