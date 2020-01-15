<?php 
//不正文字列除去方式でディレクトリトラバーサルに対応
//(ブラックリストとは異なり、階層構造を含めることができないが、特定のディレクトリ以外への想定外のアクセスを防ぐことができる
if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    $file = str_replace("\0", "", $_GET['file']);  //nullバイトを削除
    $file = '/var/www/study/' . basename($file);   //ファイル名以外の部分を削除
    //GET変数で指定されたファイルが/var/www/studyに存在すれば内容を出力
    if (file_exists($file) === true) {
        readfile($file);
    }
}
?>
