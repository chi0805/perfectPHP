<?php

abstract class Application {
        protected $debug = false;
        protected $request;
        protected $response;
        protected $session;
        protected $db_manager;
        protected $login_action = array();

        public function __constract($debug = false) {
                $this -> setDebugMode($debug);
                $this -> initialize();
                $this -> configure();
        }

        //デバックモードに応じてエラー表示処理を変更する。
        protected function setDebbugMode($debug) {
                if ($debug) {
                        $this->debug = true;
                        ini_set('desplay_errors', 1);
                        error_reporting(-1);
                } else {
                        $this->debug = false;
                        ini_set('desplay_errors', 0);
                }
        }

        //クラスの初期化を行う。
        protected function initialize() {
                $this->request = new Request();
                $this->response = new Response();
                $this->session = new Session();
                $this->db_manager = new Dbmanager();
                $this->router = new Router($this->registerRoutes());
        }

        protected function configure() {

        }

        //ディレクトリ構成の変更に対応できるようにする。
        abstract public function getRootDir();

        abstract public function registerRoutes();

        public function isDebugMode() {
                return $this->debug;
        }

        public function getRequest() {
                return $this->request;
        }

        public function getResponse() {
                return $this->response;
        }

        public function getSession() {
                return $this->session;
        }

        public function getDbManager() {
                return $this->db_manager;
        }

        public function getControllerDir() {
                return $this->getRootDir() . '/controllers';
        }

        public function getViewDir() {
                return $this->getRootDir() . '/views';
        }

        public function getModelDir() {
                return $this->getRootDIr . '/models';
        }

        public function getWebDir() {
                return $this->getRootDIr . '/web';
        }

        //Routerクラスのresolve()メソッドを呼び出してルーティングパラメータを取得し、コントローラ名とアクション名を特定する。
        //それらの値を元に、runAction()メソッドを呼び出しアクションを実行する。
        //run()メソッドはアプリケーションがユーザーのリクエストに対応するためのトリガーとなるメソッド。
        public function run() {
                try {
                        $params = $this->router->resolve($this->request->getPathInfo());
                        if($params === false) {
                                // to-do A（ルーティングに一致しなかった場合の例外処理）
                                // 第一引数はエラーメッセージ。
                                throw new HttpNotFoundException('No route founr for' . $this->request->getPathInfo());
                        }

                        $controller = $params['controller'];
                        $action = $params['action'];

                        $this->runAction($controller, $action, $params);
                } catch (HttpNotFoundException $e){
                        $this->render404Page($e);

                } catch (UnauthorizedActionException $e){
                        //ログイン画面のアクションを実行する。
                        list($controller, $action) = $this->login_action;
                        $this->runAction($controller, $action;)
                }

                $this->response->send();
        }

        //実際にアクションを実行するメソッド。
        public function runAction($controller_name, $action, $parmas = array()) {
                $controller_class = ucfirst($controller_name) . 'Controller';
                $controller = $this->findController($controller_class);

                if ($controller === false) {
                        // to-do B（ルーティングに一致しなかった場合の例外処理）
                        throw new HttpNotFoundException($controller_class . 'controller is not found');
                }

                $content = $controller->run($action, $params);

                $this->response->setContent($content);
        }
        
        //コントローラークラスが読み込まれていない場合、クラスファイルの読み込みを行う。
        //クラスファイルの読み込みが完了したら、コントローラクラスを生成する。
        protected function findController($controller_class) {
                if (!class_exists($controller_class)) {
                        $controller_file = $this->getControllerDir . '/' . $controller_class . '.php';

                        if (!is_readable($controller_file)) {
                                return false;
                        } else {
                                require_once $controller_file;

                                if(!class_exists($controller_class)) {
                                        return false;
                                }
                        }
                }

                return new $controller_class($this);

        }

        protected function render404Page($e) {
                $this->response->setStatusCode(404, 'Not Found');
                $message = $this->isDebugMode() ? $e->getMessage() : 'Page not found.';
                $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

                $this->response->setContent(<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title>404</html>
</head>
<body>
        {$message}
</body>
</html>
EOF
                );
        }
}
?>
