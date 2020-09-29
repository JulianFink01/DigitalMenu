<form class="popup"  enctype="multipart/form-data" id="editHome" method="post" action="index.php?aktion=saveBackground">
    <div id="close" title="Popup schließen" onclick="showPopup('editHome')"></div>

    <legend  class="popup-legend"><h1 id="produkt-title">Hintergrund ändern</h1></legend>
    <div class="flex">
      <label class="popup-label">Hintergrund</label><input id="icon-input" name="icon"class="input" type="file" accept="image/*" placeholder="Icon"/>
        <input id="produkt-submit"class="submit" type="submit" value="Hintergrund ändern"/>
    </div>
</form>
