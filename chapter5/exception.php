<?php
function div($v1, $v2){
	if ($v2 == 0){
		throw new Exception("arg #2 is zero");
	}
	return $v1/$v2;
}

try{
	echo div(1,2), PHP_EOL;
	echo div(1,0), PHP_EOL;            //例外が発生しcatch文に飛ぶため、これ以降の処理は実行されない
	echo div(2,1), PHP_EOL;
}catch(Exception $e){
	echo 'Exception!', PHP_EOL;
	echo $e->getMessage(), PHP_EOL;
}



//作成したライブラリやアプリケーション独自の例外を作成できる
//このような場合、Exceptionクラスを継承した例外クラスを作成するとその例外を投げることができるようになる
class ZeroExceptionError extends Exception{

}
function div($v1, $v2){
	if($v2 == 0){
		throw new ZeroDivisionException("arg #2 is zero.");   //例外を投げるコード
	}
	return $v1/$v2;
}
try{
        echo div(1,2), PHP_EOL;
        echo div(1,0), PHP_EOL;
        echo div(2,1), PHP_EOL;
}catch (ZeroDivisionException $e){
	echo 'ZeroDivisionException!', PHP_EOL;
	echo $e->getMessage(), PHP_EOL;
}catch (Exception $e){
	echo $e->getMessage(), PHP_EOL;
}
?>
