<?php
//ClassLoaderをオートロードに登録する。
//このファイルを読み込むと、オートロードが設定される。

reqiore 'core/ClassLoader.php';

$loader = new ClassLoader();
//coreディレクトリとmodelsディレクトリをオートロードの対象とし、register()メソッドでオートロードに登録する。
$loader->registerDir(dirname(__FILE__).'/core');
$loader->registerDir(dirname(__FILE__).'/models');
$loader->register();

?>
