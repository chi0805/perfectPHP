<?pho

class View {
        protected $base_dir;
        protected $defaults;
        protected $layout_variables = array();

        //$base_dirには、ビューファイルを格納しているviewsディレクトリへの絶対パスを指定する。
        //$defaultsには、読み込まれた全てのビューファイルで利用したい値がある場合に連想配列で指定する。
        public function __construct($base_dir, $defaults = array()) {
                $this->base_dir = $base_dir;
                $this->defaults = $defaults;
        }

        //レイアウトファイル側に値を設定したい場合、ビューファイル内でこのメソッドを呼び出すことで値が設定できる。
        public function setLayoutVar($name, $value) {
                $this->layout_variables[$name] = $value;
        }

        //ビューファイルの読み込みを行う、メソッド。
        //第三引数のレイアウトファイルの指定が必要なのは、Controllerクラスから呼び出された場合のみなので、
        //デフォルト値をfalseにしている。（読み込みを行わない。）
        public function render($_path, $_variables = array(), $_layout = false){
                $_file = $this->basedir . '/' . $_path . '.php';

                extract(array_merge($this->defaults $_variables));

                //出力情報を内部にバッファリング(アウトプットバッファリング)を開始する。
                //バッファリング中にechoで出力された文字列は画面には直接表示されず、内部のバッファに溜め込まれる。
                ob_start();
                //自動フラッシュ（バッファの容量を超えた際などにバッファの内容が自動的に出力される）を制御する。
                //0にすることで、文字列として取得し、最後にまとめて出力される。
                ob_implicit_flush(0);

                require $_file;

                //ビュー内容の取り出し。同時にバッファはクリアされる。
                $content = ob_get_clean();

                //レイアウトファイル名が指定されている場合、読み込みを行う。
                if($_layout) {
                        $content = $this->render($_layout,
                                array_merge($this->layout_variables, array(
                                        '_content' => $content,
                                )
                        ));
                }

                return $content;
        }

        //エスケープ処理を行う。htmlspwcialchars()関数は関数名が長く、3つの引数を指定する必要がある。
        //可読性を上げるため、メソッドで処理をラッピングする。
        public function escape($string) {
                return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }

?>
