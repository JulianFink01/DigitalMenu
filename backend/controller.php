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
        if(!isset($_SESSION["loggedIn"])){
            header('Location: index.php?aktion=login');
        }
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
    private function deleteKategorie(){
      $kat = Kategorie::finde($_GET['kategorie']);
      $produkte = Produkt::findeNachKategorie($kat);
      if(is_array($produkte)){
        foreach($produkte as $p){
          $p->loesche();
        }
      }else{
        $produkte->loesche();
      }
      $kat->loesche();
      header("Location: index.php");
    }

    function deleteProdukt(){
      $kat = Kategorie::finde($_GET['kategorie']);
      $produkt = Produkt::finde($_GET['produkt']);
      $produkt->loesche();
      header("Location: index.php?kategorie=".$kat->getId());
    }
    private function saveKategorie(){

      if ($_POST['subkategorie'] === '' || $_POST['subkategorie'] === 'undefined')
          {
          $_POST['subkategorie'] = NULL; // or 'NULL' for SQL
          }
        $kategorie = new Kategorie(array("name"=>$_POST['name'],"description"=>$_POST['description'], "subkategorie"=>$_POST['subkategorie'],"icon"=>$_FILES['icon']['name']));
        $kategorie->speichere();

        $uploaddir = '../images/kategorie/';
        $uploadfile = $uploaddir . basename($_FILES['icon']['name']);


        if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
          echo "File is valid, and was successfully uploaded.\n";
        } else {
           echo "Upload failed";
        }

        header("Location: index.php?kategorie=".$kategorie->getId());

    }
    private function stepback(){
      $kategorie = Kategorie::finde($_GET['kategorie']);
      $sub = $kategorie->getSubkategorie();
      if($sub){
        header("Location: index.php?aktion=backend&kategorie=".$sub);
      }else{
        header("Location: index.php");
      }
    }
    private function saveProdukt(){

        $produkt = new Produkt(array("name"=>$_POST['name'],"description"=>$_POST['description'], "kategorie"=>$_POST['katgorie'],"price"=>$_POST['price'],"zutaten"=>$_POST['zutaten'],"icon"=>$_FILES['icon']['name']));
        $produkt->speichere();
        $uploaddir = '../images/produkt/';
        $uploadfile = $uploaddir . basename($_FILES['icon']['name']);

        if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
          echo "File is valid, and was successfully uploaded.\n";
        } else {
           echo "Upload failed";
        }
        header("Location: index.php?kategorie=".$_GET['kategorie']);

    }

    private function editProdukt(){
      $produkt = Produkt::finde($_GET['id']);
      $produkt->setName($_POST['name']);
      $produkt->setDescription($_POST['description']);
      $produkt->setPrice($_POST['price']);
      $produkt->setZutaten($_POST['zutaten']);
      $produkt->setIcon($_FILES['icon']['name']);
      $produkt->speichere();

      $uploaddir = '../images/produkt/';
      $uploadfile = $uploaddir . basename($_FILES['icon']['name']);


      if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
      } else {
         echo "Upload failed";
      }


      header("Location: index.php?kategorie=".$_GET['kategorie']);
    }
    public function login(){
      $vars = parse_ini_file("../entities/variables.ini.php", TRUE);
      $verwaltung = $vars["Verwaltung"];
      if(isset($_POST["key"]) && isset($_POST["passwd"])){

          if(strcmp($_POST["key"], $verwaltung["username"]) == 0 && strcmp($_POST["passwd"], $verwaltung["password"]) == 0){
            $_SESSION["loggedIn"] = true;
              header("Location: index.php?aktion=backend");
          }else{
          }
    }
    }
}

?>
