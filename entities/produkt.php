<?php

class Produkt{

protected $id = 0;
protected $name = "";
protected $description = "";
protected $price = 0;
protected $kategorie = 0;
protected $zutaten = "";
protected $status = true;
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
    return 'Id:'. $this->id .', Name: '.$this->name.', Description: '.$this->description.', Kategorie: '.$this->kategorie.', Price:'.$this->price.', Zutaten: '.$this->zutaten.', Status: '.$this->status;
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
    $sql = 'DELETE FROM produkt WHERE id=?';
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
public function setIcon($icon){
  $this->icon = $icon;
}
public function getIcon(){
  return $this->icon;
}
public function setDescription($description){
  $this->description = $description;
}
public function getDescription(){
  return $this->description;
}
public function setKategorie($Kategorie){
  $this->kategorie = $Kategorie;
}
public function getKategorie(){
  return $this->kategorie;
}
public function setPrice($price){
  $this->price = $price;
}
public function getPrice(){
  return $this->price;
}
public function setZutaten($zutaten){
  $this->zutaten = $zutaten;
}
public function getZutaten(){
  return $this->zutaten;
}
public function setStatus($status){
  $this->status = $status;
}
public function getStatus(){
  return $this->status;
}


/* ***** Private Methoden ***** */

private function _insert()
{

    $sql = 'INSERT INTO produkt (name, description, kategorie, price, zutaten, status, icon)'
         . 'VALUES (:name, :description, :kategorie, :price, :zutaten, :status, :icon)';

    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute($this->toArray(false));
    // setze die ID auf den von der DB generierten Wert
    $this->id = DB::getDB()->lastInsertId();
}

private function _update()
{
    $sql = 'UPDATE produkt SET name=?, icon=?, description=?, kategorie=?, price=?, zutaten=?, status=?'
        . 'WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute(array($this->getName(), $this->getIcon(), $this->getDescription(),$this->getKategorie(), $this->getPrice(), $this->getZutaten(), $this->getStatus(), $this->getId()));
}

/* ***** public Methoden ***** */

public static function findeAlle()
{
    $sql = 'SELECT * FROM produkt';
    $abfrage = DB::getDB()->query($sql);
    $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Produkt');
    return $abfrage->fetchAll();
}

public static function finde($id){
  $sql = 'SELECT * FROM produkt WHERE id=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($id));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Produkt');
  return $abfrage->fetch();
}

public static function findeNachName($name){
  $sql = 'SELECT * FROM produkt WHERE name=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($name));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Produkt');
  return $abfrage->fetch();
}

public static function findeNachKategorie(Kategorie $kategorie)
{
  $sql = 'SELECT * FROM produkt WHERE kategorie=?';
  $abfrage = DB::getDB()->prepare($sql);
  $abfrage->execute(array($kategorie->getId()));
  $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Produkt');
  return $abfrage->fetchAll();
}


}


?>
