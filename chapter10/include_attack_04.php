<?php 

//basename()関数はバイナリセーフではないため、nullバイト対応を行う
if (strpos($_GET['design'], "\0") !== false) {
    exit();
}

//指定されたファイルをインクルード
//basename()関数で不正文字列を除去してインクルードを行う
include '/var/www/html/design/' . basename($_GET['design']) . '.html';
?>
