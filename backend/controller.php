<?php
class Controller{
//https://remotemysql.com/phpmyadmin/index.php
    private $context = array();


    public function run($aktion){
        $this->$aktion();
        $this->generatePage($aktion);
    }
    public function logout(){
        session_destroy ();
          header("Location: ../index.html");
    }

    public function hauptseite(){
        $this->addContext("fortbildungen", Fortbildung::findeAlle());
    }
    public function saveFortbildung(){
      $StatusFoto = " ";
      $fortbildung = new Fortbildung(array("name"=>$_POST['titel'],"status"=>1));
      $fortbildung->speichere();
      header("Location: index.php?aktion=hauptseite");
    }

    public function duplicateFortbildung(){
      $alteFortbildung = Fortbildung::finde($_GET['fortbildung_id']);
      $dupliFortbildung = new Fortbildung(array("name"=>$alteFortbildung->getName(),"status"=>$alteFortbildung->getStatus()));
      $dupliFortbildung->speichere();
      $altKurs = Kurs::findeNachFortbildung($alteFortbildung);
      foreach ($altKurs as $alterKurs) {
        $dupliKurs = new Kurs(array("titel"=>$alterKurs->getTitel(),"datum"=>$alterKurs->getDatum(),"maxTeilnehmer"=>$alterKurs->getMaxTeilnehmer(),"referent"=>$alterKurs->getReferent(),"beschreibung"=>$alterKurs->getBeschreibung(),"ort_raum"=>$alterKurs->getOrt_raum(),"kontakt"=>$alterKurs->getKontakt(),
        "von"=>$alterKurs->getVon(),"bis"=>$alterKurs->getBis(),"unterschriftsliste_zweispaltig"=>$alterKurs->getUnterschriftsliste_zweispaltig(),"koordination"=>$alterKurs->getKoordination(),"anmeldeschluss"=>$alterKurs->getAnmeldeSchluss(),"dauer"=>$alterKurs->getDauer(),"fortbildung_id"=>$dupliFortbildung->getId()));
        $dupliKurs->speichere();
      }

      header("Location: index.php?aktion=hauptseite");

    }
    public function statusAendern(){
      $fortbildung = Fortbildung::finde($_GET['fortbildung_id']);
      echo $fortbildung->__toString();
      if ($fortbildung->getStatus() == 1) {
        $fortbildung->setStatus(0);
        $fortbildung->speichere();
        echo "war 1";
      }else {
        $fortbildung->setStatus(1);
        $fortbildung->speichere();
        echo "war 0";
      }

      header("Location: index.php?aktion=hauptseite");
    }

    public function alle_kurse(){

      $this->addContext("kurse", Kurs::findeNachFortbildung(Fortbildung::finde($_REQUEST['fortbildung_id'])));
      $this->addContext("teilnehmern", Fortbildung::findeAlleTeilnehmer(Fortbildung::finde($_REQUEST['fortbildung_id'])));
      $this->addContext("fortbildung", Fortbildung::finde($_REQUEST['fortbildung_id']));



    }
    public function kurse_erstellen(){
      if ($_POST){
        $kurs = new Kurs($_POST);
        $kurs->speichere();
        $this->alle_kurse();
        $this->addContext("template","alle_kurse");

      }

    }
    public function teilnehmer_bearbeiten(){
      $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
          $email = $_POST["email"];
          $token = $_POST["token"];


          $teil = Teilnehmer::findeNachToken($token);
          if($vorname != '' && $vorname != ' '){
            $teil->setVorname($vorname);}
            if($nachname != '' && $nachname != ' '){
              $teil->setNachname($nachname);}
            if($email != '' && $email != ' '){
              $teil->setEmail($email);}

          $teil->speichere();

          header('Location: index.php?aktion=alle_kurse&fortbildung_id='.$_POST["fortbildung_id"].'#funktionen');


    }
    public function titel_aendern(){


        $name = $_POST["titel"];

          $fort = Fortbildung::finde($_POST['fid']);

          echo $name;
          echo $_POST['fid'];
          if($name != '' && $name != ' '){
            $fort->setName($name);
          }


          $fort->speichere();

          header('Location: index.php?aktion=hauptseite');


    }
    public function send_email(){
      Funktionen::send_email();
      header('Location: index.php?aktion=hauptseite');
    }
    public function login(){
      $vars = parse_ini_file("../entities/variables.ini.php", TRUE);
      $verwaltung = $vars["Verwaltung"];
      if(isset($_POST["key"]) && isset($_POST["passwd"])){
      if($_POST["key"] == $verwaltung["username"] && $_POST["passwd"] == $verwaltung["password"]){
        $_SESSION["loggedIn"] = true;
        $this->addContext("template","hauptseite");
          $this->addContext("fortbildungen", Fortbildung::findeAlle());
      }else{

      }
    }
    }
    public function import_lehrer(){
      $alleLehrer = Funktionen::importLehrer();

      foreach ($alleLehrer as $lehrer) {

        //checken ob teilnehmer/lehrer in datenbank schon vorhanden ist
        $teilnehmer = Teilnehmer::findeNachEmail($lehrer["Email"]);

        if($teilnehmer == false){//wenn leherer keine email haben, sind nicht in DB
          $teilnehmer = new Teilnehmer();
          $teilnehmer->setVorname($lehrer["Vorname"]);
          $teilnehmer->setNachname($lehrer["Nachname"]);
          $teilnehmer->setEmail($lehrer["Email"]);
          $teilnehmer->speichere();
        }

        if (NimmtTeil::findeNachFortbildungUndTeilnehemer(Fortbildung::finde($_GET['fortbildung_id']) , $teilnehmer) == false){
          $teilnehmerNimmt = new NimmtTeil();
          $teilnehmerNimmt->setFortbildung_id($_GET['fortbildung_id']);
          $teilnehmerNimmt->setTeilnehmer_id($teilnehmer->getId());
          $teilnehmerNimmt->speichere();
        }
        // Teilnehmer zu NimmtTeil hinzufügens
      }
      $this->alle_kurse();
      $this->addContext("template","alle_kurse");
    }

