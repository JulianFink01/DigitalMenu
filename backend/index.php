
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../entities/db.php';
require_once '../entities/fortbildung.php';
require_once '../entities/kurs.php';
require_once '../entities/nimmtteil.php';
require_once '../entities/teilnehmer.php';
require_once '../entities/randomgenerator.php';
require_once 'models/funktionen.inc.php';

require_once 'controller/controller.php';


if(isset($_SESSION["Info_mail"])){
  echo "<script type='text/javascript'>alert('".$_SESSION["Info_mail"]."')</script>";
  unset($_SESSION["Info_mail"]);
}

$aktion = isset($_GET['aktion'])?$_GET['aktion']:'login';

$controller = new Controller();

if (method_exists($controller, $aktion)){
       $controller->run($aktion);

}


?>
