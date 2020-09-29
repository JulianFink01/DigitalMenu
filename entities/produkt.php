<?php

class Produkt{

protected $id = 0;
protected $name = "";
protected $name_it = "";
protected $description = "";
protected $description_it = "";
protected $price = 0;
protected $kategorie = 0;
protected $zutaten = "";
protected $zutaten_it = "";
protected $hersteller = "";
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
    public function setHersteller($hersteller){
        $this->hersteller = $hersteller;
    }
    public function getHersteller(){
        return $this->hersteller;
    }
public function setName($name){
  $this->name = $name;
}
public function getName(){
  return $this->name;
}
public function setName_it($name){
        $this->name_it = $name;
    }
    public function getName_it(){
        return $this->name_it;
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
    public function setDescription_it($description){
        $this->description_it = $description;
    }
    public function getDescription_it(){
        return $this->description_it;
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
public function setZutaten_it($zutaten){
        $this->zutaten_it = $zutaten;
    }
public function getZutaten_it(){
        return $this->zutaten_it;
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

    $sql = 'INSERT INTO produkt (name,name_it, description,description_it, kategorie, price, zutaten,zutaten_it,hersteller, status, icon)'
         . 'VALUES (:name,:name_it, :description,:description_it, :kategorie, :price, :zutaten, :zutaten_it,:hersteller,:status, :icon)';

    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute($this->toArray(false));
    // setze die ID auf den von der DB generierten Wert
    $this->id = DB::getDB()->lastInsertId();
}

private function _update()
{
    $sql = 'UPDATE produkt SET name=?,name_it=?, icon=?, description=?,description_it=?, kategorie=?, price=?, zutaten=?,zutaten_it=?,hersteller=?, status=?'
        . 'WHERE id=?';
    $abfrage = DB::getDB()->prepare($sql);
    $abfrage->execute(array($this->getName(),$this->getName_it(), $this->getIcon(), $this->getDescription(),$this->getDescription_it(),$this->getKategorie(), $this->getPrice(), $this->getZutaten(),$this->getZutaten_it(),$this->getHersteller(), $this->getStatus(), $this->getId()));
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
