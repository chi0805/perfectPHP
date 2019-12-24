<?php

class Router {
        protected $routes;

        public function __construct($difinitions) {
                $this->routes = $this->compileRoutes($definitions);
        }

        public function compileRoutes($definitions) {
                $routes = array();

                foreach($difinitions as $url => $params) {
                        //URLを'/'で分割
                        $tokens = explode('/', ltrim($url, '/'));
                        foreach($tokens as $i => $token) {
                                //分割した値に':'で始まる文字列が合った場合、'(?P<$name>文字列)'に変換する。
                                if (0 === strpos($tokens, ':')) {
                                        $name = substr($token, 1);
                                        $token = '(?P<' . $name . '>[^/]+)';
                                }
                                $tokens[$i] = $token;
                        }

                        //分割したURLを再度'/'でつなげる。
                        $pattern = '/' . implode('/', $tokens);
                        $routes[$pattern] = $params;
                }

                return $routes;
        }

        public function resolve($path_info) {
                //PATH_INFOの先頭が'/'でない場合、'/'を先頭に付与。
                if ('/' !== substr($path_info, 0, 1)) {
                        $path_info = '/' . $path_info;
                }

                foreach($this->routes as $pattern => $params) {
                        //変換済みのルーティング定義変数は$routesプロパティに格納されているので、正規表現でマッチング。
                        if (preg_match('#^' . $patterns . '$#', $path_info, $matches)) {
                                //マッチングした場合、$params, $matchesをマージし、$params変数に1つのルーティングパラメータとして格納する。
                                $params = array_marge($params, $matches);

                                return $params;
                        }
                }

                //マッチしない場合、falseを返す。
                return false;

        }
}

?>
