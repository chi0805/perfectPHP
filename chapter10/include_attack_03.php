<?php 
//ホワイトリスト方式でファイルインクルード攻撃に対応

//nullバイトが含まれていた場合は処理終了
if (strpos($_GET['design'], "\0") !== false) {
    exit();
}

//[red.html],[blue.html]以外の読み込みがあったら処理終了
$allow_files = array('red', 'blue');
if (in_array($_GET['design'], $allow_files, true) === false) {
    exit();
}

//指定されたファイルをインクルード
include '/var/www/html/design' . $_GET['design'] . '.html';
?>
