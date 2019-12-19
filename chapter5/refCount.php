<?php
//リファレンスカウントとは、あるオブジェクトを指し示す変数(参照)がいくつあるかを記録し、
//参照数が変化する度にその値を更新する変数を更新する。参照数がゼロになったとき、new演算子でインスタンス化されたオブジェクトは破棄される。
class RefClass{
	public function __construct(){
		echo __CLASS__, 'が生成されました', PHP_EOL;
	}

	public function __destruct(){
		echo __CLASS__, 'が生成されました', PHP_EOL;
	}
}

echo '** プログラム開始', PHP_EOL;
echo '** new RefClass()', PHP_EOL;
$a = new RefClass();                    //リファレンスカウントは1
echo '** $b = $a', PHP_EOL;
$b = $a;                                //リファレンスカウントは2
echo '** unset $a', PHP_EOL;
unset($a);                              //リファレンスカウントは1
echo '** unset $b', PHP_EOL;
unset($b);                              //リファレンスカウントは0となりオブジェクトが破棄される
echo '**プログラム終了', PHP_EOL;

?>
