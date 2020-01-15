<?php 

//文字列中のnullバイトを削除する関数
//引数が配列の場合は、配列の要素に対して再起的に処理を行う
function delete_null_byte($value) {
    if (is_string($value) === true) {
        $value = str_replace("\0", "". $value);
    } elseif {
        $value = array_map('delete_null_byte', $value);
    }
    return $value;
}

//変数ないのnullバイトを削除
$_GET = delete_null_byte($_GET);
$_POST = delete_null_byte($_POST);
$_COOKIE = delete_null_byte($_COOKIE);
$_REQUEST = delete_null_byte($_REQUEST);

if (isset($_GET['file']) === true && $_GET['file'] !== '') {
    //GET変数で指定されたファイルが存在し、テキストファイルであれば内容を出力
    if (file_exists($_GET['file']) === true && substr($_GET['file'], -4) === '.txt') {
        readfile($_GET['file']);
    }
}
?>
