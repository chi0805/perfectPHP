<?php 

//register_globalsの対応として、GET変数を展開する
foreach ($_GET as $key => $value) {
    $$key = $value;
}

//GET変数を利用した処理:開始
//...
//GET変数を利用した処理:終了

echo 'あなたのIPアドレスは"' . $_SERVER['REMOTE_ADDR'] . '"です';

?>
