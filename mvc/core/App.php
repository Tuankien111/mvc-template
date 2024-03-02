<?php 
    class App {
        // Biến
        protected $controller="home";
        protected $action="show";
        protected $params=[];

        // Phương thức khởi tạo
        function __construct(){
            $arr = $this->UrlProcess(); // => Hàm xữ lý URL (Controller/Action/Param)
            //=========== Controller
            if( $arr != null) {
                $arr[0] = $this->replaceHyphensWithUnderscores($arr[0]);
                if($arr[0] == "404") {
                    $arr[0] = "page_not_found";
                }
                if(count($arr) > 1) {
                    $arr[1] = $this->replaceHyphensWithUnderscores($arr[1]);
                }
                if (file_exists("mvc/controllers/".$arr[0].".php"))
                {
                    $this->controller = $arr[0];
                    unset ($arr[0]);
                }
            }
            
            require_once "mvc/controllers/".$this->controller.".php";
            $this->controller = new $this->controller;

            //=========== Action
            if (isset($arr[1])) {
                if (method_exists($this->controller , $arr[1])){
                    $this->action = $arr[1];
                }
                unset ($arr[1]);
            }

            //=========== Param
            $this->params = $arr?array_values($arr):[];
            call_user_func_array([$this->controller,$this->action],$this->params);
        } 
        
        // Hàm xữ lý URL
        function UrlProcess(){
            if( isset($_GET["url"]) ){
                return explode("/", filter_var(trim($_GET["url"], "/")));
            }
        }

        //fix "this-is-url" to "this_is_url"
        function replaceHyphensWithUnderscores($inputString) {
            $outputString = str_replace("-", "_", $inputString);
            return $outputString;
        }
        
    }
?>