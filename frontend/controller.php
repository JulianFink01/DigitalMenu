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
    private function frontend(){
        $kategorie = isset($_GET['kategorie'])?$_GET['kategorie']:'sup';
        if(!isset($kategorie) || $kategorie == 'undefined'){
          $kategorie='sup';

        }
        if($kategorie == 'sup'){
          $this->addContext("kategorien", Kategorie::findeAlleHauptKategorien());
          $this->addContext("produkte", NULL);
        }else{
          $kat = Kategorie::finde($kategorie);
          $this->addContext("kategorien", Kategorie::findeNachKategorie($kat));
          $this->addContext("produkte", Produkt::findeNachKategorie($kat));
          }
    }


    function deleteProdukt(){
      $kat = Kategorie::finde($_GET['kategorie']);
      $produkt = Produkt::finde($_GET['produkt']);
      $produkt->loesche();
      header("Location: index.php?kategorie=".$kat->getId());
    }

    private function stepback(){
      $kategorie = Kategorie::finde($_GET['kategorie']);
      $sub = $kategorie->getSubkategorie();
      if($sub){
        header("Location: index.php?kategorie=".$sub);
      }else{
        header("Location: index.php");
      }
    }



}

?>
