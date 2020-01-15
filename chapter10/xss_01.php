<?php
//おみくじの結果をランダムに取得する。
$fortune = array(
    0 => '大吉',
    1 => '中吉',
    2 => '小吉',
    3 => '末吉',
    4 => '凶',
    5 => '大凶',
);

$key = rand(0,1);
if (isset($_GET['user_name'])) {
//攻撃可能となる。
//    echo $_GET['user_name'] . "さんの運勢は" . $fortune[$key] . "です。";
//エスケープを行う。
    echo htmlspecialchars($_GET['user_name'], ENT_QUOTES, UTF-8) . "さんの運勢は" . $fortune[$key] . "です。";
}

//おみくじ用フォームを出力。
echo '<form action="">';
echo 'お名前<input type="text" name="user_name" />';
echo '<input type="submit" value="占ってみる" />';
echo '</form>';

?>
