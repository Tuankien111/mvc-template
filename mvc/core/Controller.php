<?php 
    class Controller{
        //=========== Model 
        public function model($model) {
            require_once "mvc/models/".$model.".php";
            return new $model;
        }
        //=========== Views
        public function view($view,$page,$data = []) {
            require_once "mvc/views/".$view."/".$page.".php";
        }

        //=========== Views with 
        public function viewpk($view,$package,$page) {
            require_once "mvc/views/".$view."/".$package."/".$page.".php";
        }

        
    }
?>