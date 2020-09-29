<?php

class Controller{

    private $context = array();


    public function run($aktion){

        if(isset($_GET["lang"])){
            $_SESSION["language"] = $_GET["lang"];
        }

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
    private function frontend(){
        $session_lang = "";
        if(isset($_SESSION["language"])){
            $session_lang = $_SESSION["language"];
        }
        $kategorie = isset($_GET['kategorie'])?$_GET['kategorie']:'sup';
        if(!isset($kategorie) || $kategorie == 'undefined'){
          $kategorie='sup';

        }
        if($kategorie == "sup"){
          $this->addContext("kategorien", Kategorie::findeAlleHauptKategorien());
          $this->addContext("produkte", NULL);
            $this->addContext("lang", $session_lang);

        }else{
          $kat = Kategorie::finde($kategorie);
          $this->addContext("kategorien", Kategorie::findeNachKategorie($kat));
          $this->addContext("produkte", Produkt::findeNachKategorie($kat));
          $this->addContext("lang", $session_lang);
          }
    }


    function deleteProdukt(){
      $kat = Kategorie::finde($_GET['kategorie']);
      $produkt = Produkt::finde($_GET['produkt']);
      $produkt->loesche();
      $session_lang = "";
        if(isset($_SESSION["language"])){
            $session_lang = $_SESSION["language"];
        }
      header("Location: index.php?kategorie=".$kat->getId()."&lang=".$session_lang);
    }

    private function stepback(){
      $kategorie = Kategorie::finde($_GET['kategorie']);
      $sub = $kategorie->getSubkategorie();
        $session_lang = "";
        if(isset($_SESSION["language"])){
            $session_lang = $_SESSION["language"];
        }
      if($sub){
        header("Location: index.php?kategorie=".$sub."&lang=".$session_lang);
      }else{
        header("Location: index.php?lang=".$session_lang);
      }
    }



}

?>
