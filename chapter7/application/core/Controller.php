<?php

//このフレームワークでは、アクションはControllerクラスに実装されたメソッドに当たる。
//アクションにあたるメソッド名は「アクション名 + Action()」というルールで扱う。
abstract class Controller {
        protected $controller_name;
        protected $action_name;
        protected $application;
        protected $request;
        protected $response;
        protected $session;
        protected $db_manager;

        public function __constract($Application) {
                //コントローラ名をクラス名から逆算してプロパティに設定。
                //クラス名の後ろの"Controller"を取り除き、小文字にする。
                $this->controller_name = strtolower(substr(get_class($this), 0, -10));

                $this->application = $application;
                $this->request = $application->getRequest();
                $this->response = $application->getResponse();
                $this->session = $application->getSession();
                $this->db_manager = $application->getDbManager();
        }

        public function run($action, $params = array()) {
                $this->action_name = $action;

                //アクションとなるメソッド名を$action_methodに格納し、メソッドが存在しているかチェック。
                //存在している場合、404エラーの画面へ遷移。
                $action_method = $action . 'Action';
                if(!method_exists($this, $action_method)) {
                        $this->forward404();
                }

                //アクションを実行する。
                $content = $this->actionmethod($params);

                return $content;
        }
}
?>
