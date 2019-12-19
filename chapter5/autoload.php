<?php
//autoloadとは、クラスを必要な時に読み込むための仕組み

function __autoload($name){
	$filename = $name . '.php';
	if(is_readable($filename)){
		require $filename;
	}
}

$obj = new Foo();
//Fooをnewしているが、Fooのクラスが定義されていないため、__autoload()関数がFooを引数として呼び出される
//Foo.phpというファイルが存在したら、requireされる
?>
