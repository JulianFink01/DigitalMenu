<form class="popup"  enctype="multipart/form-data" id="addProdukt" method="post" action="index.php?aktion=saveProdukt">
    <div id="close" title="Popup schließen" onclick="showPopup('addProdukt')"></div>

    <legend class="popup-legend"><h1 id="produkt-title">Produkt erstellen</h1></legend>
      <div class="flex">
          <label class="popup-label">Hersteller</label><input id="hersteller-input" class="input" type="text" name="hersteller"placeholder="Name..."/>
          <label class="popup-label">Name</label><input id="name-input" class="input" type="text" name="name"placeholder="Name..."/>
          <label class="popup-label">Name Italienisch</label><input id="name-input_it" class="input" type="text" name="name_it"placeholder="Name italienisch..."/>
          <label class="popup-label">Beschreibung</label> <input id="description-input" class="input" name="description"type="text" placeholder="Beschreibung..."/>
          <label class="popup-label">Beschreibung Italienisch</label> <input id="description-input_it" class="input" name="description_it"type="text" placeholder="Beschreibung Italienisch..."/>
          <label class="popup-label">Preis</label><input id="price-input" class="input" step=".1" name="price"type="number" placeholder="Preis..."/>
        <label class="popup-label">Zutaten</label><input id="zutaten-input" name="zutaten"class="input" type="text" placeholder="zutaten..."/>
          <label class="popup-label">Zutaten Italienisch</label><input id="zutaten-input_it" name="zutaten_it"class="input" type="text" placeholder="zutaten italienisch..."/>
          <label class="popup-label">Icon</label><input id="icon-input" name="icon"class="input" type="file" accept="image/*" placeholder="Icon"/>
        <input name="id" id="id-input" type="hidden" >
        <input name="katgorie" type="hidden" value="<?php echo $_GET['kategorie']?>">
        <input id="produkt-submit"class="submit" type="submit" value="Produkt erstellen">
      </div>
</form>
