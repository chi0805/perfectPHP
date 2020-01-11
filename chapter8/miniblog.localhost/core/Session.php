<?php

class Session {
        protected static $sessionStarted = false;
        protected static $sessionIdRegenerated = false;

        public function __construct(){
                //自動的にセッションを開始する。
                //2回以上Sessionクラスが呼び出された時に、複数回session_start()が呼び出されないようにする。
                if (!self::$sessionStarted) {
                        session_start();

                        self::$sessionStarted = true;
                }
        }

        public function set($name, $value) {
                $_SESSION[$name] = $value;
        }

        public function get($name, $default = null) {
                if (isset($_SESSION[$name])) {
                        return $_SESSION[$name];
                }

                return $default;
        }

        public function remove($name) {
                unset($_SESSION[$name]);
        }

        public function clear() {
                $_SESSION = array();
        }

        //セッションIDを新しく発行する。
        public function regenerate($destroy = true) {
                //これも1度のリクエストで複数回発行されないよう、静的プロパティでチェックする。
                if (!self::$sessionIdRegenerated) {
                        session_regenerate_id($destroy);

                        self::$sessionIdRegenerated = true;
                }
        }

        //以下は、ログイン状態を確認するメソッド。
        //authenticatedキーでログインしているかどうかのフラグを格納し、ログイン状態を確認する。
        public function setAuthenticated($bool) {
                $this->set('_authenticated', (bool)$bool);

                $this->regenerate();
        }

        public function isAuthenticated() {
                return $this->get('_authenticated', false);
        }

}
?>
