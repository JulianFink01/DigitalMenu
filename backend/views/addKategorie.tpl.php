<?php if(!isset($_SESSION["loggedIn"])){
    header('Location: index.php?aktion=login');}
    ?>
<form class="popup" enctype="multipart/form-data" id="addKategorie" method="post" action="index.php?aktion=saveKategorie">
    <div id="close" title="Popup schließen" onclick="showPopup('addKategorie')"></div>

    <legend><h1 id="kategorie-title">Kategorie erstellen</h1></legend>
      <div class="flex">
        <label class="popup-label">Name</label><input id="name-inp" class="input" type="text" name="name"placeholder="Name..."/>
        <label class="popup-label">Beschreibung</label> <input id="description-inp" class="input" name="description"type="text" placeholder="Beschreibung..."/>
      <!--  <label class="popup-label">Subkategorie</label><select  id="subkat-inp" class="input" name="subkategorie"name="Subkaktegorie...">
          //<?php
          //if(isset($_GET['kategorie'])){
          //  $main_kat = Kategorie::finde($_GET['kategorie']);
        //  }
        //  ?>
        <option value="<?php //if(isset($main_kat)){echo $main_kat->getId();} else{echo '';} ?>" title="Auswählen zu welcher Kategorie die folgende Kategorie gehört"><?php //if(isset($main_kat)){echo $main_kat->getName();} else{echo 'Subkategorie';} ?></option>
          <?php

          //if(is_array($kategorie)){

            //foreach($kategorie as $kat){
            //  echo "<option value ='".$kat->getId()."'>".$kat->getName()."</option>";
            //  }
          //  }else{
          //    echo "<option value ='".$kategorie->getId()."'>".$kategorie->getName()."</option>";
          //  }
          ?>
        </select>-->
        <label class="popup-label">Icon</label><input id="icon-inp" name="icon"class="input" type="file" accept="image/*" placeholder="Icon"/>
        <input name="subkategorie" id="subkat-inp"  type="hidden" >
        <input id="kategorie-submit" class="submit" type="submit" value="Kategorie erstellen">
      </div>
</form>
