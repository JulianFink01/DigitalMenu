<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles/home.css?<?php echo date("h:i:sa"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"
          type="image/png"
          href="frontend/images/FaviconRH.svg">
    <script type="text/javascript">
        function changeLang(kat) {
            var e = document.getElementById("lang");
            var pickedLang = e.options[e.selectedIndex].value;
            var link;
            if (kat == null) {
                link = 'index.php?&lang=' + pickedLang;
            } else {
                link = 'index.php?&lang=' + pickedLang;
            }
            window.location.href = link;
        }
    </script>
</head>
<body>


<?php
//localization
$h2 = "Unsere Speißekarte finden Sie auf der nächsten Seite";
$a = "Entdecken Sie hier unsere Speißekarte";

if(isset($_GET["lang"])){
    if($_GET["lang"] === 'it'){
        $h2 = "Puoi trovare il nostro menu nella pagina successiva";
        $a = "Scopri qui il nostro menù";
    }
}

?>


<div id="content">
    <div id="content-inner">
        <h1>Regelbergerhof</h1>
        <h2><?php echo $h2;?></h2>
        <div class="custom-select">
            <select name="languages" id="lang" onchange="changeLang()">
                <option value="de">DE</option>
                <option value="it" <?php if (isset($_GET["lang"])) {
                if ($_GET["lang"] === "it" ) {
                    echo "selected";
                }
            }else if ( isset($_SESSION["language"])) {
                if ($_SESSION["language"] === "it" ) {
                    echo "selected";
                }
            } ?>>IT
                </option>
            </select>
        </div>
        <?php
        $lang = "de";
        if (isset($_GET["lang"])){
            if ($_GET["lang"] === "it" ) {
                $lang = "it";
            }
        }else  if (isset($_SESSION["language"])){
            if ($_SESSION["language"] === "it" ) {
                $lang = "it";
            }
        }
        ?>
        <a href="frontend/index.php?lang=<?php echo $lang; ?>" ><?php echo $a;?></a>
        <img src="images/background/FaviconRH.svg">
    </div>
</div>
</body>
</html>
