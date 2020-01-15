<?php 
//指定したディレクトリ内のファイル一覧を出力するプログラム
if (isset($_GET['dir']) === true) {
    $dir = $_GET['dir'];
} else {
    $dir = '/';
}

//ディレクトリ内のファイル一覧を出力
echo "<pre>";
system('ls -la' . $dir);
echo "</pre>"

?>
