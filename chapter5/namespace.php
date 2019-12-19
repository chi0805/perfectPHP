<?php
//名前空間とは、クラスや関数の使える名前の集合を定義し、関数やクラス名の衝突を防いだり
//機能の参照をわかりやすくするための機能（ディレクトリのようなもの）

namespace Project\Module;

class Directory{};                //Project\Module\Directory クラス
function file(){};                //Project\Module\file 関数
const E_ALL = 0x01;               //Project\Module\E_ALL 定数
$var = 0x01;                      //変数に名前空間は適応されない
//名前空間の中ではPHPによって定義済みのクラス名や関数名を使用することができる

$dir = new Directory;                //同じ名前空間内では名前空間を省略できる
$dir = new Project\Module\Directory; //グローバルからの指定も可能


?>
