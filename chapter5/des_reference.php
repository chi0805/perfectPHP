<?php
//ある変数への参照となっている変数に代入を行うと、参照の指し示す変数の値が変更される。
$a = 10;
$b = 20;
$ref =& $a;    //$refは$aの参照。
$ref=& $b;     //$refは$bの参照となる。
$ref = 30;
echo $a, PHP_EOL;
echo $b, PHP_EOL;



//配列の参照
function array_pass($array){
	$array[0] *= 2;
	$array[1] *= 2;
}

function array_pass_ref(&$array){
	$array[0] *= 2;
	$array[1] *= 2;
}

$a = 10;
$b = 20;
$array = array($a, &$b);
array_pass($array);
echo $a, PHP_EOL;  //10
echo $b, PHP_EOL;  //40
var_dump($array);  //array(10, 40)
//配列自体は値渡しで受け取っているためコピーされるが、
//参照で保持している要素はその参照自体がコピーされるため関数の中でも$bの参照を保持している。
//一方、要素が参照でない$aは値が変更されない。

$a = 10;
$b = 20;
$array = array($a, $b);
array_pass_ref($array);
echo $a, PHP_EOL;  //10
echo $b, PHP_EOL;  //20
var_dump($array);  //array(20, 40)
//配列自体は参照として受け取っているが、配列の持つ値はそれぞれ値として保持されているため、関数内での変更は外側の$a,$bには変更がない。



//オブジェクトの参照
//PHPでは、オブジェクトは参照でしか扱うことができない。

$a = new stdClass();
//$aはオブジェクトstdClass()の参照となっている。
//実際には、$aははオブジェクトstdClass()を表すIDを保持している。

?>
