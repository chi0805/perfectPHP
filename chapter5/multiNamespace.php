<?php
//1つのファイルに複数の名前空間を定義するには、2つの方法がある


//1つ目は、単純にnamespaceの宣言をする方法
namespace Project\Module;
//ここは、Project\Module 名前空間の中
class Directory{};

namespace Project\Module2;
//ここは、Project\Module2 名前空間の中
class Directory{};


//もう1つは、{}で囲む方法
namespace Project\Module3{
//ここは、Project\Module3 名前空間の中
class Directory{};
}
namespace Project\Module4{
//ここは、Project\Module4 名前空間の中
class Directory{};
}




?>
