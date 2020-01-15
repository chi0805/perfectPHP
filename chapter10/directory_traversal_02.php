<?php 
//ホワイトリストでディレクトリトラバーサルに対応(許可するファイルが少ない場合に有効)
if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    //指定されたファイルがfile1かfile2でなければ処理終了
    if (! in_array($_GET['file'], array('file1', 'file2'))) {
        exit();
    }
    //GET変数で指定されたファイルが/var/www/studyに存在すれば内容を出力
    $file = '/var/www/study/' . $_GET['file'];
    if (file_exists($file) === true) {
        readfile($file);
    }
}
?>
