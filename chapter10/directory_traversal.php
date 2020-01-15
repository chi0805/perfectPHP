<?php 

if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    //GET変数で指定されたファイルが/var/www/studyに存在すれば内容を出力
    $file = '/var/www/study/' . $_GET['file'];
    if (file_exists($file) === true) {
        readfile($file);
    }
}
?>
