<?php
class Foo{
	public function helloGateway(){
//		self::hello();  
//		自分自身を親に持つクラスのメソッドを参照できず、子クラスのオブジェクトでもhelloGateway()メソッドを呼び出した結果は、
//              'Foo hello!'になってしまう
		static::hello();
//              staticキーワードを使用することで、親クラスFooのhelloGateway()メソッドから子クラスBarのhello()メソッドを呼び出すことができる
	}

	public static function hello(){
		echo __CLASS__, ' hello!', PHP_EOL;
	}
}

class Bar extends Foo {
	public static function hello(){
		echo __CLASS__, 'hello', PHP_EOL;
	}
}

$bar = new Bar();
$bar->helloGateway();
?>
