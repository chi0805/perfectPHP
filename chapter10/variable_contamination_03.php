<?php 

//ホワイトリストとして、利用するGET変数のキーを設定(何らかの手段で、リストアップを自動化する必要がある)
$white_list = array('foo', 'bar');
//register_globalsの対応として、GET変数を展開する
foreach ($_GET as $key => $value) {
    //GET変数のキーがホワイトリストに含まれていなければ終了
    if (in_array($key, $white_list) === false) {
        exit();
    }
    $$key = $value;
}

//GET変数を利用した処理:開始
//...
//GET変数を利用した処理:終了

echo 'あなたのIPアドレスは"' . $_SERVER['REMOTE_ADDR'] . '"です';
?>
