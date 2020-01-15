<?php 

if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    //GET変数で指定されたファイルが存在し、テキストファイルであれば内容を出力
    if (file_exists($_GET['file']) === true && substr($_GET['file'], -4) === '.txt') {
        readfile($_GET['file']);
    }
}
?>
