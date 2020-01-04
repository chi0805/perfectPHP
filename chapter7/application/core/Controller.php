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

        public function __construct($Application) {
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

        protected function render($variables = array(), $template = null, $layout = 'layout') {
                //Viewクラスのコンストラクタの第二引数に指定するデフォルト値の連想配列を指定する。
                $defaults = array(
                        'request' => $this->request,
                        'base_url' => $this->request->getBaseUrl(),
                        'session' => $this->session,
                );

                $view = new View($this->application->getViewDir(), $defaults);

                //$template変数がnullの場合、アクション名をファイル名とする。
                if(is_null($template)) {
                        $template = $this->action_name;
                }

                $path = $this->controller_name . '/'. $template;

                //ビューファイルの読み込みを行う。
                return $view->render($path, $variables, $layout);
        }

        //アクション内でリクエストされた情報が存在しない場合、このメソッドを呼び出してエラー画面に遷移する。
        protected function forward404() {
                throw new HttpNotFoundException('Forwarded 404 page from' . $this->controller_name . '/' . $this->action_name)
        }

        //Responseオブジェクトにリダイレクトする。
        //同じアプリケーション内で別アクションのリダイレクトを行う場合、PATH_INFOの部分のみ指定すればよい。
        protected function redirect($url) {
                if(!preg_match('#https?://#', $url)){
                        $protocol = $this->request->isSsl ? 'https://' : 'http://';
                        $host = $this->request->getHost();
                        $base_url = $this->request->getBaseUrl();

                        $url = $protocol . $host . $base_url . $url;
                }

                $this->response->setStatusCode(302, 'Found');
                $this->response->setHttpHeader('Location', $url);
        }
}
?>
