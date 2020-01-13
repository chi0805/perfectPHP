<?php

class Response{
        protected $content;
        protected $status_code = 200;
        protected $status_text = 'OK';
        protected $http_headers = array();

        public function send(){
                //HTTPのバージョンを指定し、ステータスコードとテキストを指定。
                header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);
                //http_headersプロパティにHTTPレスポンスヘッダの指定があれば、header()関数で指定する。
                foreach($this->http_headers as $name => $value){
                        header($name . ':' . $value);
                }

                //echoを用いて出力するだけで、レスポンスの内容を送信している。
                echo $this->content;
        }

        public function setContent($content){
                $this->content = $content;
        }

        public function setStatusCode($status_code, $status_text = ''){
                $this->status_code = $status_code;
                $this->status_text = $status_text;
        }

        public function setHttpHeader($name, $value){
                $this->http_headers[$name] = $value;
        }
}

?>
