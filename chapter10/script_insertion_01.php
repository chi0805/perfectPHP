<?php 

function get_post_data($id = 0) {
    $post_data = array(
        1 => '1件目の投稿です。特に問題ありません。',
        2 => '2件目のデータです。<script>alert("攻撃を受けました");</script>',
    );
    if(isset($post_data[$id]) === true) {
        return $post_data[$id];
    }

    return '投稿データがありません';
}

//投稿データを取得
if (isset($_GET['id']) === true) {
    $id = intval($_GET['id']);
} else {
    $id = 1;
}

//$post_data = get_post_data($id); //攻撃を受けるコード
$post_data = htmlspecialchars(get_post_data($id), ENT_QUOTES, 'UTF-8'); //エスケープを行い、攻撃を無害化。

//取得情報の出力
echo <<<EOF
<html>
    <head>
       <title>投稿データの表示画面</title>
    </head>
    <body>
        <fieldset>
            <legend>{$id}件目の投稿データ</legend>
            $post_data
        </fieldset>
    </body>
</html>
EOF;
?>
