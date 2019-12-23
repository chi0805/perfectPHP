<?php
//DBに接続

$link = mysqli_connect('localhost', 'root', 'Sql23021705@');
if(!$link){
  die('DBに接続できません' . mysql_error());
}

//DBを選択する
mysqli_select_db($link, 'online_bbs');

$errors = array();

//POSTなら保存処理実行
//HTTPメソッドは処理するPHP側でも必ず判定を行う
if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //名前が正しく入力されているかチェック
        $name = null;
        if (!isset($_POST['name']) || !strlen($_POST['name'])) {
                $errors['name'] = '名前を入力してください';
        } else if (strlen($_POST['name']) > 40){
                $errors['name'] = '名前は40文字以内で入力してください';
        } else {
                $name = $_POST['name'];
        }

        //一言が正しく入力されているかチェック
        $comment = null;
        if (!isset($_POST['comment']) || !strlen($_POST['comment'])) {  //文字列が空のときは、strlen()の値は0となりfalseになる
                $errors['comment'] = 'ひとことを入力してください';
        } else if (strlen($_POST['comment'] > 200 )) {
                $errors['comment'] = 'ひとことは200文字以内で入力してください';
        } else {
                $comment = $_POST['comment'];
        }

        //エラーがなければ保存
        if(count($errors) === 0) {
                //保存するためのsql文を作成
                $sql = "INSERT INTO `post` (`name`, `comment`, `created_at`) VALUES ('"
                    //SQLインジェクション対策として、エスケープを実行する
                    . mysqli_real_escape_string($link, $name) . "', '"
                    . mysqli_real_escape_string($link, $comment) . "', '"
                    . date('Y-m-d H:i:s') . "')";
                //保存する
                mysqli_query($link, $sql);
                
                //接続を閉じる
                mysqli_close($link);

                //リダイレクト
                header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
}

$sql = "SELECT * FROM `post` ORDER BY `created_at` DESC";
$result = mysqli_query($link, $sql);

//取得した結果を$postsに格納
$post = array();
if ( $result !== false && mysqli_num_rows($result)) {
        while ($post = mysqli_fetch_assoc($result)) {
                $posts[] = $post;
        }
}
//取得結果を開放して接続を閉じる
mysqli_free_result($result);
mysqli_close($link);

include 'views/bbs_view.php';

?>
