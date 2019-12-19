<?php
namespace Project\Module;
use Project\Module2 as AnotherModule;    //use...as...で名前空間に別名をつけてインポートできる

$obj = new AnotherModule\Someclass();

//名前空間だけでなくクラスもインポートできる
use \Directory;                          //use \Directory as Directory と等価であり、グローバルなクラスに'\'なしでアクセスできるようになる

$dir = new Directory('./');
?>
