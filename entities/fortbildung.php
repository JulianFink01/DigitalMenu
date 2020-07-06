<?php

class Fortbildung{

protected $id = 0;
protected $name = "";
protected $status = true ;

public function __construct($daten = array())
{
    // wenn $daten nicht leer ist, rufe die passenden Setter auf
    if ($daten) {
        foreach ($daten as $k => $v) {
            $setterName = 'set' . ucfirst($k);
            // wenn ein ungültiges Attribut übergeben wurde
            // (ohne Setter), ignoriere es
            if (method_exists($this, $setterName)) {
                $this->$setterName($v);
            }
        }
    }
}

public function  __toString()
{
    return 'Id:'. $this->id .', Name: '.$this->name.', Status: '.$this->status;
}
public function toArray($mitId = true)
{
    $attribute = get_object_vars($this);
    if ($mitId === false) {
        // wenn $mitId false ist, entferne den Schlüssel id aus dem Ergebnis
        unset($attribute['id']);
    }
    return $attribute;
}

public function speichere()
{
    if ( $this->getId() > 0 ) {
        // wenn die ID eine Datenbank-ID ist, also größer 0, führe ein UPDATE durch
        $this->_update();
    } else {
        // ansonsten einen INSERT
        $this->_insert();
    }
}

public function setId($id){
  $this->id = $id;
}
public function getId(){
  return $this->id;
}
public function setName($name){
  $this->name = $name;
}
public function getName(){
  return $this->name;
}
public function setStatus($status){
  $this->status = $status;
}
public function getStatus(){
  return $this->status;
}

public function loesche()
{
    $sql = 'DELETE FROM f_fortbildung WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute( array($this->getId()) );
    // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
    $this->id = 0;
}

/* ***** Private Methoden ***** */

private function _insert()
{

    $sql = 'INSERT INTO f_fortbildung (name, status)'
         . 'VALUES (:name, :status)';

    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute($this->toArray(false));
    // setze die ID auf den von der DB generierten Wert
    $this->id = DB::getDB()->lastInsertId();
}

private function _update()
{
    $sql = 'UPDATE f_fortbildung SET name=?, status=?'
        . 'WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute(array($this->getName(), $this->getStatus(), $this->getId()));
}

/* ***** public Methoden ***** */
public function findeAlleKurse(){
  $result = Kurs::findeNachFortbildung($this);
  return $result;
}
public static function findeAlle()
{
    $sql = 'SELECT * FROM f_fortbildung';
    $abfrage = DB::getDB()->query($sql);
    $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Fortbildung');
    return $abfrage->fetchAll();
}

public static function finde($id){
  $sql = 'SELECT * FROM f_fortbildung WHERE id=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($id));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Fortbildung');
  return $abfrage->fetch();
}

public static function findeNachName($name){
  $sql = 'SELECT * FROM f_fortbildung WHERE name=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($name));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Fortbildung');
  return $abfrage->fetch();
}

public static function findeAlleTeilnehmer(Fortbildung $fortbildung){
  $result = NimmtTeil::findeAlleFortbildungTeilnehmer($fortbildung);
  return $result;
}
public static function findeNachBenutzer(Teilnehmer $teilnehmer)
{
    return NimmtTeil::findeAlleFortbildungenNachTeilnehmer($teilnehmer);
}

public function teilnehmen(Teilnehmer $teilnehmer){
  $sql = 'Insert into f_nimmt_teil (fortbildung_id, teilnehmer_id, kurs_id) values (?,?, NULL)';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array(
    $this->getId(),
    $teilnehmer->getId()
  ));
}
public function abmelden(Teilnehmer $teilnehmer){
  $sql = 'Delete from f_nimmt_teil where fortbildung_id = ? and teilnehmer_id = ?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array(
    $this->getId(),
    $teilnehmer->getId()
  ));
}

}


?>
