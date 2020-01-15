<?php 
//リクエストの値をエスケープして出力するプログラム

phpinfo();
//GET変数名で指定があった場合は出力する$string変数にセット
if (isset($_GET['string']) === true) {
    $string = $_GET['string'];
} else {
    $string = '';
}

//$string変数をエスケープして出力
echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
?>
