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
        protected $auth_actions = array(); //ログインが必要なアクション名を配列で指定する。

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
                throw new HttpNotFoundException('Forwarded 404 page from' . $this->controller_name . '/' . $this->action_name);
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

        //CSRF対策。

        //トークンを生成し、サーバに保持するためセッションに格納する。
        //トークンはフォームごとに識別する。
        //このメソッドは、同一アクションを複数画面開いた場合の対応として、トークンを最大10個保持できる。
        protected function generateCsrfToken($form_name) {
                $key = 'csrf_tokens/' . $form_name;
                $tokens = $this->session->get($key, array());
                //すでに10個保持している場合、古いものから削除する。
                if (count($tokens) >= 10) {
                        array_shift($tokens);
                }

                $token = sha1($form_name . session_id() . microtime());
                $tokens[] = $token;

                $this->session->set($key, $tokens);

                return $token;
        }

        //トークンはリクエストされた際にPOSTパラメータとして送信される。
        //セッション上に格納されているトークンからPOSTされたトークンを探す。
        protected function checkCsrfToken($form_name, $token) {
                $key = 'csrf_tokens/' . $form_name;
                $tokens = $this->session->get($key, array());

                //セッション上にトークンが格納されているか判定し、トークンが存在した場合は処理を継続して良いためtrueを返す。
                //一度利用したトークンは不要なので削除する。
                if(false !== ($pos = array_search($token, $tokens, true))) {
                        unset($tokens[$pos]);
                        $this->session->set($key, $tokens);

                        return true;
                }

                return false;
        }

        //ログイン画面

        public function run($action, $params = array()) {
                $this->action_name = $action;

                $action_method = $action . 'Action';

                if (!method_exists($this, $action_method)) {
                        $this->foward404;
                }

                if ($this->needsAuthentication($action) && !$this->session->isAuthenticated()) {
                        throw new UnauthorizedActionException();
                }

                $content = $this->$action_method($params);

                return $content;
        }

        //ログインが必要かどうかを判定する。
        protected function needsAuthentication($action) {
                if($this->auth_action == true || (is_array($this->auth_actions) && in_array($action, $this->auth_actions))) {
                        return true;
                }
 
                return false;
        }


}
?>
