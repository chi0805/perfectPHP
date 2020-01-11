<?php
class ClassLoader{
        protected $dirs;

        //PHPにオートローダークラスを登録する処理。
        //sql_autoload_register()関数に設定したコールバックが、オートロード時に呼び出される。
        public function register(){
                spl_autoload_register(array($this, 'loadClass'));
        }
        
        //このメソッドの引数には、オートロードの対象とするディレクトリへのフルパスを指定する。
        public function registerDir($dir){
                $this->dirs[] = $dir;
        }
        
        //このメソッドは、オートロード時にPHPから自動的に呼び出され、クラスファイルの読み込みを行う。
        public function loadClass($class){
                //クラス名のファイルを探し、そのファイルが見つかればrequireで読み込む。
                foreach($this->dirs as $dir){
                        $file = $dir . '/' . $class . '.php';
                        
                        if (is_readable($file)){
                                require $file;
                                
                                return;
                        }
                }
        }
} 


?>
