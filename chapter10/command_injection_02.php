<?php 
//外部コマンドへの引数をエスケープしてコマンド実行攻撃に対応

//一覧を出力するディレクトリを$dir変数にセット
if (isset($_GET['dir']) === true) {
    //nullバイトを削除
    $dir = str_replace("\0", '', $_GET['dir']);
} else {
    $dir = '/';
}

//ディレクトリ内のファイル一覧を出力
echo "<pre>";
if (file_exists($dir) && is_dir($dir)) {
    //外部コマンドへの引数をエスケープして実行
    system('ls -la' . escapeshellarg($dir));

}
echo "</pre>"

?>
