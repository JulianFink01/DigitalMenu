<html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="styles/frontend.css">
  </head>
  <body>

    <div id="content">
      <legend>
        <h1> 
            
            <img src="images/FaviconRH.svg" id="logo"/>
            <?php
            if(isset($_GET['kategorie'])){
              if($_GET['kategorie'] == 'undefined'){
                echo "Kategorien";
              }else{
                $kategorie = Kategorie::finde($_GET['kategorie']);
                echo $kategorie->getName();
              }
            }else{
              echo "Kategorien";
            }
          ?>
          <?php

            if(isset($_GET['kategorie'])){
            $kategorie_json = Kategorie::finde($_GET['kategorie']);
            $kat_json = array('id'=>$kategorie_json->getId(), 'name'=>$kategorie_json->getName(), 'description'=>$kategorie_json->getDescription(), 'subkategorie'=>$kategorie_json->getSubkategorie(), 'icon'=>$kategorie_json->getIcon());
          }
             if(isset($_GET['kategorie'])){
          ?>
            <div id="back" alt="Zurück" title="Zurück" onclick="back(<?php echo $_GET['kategorie'] ?>)"></div>
        <?php }?>
            
        </h1>
      </legend>
      <div class="kategories">
        <?php

          if($kategorien){

            if(is_array($kategorien)){
              foreach($kategorien as $kat){
                  echo "<div class='kategorie' onclick='openKategorie(".$kat->getId().")'>";
                  echo "<label><div class='images' style='background-image: url(../images/kategorie/".$kat->getIcon()."'></div></label>";
                  echo "<label><a class='kategorie-titel'>".$kat->getName()."</a></label>";
                  echo "</div>";
              }
            }else{
              echo "<div class='kategorie' onclick='openKategorie(".$kategorien->getId().")'>";
              echo "<label><div class='images' style='background-image: url(../images/kategorie/".$kategorien->getIcon()."'></div></label>";
              echo "<label><a class='kategorie-titel'>".$kategorien->getName()."</a></label>";
              echo "</div>";
            }
          }elseif($produkte){
            if(is_array($produkte)){
              foreach($produkte as $pro){
                  $pdkt = array('id'=>$pro->getId(), 'name'=>$pro->getName(), 'description'=>$pro->getDescription(), 'price'=>$pro->getPrice(), 'zutaten'=>$pro->getZutaten(), 'icon'=>$pro->getIcon());
                  echo "<div class='product'   onclick='showPopup(".json_encode($pdkt).",".$_GET['kategorie'].")'>";
                  echo "<label><div class='images' style='background-image: url(../images/produkt/".$pro->getIcon()."'></div></label><br>";
                  echo "<label><a class='product-titel'>".$pro->getName()."</a><br><p class='product-description'>".$pro->getDescription()."</p></label>";
                  echo "</div>";
              }
            }else{
              $pdkt = array('id'=>$produkte->getId(), 'name'=>$produkte->getName(), 'description'=>$produkte->getDescription(), 'price'=>$produkte->getPrice(), 'zutaten'=>$produkte->getZutaten(), 'icon'=>$produkte->getIcon());
              echo "<div class='product'   onclick='showPopup(".json_encode($pdkt).",".$_GET['kategorie'].")'>";
              echo "<label><div class='images' style='background-image: url(../images/produkt/".$produkte->getIcon()."'></div></label><br>";
              echo "<label><a class='product-titel'>".$produkte->getName()."</a><br><p class='product-description'>".$produkte->getDescription()."</p></label>";
              echo "</div>";
            }
          }

        ?>
      </div>
    </div>
    <?php
          include("views/popup.tpl.php");
    ?>

    <script type="text/javascript">
        function showPopup(json, kat){
          var popup = document.getElementById('popup');
          popup.classList.toggle("visible");
          document.getElementById("content").classList.toggle("blur");

          var namefield = document.getElementById('popup-name');
          namefield.innerHTML = json['name'];
          var desfield = document.getElementById('popup-description');
          desfield.innerHTML =  json['description'];
          var pricefield = document.getElementById('popup-price');
          pricefield.innerHTML = json['price'];
          var zutatenfield = document.getElementById('popup-zutaten');
          zutatenfield.innerHTML = json['zutaten'];
          var zutatenfield = document.getElementById('popup-icon');
          zutatenfield.style = 'background-image: url(../../images/produkt/'+json['icon']+')';
          var zutatenfield = document.getElementById('produkt-title');
          zutatenfield.innerHTML = json['name'];
        }
        function openKategorie(url){
          location.href = 'index.php?kategorie='+url;
        }
        function back(kat){
          location.href = 'index.php?aktion=stepback&kategorie='+kat;
        }
    </script>

  </body>
</html>