    public function remove_lehrer_nimmtTeil(){
        //checken bei welchem teilnehmer/lehrer der butten gedrückt wurde
        $teilnehmer = Teilnehmer::finde($_GET["teilnehmer_id"]);
        Fortbildung::finde($_GET["fortbildung_id"])->abmelden($teilnehmer);
        // Teilnehmer zu NimmtTeil entfernen
      $this->alle_kurse();
      $this->addContext("template","alle_kurse");
    }

    public function loescheFortbildung(){
      $fortbildung = Fortbildung::finde($_GET['fortbildung_id']);
      $teilnehmer = Fortbildung::findeAlleTeilnehmer($fortbildung);
      foreach($teilnehmer as $t){
        $fortbildung->abmelden($t);
      }
      $kurse = Kurs::findeNachFortbildung($fortbildung);
      foreach($kurse as $k){
        $k->loesche();
      }
      $fortbildung->loesche();
      header('Location: index.php?aktion=hauptseite');
    }

    public function loesche(){
      $kurs = Kurs::finde($_GET['kurs_id']);
      $kurs->loesche();
      header('Location: index.php?aktion=alle_kurse&fortbildung_id='.$_REQUEST["fortbildung_id"].'#allgemeiner');
    }

    public function saveTeilnehmer(){
      $teilnehmer = Teilnehmer::findeNachEmail($_POST['email']);
      if(!$teilnehmer){
        $teilnehmer = new Teilnehmer(array("vorname"=>$_POST['vorname'],"nachname"=>$_POST['nachname'], "email" =>$_POST['email']));
        $teilnehmer->speichere();
      }
      $fortbilung = Fortbildung::finde($_REQUEST["fortbildung_id"]);
      if(!NimmtTeil::findeNachFortbildungUndTeilnehemer($fortbilung, $teilnehmer)){
        $fortbilung->teilnehmen($teilnehmer);
      }
      header('Location: index.php?aktion=alle_kurse&fortbildung_id='.$_REQUEST['fortbildung_id'].'#funktionen');
    }

    public function kurs_bearbeiten(){
      $this->addContext("kurse", Kurs::finde($_GET['kurs_id']));
    }


    public function kurse_bearbeitung_speichern(){
      $daten = $_POST;
      $daten['id'] = $_REQUEST['kurs_id'];
      $kurse = new Kurs($daten);
      $kurse->completeKurs();
      $kurse->speichere();
      header('Location: index.php?aktion=alle_kurse&fortbildung_id='.$_REQUEST['fortbildung_id'].'#allgemeiner');
    }

    public function teilnehmerliste(){
      $this->addContext("kurse",Kurs::finde($_GET['kurs_id']));
      $this->addContext("teilnehmern",Teilnehmer::findeNachKurs(Kurs::finde($_GET['kurs_id'])));
    }



    private function generatePage($template){
        extract($this->context);
        require_once 'views/'.$template.".tpl.php";

    }

    private function addContext($key, $value){
        $this->context[$key] = $value;
    }

}

?>
