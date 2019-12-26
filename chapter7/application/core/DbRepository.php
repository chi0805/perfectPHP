<?php

//DBへのアクセスを行う。テーブルごとにDbRepositoryの子クラスを作成するようにする。

abstract class DbRepository {
        protected $con;

        public function __construct($con) {
                $this->setConnection($con);
        }

        //DbManagerクラスからPDOクラスのインスタンスを受け取って内部に保持するためのメソッド。
        public function setConnection($con) {
                $this->con = $con;
        }

        //プリペアドステートメントを実行し、PDOStatementクラスのインスタンスを取得する。
        public function execute($sql, $params = array()) {
                //PDOクラスのprepare()メソッドを実行すると、PDOStatementクラスのインスタンスが返ってくる。
                $stmt = $this->con->prepare($sql);
                
                //PDOStatementクラスのexecute()メソッドを実行すると、実際にクエリがDBに発行される。
                //execute()メソッドの引数には、プレースホルダに入る値を指定する。
                $stmt->execute($params);

                return $stmt;
        }

        //SQLの実行結果の1行のみを取得するメソッド。
        public function fetch($sql, $params = array()) {
                //PDO::FETCH_ASSOCは、取得結果を連想配列で受け取るという指定。
                //これを指定しないと、取得結果の配列のキーが全て数値の連番になる。
                return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
        }

        //SQLの実行結果の全ての行を取得するメソッド。
        public function fetchAll($sql, $params = array()) {
                return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        }
}                

?>
