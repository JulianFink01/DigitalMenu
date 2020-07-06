<?php
class Controller{
//https://remotemysql.com/phpmyadmin/index.php
    private $context = array();


    public function run($aktion){
        $this->$aktion();
        $this->generatePage($aktion);
    }

    private function generatePage($template){
        extract($this->context);
        require_once 'views/'.$template.".tpl.php";
    }

    private function addContext($key, $value){
        $this->context[$key] = $value;
    }


    //controller
    private function backend(){
        $this->addContext("kategorien", Kategorie::findeAlle());
    }

}

?>
