<?php if(!isset($_SESSION["loggedIn"])){
    header('Location: index.php?aktion=login');}
    ?>
<html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="styles/backend.css">
  </head>
  <body>

    <div id="content">
      <legend>
        <h1><?php
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
            if($kategorien){
              ?>
              <img src="images/addFolder.png" alt="Kategorie hinzufügen" title="Kategorie hinzufügen" onclick="showPopup('addKategorie',<?php if(isset($_GET['kategorie'])){echo $_GET['kategorie'];}else{echo 'undefined';}?>)"/>
              <?php
            }elseif($produkte){
              ?>
              <img src="images/add.png" alt="Produkt hinzufügen" title="Produkt hinzufügen" onclick="showPopup('addProdukt', <?php if(isset($_GET['kategorie'])){echo $_GET['kategorie'];}else{echo 'undefined';}?>)"/>
              <?php
            }elseif(!$kategorien && !$produkte){
              ?>
              <img src="images/addFolder.png" alt="Kategorie hinzufügen" title="Kategorie hinzufügen" onclick="showPopup('addKategorie', <?php if(isset($_GET['kategorie'])){echo $_GET['kategorie'];}else{echo 'undefined';}?>)"/>
              <img src="images/add.png" alt="Produkt hinzufügen" title="Produkt hinzufügen" onclick="showPopup('addProdukt', <?php if(isset($_GET['kategorie'])){echo $_GET['kategorie'];}else{echo 'undefined';}?>)"/>
              <?php
            }
            if(isset($_GET['kategorie'])){
            $kategorie_json = Kategorie::finde($_GET['kategorie']);
            $kat_json = array('id'=>$kategorie_json->getId(), 'name'=>$kategorie_json->getName(), 'description'=>$kategorie_json->getDescription(), 'subkategorie'=>$kategorie_json->getSubkategorie(), 'icon'=>$kategorie_json->getIcon());
            echo "<img src='images/edit.png' alt='Kategorie bearbeiten' title='Kategorie bearbeiten'    onclick='editKategorie(".json_encode($kat_json).",".$_GET['kategorie'].")'>";

            ?>

          <img src="images/delete.png" alt="Kategorie löschen" title="Kategorie löschen" onclick="deleteKategorie(<?php echo $_GET['kategorie'] ?>)" />
          <?php
          }
             if(isset($_GET['kategorie'])){
          ?>
          <img src="images/back.png" id="back" alt="Zurück" title="Zurück" onclick="back(<?php echo $_GET['kategorie'] ?>)" />
        <?php }?>
        </h1>
      </legend>
      <div class="kategories">
        <?php

          if($kategorien){

            if(is_array($kategorien)){
              foreach($kategorien as $kat){
                  echo "<div class='kategorie' onclick='openKategorie(".$kat->getId().")'>";
                  echo "<label><img src='../images/kategorie/".$kat->getIcon()."'/></label>";
                  echo "<label><a class='kategorie-titel'>".$kat->getName()."</a></label>";
                  echo "</div>";
              }
            }else{
              echo "<div class='kategorie' onclick='openKategorie(".$kategorien->getId().")'>";
              echo "<label><img src='../images/kategorie/".$kategorien->getIcon()."'/></label>";
              echo "<label><a class='kategorie-titel'>".$kategorien->getName()."</a></label>";
              echo "</div>";
            }
          }elseif($produkte){
            if(is_array($produkte)){
              foreach($produkte as $pro){
                  $pdkt = array('id'=>$pro->getId(), 'name'=>$pro->getName(), 'description'=>$pro->getDescription(), 'price'=>$pro->getPrice(), 'zutaten'=>$pro->getZutaten(), 'icon'=>$pro->getIcon());
                  echo "<div class='kategorie'   onclick='editProdukt(".json_encode($pdkt).",".$_GET['kategorie'].")'>";
                  echo "<label><img src='../images/produkt/".$pro->getIcon()."'/></label>";
                  echo "<label><a class='kategorie-titel'>".$pro->getName()."</a></label>";
                  echo "</div>";
              }
            }else{
              $pdkt = array('id'=>$produkte->getId(), 'name'=>$produkte->getName(), 'description'=>$produkte->getDescription(), 'price'=>$produkte->getPrice(), 'zutaten'=>$produkte->getZutaten(), 'icon'=>$produkte->getIcon());
              echo "<div class='kategorie'   onclick='editProdukt(".json_encode($pdkt).",".$_GET['kategorie'].")'>";
              echo "<label><img src='../images/produkt/".$produkte->getIcon()."'/></label>";
              echo "<label><a class='kategorie-titel'>".$produkte->getName()."</a></label>";
              echo "</div>";
            }
          }

        ?>
      </div>
    </div>
    <?php
          include("views/addProdukt.tpl.php");
          include("views/addKategorie.tpl.php");
    ?>

    <script type="text/javascript">
        function showPopup(id, kat){
          var popup = document.getElementById(id);
          popup.classList.toggle("visible");
          document.getElementById("content").classList.toggle("blur");

          //revert values to null
          if(id=='addProdukt'){
            var produkttitel = document.getElementById('produkt-title');
            produkttitel.innerHTML= 'Produkt erstellen';
            var namefield = document.getElementById('name-input');
            namefield.value = '';
            var desfield = document.getElementById('description-input');
            desfield.value = '';
            var pricefield = document.getElementById('price-input');
            pricefield.value = '';
            var zutatenfield = document.getElementById('zutaten-input');
            zutatenfield.value = '';
            var idfield = document.getElementById('id-input');
            idfield.value = '';
            var submitfield = document.getElementById('produkt-submit');
            submitfield.value ="Produkt erstellen";
            popup.action = 'index.php?aktion=saveProdukt&kategorie='+kat;
          }
          if(id=='addKategorie'){
            var produkttitel = document.getElementById('kategorie-title');
            produkttitel.innerHTML= 'Kategorie erstellen';
            var namefield = document.getElementById('name-inp');
            namefield.value = '';
            var desfield = document.getElementById('description-inp');
            desfield.value = '';
            var subkatfield = document.getElementById('subkat-inp');
            subkatfield.value = kat;
            var idfield = document.getElementById('id-input');
            idfield.value = '';
            var submitfield = document.getElementById('kategorie-submit');
            submitfield.value ="Kategorie erstellen";
            popup.action = 'index.php?aktion=saveKategorie&kategorie='+kat;
          }
        }
        function openKategorie(url){
          location.href = 'index.php?kategorie='+url;
        }
        function deleteKategorie(kat){
          location.href = 'index.php?aktion=deleteKategorie&kategorie='+kat;
        }
        function deleteProdukt(prod, kat){
        //  location.href = 'index.php?aktion=deleteProdukt&produkt='+prod+'kategorie='+kat;
        }
        function editProdukt(json, kat){
          var popup = document.getElementById('addProdukt');
          //inputs from editfield
          var produkttitel = document.getElementById('produkt-title');
          produkttitel.innerHTML= 'Produkt bearbeiten';
          var namefield = document.getElementById('name-input');
          namefield.value = json['name'];
          var desfield = document.getElementById('description-input');
          desfield.value =  json['description'];
          var pricefield = document.getElementById('price-input');
          pricefield.value = json['price'];
          var zutatenfield = document.getElementById('zutaten-input');
          zutatenfield.value = json['zutaten'];
          var idfield = document.getElementById('id-input');
          idfield.value = json['id'];
          var submitfield = document.getElementById('produkt-submit');
          submitfield.value ="Produkt bearbeiten";
          popup.action = 'index.php?aktion=editProdukt&id='+json['id']+'&kategorie='+kat;

          var img = document.createElement('img');
          img.src =  'images/delete.png';
          img.id = 'delete-produkt';
          img.title = 'Produkt löschen';
          img.onclick = function deleteProdukt(){
            location.href = 'index.php?aktion=deleteProdukt&produkt='+json['id']+'&kategorie='+kat;
          }

          popup.appendChild(img);
          //toggle
          popup.classList.toggle("visible");
          document.getElementById("content").classList.toggle("blur");
        }
        function editKategorie(json, kat){
          var popup = document.getElementById('addKategorie');
          var obj = json;
          //inputs from editfield
          var produkttitel = document.getElementById('kategorie-title');
          produkttitel.innerHTML= 'Kategorie bearbeiten';
          var namefield = document.getElementById('name-inp');
          namefield.value = json['name'];
          var desfield = document.getElementById('description-inp');
          desfield.value = json['description'];
         var subkatfield = document.getElementById('subkat-inp');
          subkatfield.value = json['subkategorie'];
          var idfield = document.getElementById('id-input');
          idfield.value = json['id'];
          var submitfield = document.getElementById('kategorie-submit');
          submitfield.value ="Kategorie bearbeiten";
          popup.action = 'index.php?aktion=editKategorie&kategorie='+kat;
          //toggle
          popup.classList.toggle("visible");
          document.getElementById("content").classList.toggle("blur");
        }
        function back(kat){
          location.href = 'index.php?aktion=stepback&kategorie='+kat;

        }
    </script>

  </body>
</html>
