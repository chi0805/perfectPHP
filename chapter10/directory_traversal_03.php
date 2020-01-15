<?php 
//ブラックリストでディレクトリトラバーサルに対応
//(運用中にアクセス許可するファイルが増えていく場合、プログラムを改修する手間を省くことができる)
if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    //指定されたファイル名に「..」が含まれていたら即終了
    if (strpos($_GET['file'], '..') !== false) {
        exit();
    }
    //GET変数で指定されたファイルが/var/www/studyに存在すれば内容を出力
    $file = '/var/www/study/' . $_GET['file'];
    if (file_exists($file) === true) {
        readfile($file);
    }
}
?>
