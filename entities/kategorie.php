<?php

class Kategorie{

protected $id = 0;
protected $name = "";
protected $description = "";
protected $subkategorie = 0;
protected $icon = "";

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
    return 'Id:'. $this->id .', Name: '.$this->name.', Description: '.$this->description.', Subkategorie: '.$this->subkategorie.', Icon: '.$this->icon;
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
public function loesche()
{
    $sql = 'DELETE FROM kategorie WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute( array($this->getId()) );
    // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
    $this->id = 0;
}

//Getter Setter
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
public function setDescription($description){
  $this->description = $description;
}
public function getDescription(){
  return $this->description;
}
public function setSubkategorie($subkategorie){
  $this->subkategorie = $subkategorie;
}
public function getSubkategorie(){
  return $this->subkategorie;
}
public function setIcon($icon){
  $this->icon = $icon;
}
public function getIcon(){
  return $this->icon;
}
public function HasSubKategorie(){
  if($this->getSubkategorie() == null){
    return false;
  }else {
    return true;
  }
}

/* ***** Private Methoden ***** */

private function _insert()
{

    $sql = 'INSERT INTO kategorie (name, description, subkategorie, icon)'
         . 'VALUES (:name, :description, :subkategorie, :icon)';

    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute($this->toArray(false));
    // setze die ID auf den von der DB generierten Wert
    $this->id = DB::getDB()->lastInsertId();
}

private function _update()
{
    $sql = 'UPDATE kategorie SET name=?, description=?, subkategorie = ?, icon = ?'
        . 'WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute(array($this->getName(), $this->getDescription(),$this->getSubkategorie(), $this->getIcon(), $this->getId()));
}

/* ***** public Methoden ***** */

public static function findeAlle()
{
    $sql = 'SELECT * FROM kategorie';
    $abfrage = DB::getDB()->query($sql);
    $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kategorie');
    return $abfrage->fetchAll();
}
public static function findeAlleHauptKategorien()
{
    $sql = 'SELECT * FROM kategorie WHERE subkategorie IS NULL';
    $abfrage = DB::getDB()->query($sql);
    $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kategorie');
    return $abfrage->fetchAll();
}
public static function finde($id){
  $sql = 'SELECT * FROM kategorie WHERE id=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($id));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kategorie');
  return $abfrage->fetch();
}

public static function findeNachName($name){
  $sql = 'SELECT * FROM kategorie WHERE name=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($name));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kategorie');
  return $abfrage->fetch();
}

public static function findeAlleProdukte(){
  $result = Produkt::findeNachKategorie($this);
  return $result;
}
public static function findeNachKategorie(Kategorie $kategorie)
{
  $sql = 'SELECT * FROM kategorie WHERE subkategorie=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($kategorie->getId()));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kategorie');
  return $abfrage->fetch();
}


}


?>
