<?php
//ユーザーのリクエスト情報を制御する。
class Request {
        public function isPost(){
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        return true;
                }

                return false;
        }

        public function getGet($name, $default = null){
                if(isset($_GET['name'])) {
                        return $_GET['name'];
                }

                return $default;
        }

        public function getPost($name, $default = null){
                if (isset($_POST['name'])) {
                        return $_POST['name'];
                }

                return $defalut;
        }

        public function getHost(){
                //$_SERVER['HTTP_HOST']にはHTTPリクエストヘッダに含まれるホストの値が格納されている。
                if (empty($_SERVER['HTTP_HOST'])) {
                        return $_SERVER['HTTP_HOST'];
                }
                
                //リクエストヘッダに含まれていない場合、Apacheに設定されたホスト名が格納されている$_SERVER['SERVER_NAME']の値を返す。
                return $_SERVER['SERVER_NAME'];
        }

        //HTTPSでアクセスされたかどうかを判定する。$_SERVER['HTTPS']の値が'on'の時、HTTPSでアクセスされている。
        public function isSsl(){
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                        return true;
                }

                return false;
        }

        //リクエストされたURLのホスト部分以降の値が$_SERVER['REQUEST_URI']に格納されている。
        public function getRequestUri(){
                return $_SERVER['REQUEST_URI'];
        }
        
        //
        public function getBaseUri(){
                $script_name = $_SERVER['SCRIPT_NAME'];

                $request_uri = $this->getRequestUri();

                //フロントコントローラーがURLに含まれる場合は、SCRIPT_NAMEの値がベースURLと同じになる
                if(0 === strpos($request_uri, $script_name)) {
                        return $script_name;
                //フロントコントローラーが省略されている場合、SCRIPT_NAMEからフロントコントローラーファイルを省略した値を取得し、
                //右側に続くスラッシュを削除する
                } else if (0 === strpos($request_uri, dirname($script_name))) {
                        return rtrim(dirname($script_name, '/'));
                }

                return '';
        }

        public function getPathInfo(){
                $base_url = $this->getBaseUri();

                $request_uri = $this->getRequestUri();

                //REQUEST_URIに含まれるゲットパラメータを取り除く。
                if (false != ($pos = strpos($request_uri, '?'))) {
                        $request_uri = substr($request_uri, 0, $pos);
                }

                $path_info = (string)substr($request_uri, strlen($baseurl));

                return $path_info;

        }

}

?>
