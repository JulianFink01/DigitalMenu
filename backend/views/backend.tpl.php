<html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="styles/backend.css">
  </head>
  <body>

    <div id="content">
      <legend><h1>Kategorien<img src="images/add.png" alt="Kategorie hinzufügen" title="Kategorie hinzufügen" onclick="showPopup('addKategorie')"/></h1></legend>
    </div>

    <?php
      include("views/addKategorie.tpl.php");
    ?>

    <script type="text/javascript">
        function showPopup(id){
          var popup = document.getElementById(id);
          popup.classList.toggle("visible");
          document.getElementById("content").classList.toggle("blur");
        }
    </script>

  </body>
</html>
