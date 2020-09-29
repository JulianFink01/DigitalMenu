<?php if (!isset($_SESSION["loggedIn"])) {
    header('Location: index.php?aktion=login');
}

?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles/backend.css?<?php echo date("h:i:sa"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"
          type="image/png"
          href="images/FaviconRH.svg">
</head>
<body>

<div id="content">
    <legend>
        <h1>

            <img src="images/FaviconRH.svg" id="logo"/>
            <a class="page-title">
                <?php
                if (isset($_GET['kategorie'])) {
                    if ($_GET['kategorie'] == 'undefined') {
                        echo "Kategorien";
                    } else {
                        $kategorie = Kategorie::finde($_GET['kategorie']);
                        echo $kategorie->getName();
                    }
                } else {
                    echo "Kategorien";
                }
                ?>   </a>
            <?php
            if ($kategorien) {
                ?>
                <div id="addFolder" alt="Kategorie hinzufügen" title="Kategorie hinzufügen"
                     onclick="showPopup('addKategorie',<?php if (isset($_GET['kategorie'])) {
                         echo $_GET['kategorie'];
                     } else {
                         echo 'undefined';
                     } ?>)"></div>
                <?php
            } elseif ($produkte) {
                ?>
                <div id="add" alt="Produkt hinzufügen" title="Produkt hinzufügen"
                     onclick="showPopup('addProdukt', <?php if (isset($_GET['kategorie'])) {
                         echo $_GET['kategorie'];
                     } else {
                         echo 'undefined';
                     } ?>)"></div>
                <?php
            } elseif (!$kategorien && !$produkte) {
                ?>
                <div id="addFolder" alt="Kategorie hinzufügen" title="Kategorie hinzufügen"
                     onclick="showPopup('addKategorie', <?php if (isset($_GET['kategorie'])) {
                         echo $_GET['kategorie'];
                     } else {
                         echo 'undefined';
                     } ?>)"></div>
                <div id="add" alt="Produkt hinzufügen" title="Produkt hinzufügen"
                     onclick="showPopup('addProdukt', <?php if (isset($_GET['kategorie'])) {
                         echo $_GET['kategorie'];
                     } else {
                         echo 'undefined';
                     } ?>)"></div>
                <?php
            }

            if (isset($_GET['kategorie'])) {
                $kategorie_json = Kategorie::finde($_GET['kategorie']);
                $kat_json = array('id' => $kategorie_json->getId(), 'name' => $kategorie_json->getName(), 'name_it' => $kategorie_json->getName_it(), 'description' => $kategorie_json->getDescription(), 'description_it' => $kategorie_json->getDescription_it(), 'subkategorie' => $kategorie_json->getSubkategorie(), 'icon' => $kategorie_json->getIcon());
                echo "<div id='edit' src='images/edit.png' alt='Kategorie bearbeiten' title='Kategorie bearbeiten'    onclick='editKategorie(" . json_encode($kat_json) . "," . $_GET['kategorie'] . ")'></div>";

                ?>

                <div id="delete" src="images/delete.png" alt="Kategorie löschen" title="Kategorie löschen"
                     onclick="deleteKategorie(<?php echo $_GET['kategorie'] ?>)"></div>
                <?php
            } else {
                ?>
                <div id='edit-bg' alt='Home bearbeiten' title='Haupthintergrund bearbeiten'
                     onclick="showPopup('editHome', 'undefined')"></div>
                <?php
            }
            if (isset($_GET['kategorie'])) {
                ?>
                <div id="back" alt="Zurück" title="Zurück" onclick="back(<?php echo $_GET['kategorie'] ?>)"></div>
            <?php } ?>
        </h1>
    </legend>
    <div class="kategories">
        <?php

        if ($kategorien) {

            if (is_array($kategorien)) {
                foreach ($kategorien as $kat) {
                    echo "<div class='kategorie' onclick='openKategorie(" . $kat->getId() . ")'>";
                    echo "<label><div class='images' style='background-image: url(../images/kategorie/" . $kat->getIcon() . "'></div></label>";
                    echo "<label><a class='kategorie-titel'>" . $kat->getName() . "</a></label>";
                    echo "</div>";
                }
            } else {
                echo "<div class='kategorie' onclick='openKategorie(" . $kategorien->getId() . ")'>";
                echo "<label><div class='images' style='background-image: url(../images/kategorie/" . $kategorien->getIcon() . "'></div></label>";
                echo "<label><a class='kategorie-titel'>" . $kategorien->getName() . "</a></label>";
                echo "</div>";
            }
        } elseif ($produkte) {
            if (is_array($produkte)) {
                foreach ($produkte as $pro) {
                    $pdkt = array('id' => $pro->getId(), 'name' => $pro->getName(), 'name_it' => $pro->getName_it(), 'hersteller' => $pro->getHersteller(), 'description' => $pro->getDescription(), 'description_it' => $pro->getDescription_it(), 'price' => $pro->getPrice(), 'zutaten' => $pro->getZutaten(), 'zutaten_it' => $pro->getZutaten_it(), 'icon' => $pro->getIcon());
                    echo "<div class='product'   onclick='editProdukt(" . json_encode($pdkt) . "," . $_GET['kategorie'] . ")'>";
                    $produkt_kategorie = Kategorie::finde($pro->getKategorie());
                    $kat_image = $produkt_kategorie->getIcon();
                    $background = ($pro->getIcon() == NULL) ? "url(../images/kategorie/" . $kat_image : "url(../images/produkt/" . $pro->getIcon();
                    echo "<label><div class='images' style='background-image: " . $background . "'></div></label><br>";
                    echo "<label><a class='product-titel'>" . $pro->getName() . "</a><br><p class='product-description'>" . $pro->getDescription() . "</p></label>";
                    echo "</div>";
                }
            } else {
                $pdkt = array('id' => $produkte->getId(), 'name' => $produkte->getName(), 'name_it' => $produkte->getName_it(), 'hersteller' => $produkte->getHersteller(), 'description' => $produkte->getDescription(), 'description_it' => $produkte->getDescription_it(), 'price' => $produkte->getPrice(), 'zutaten' => $produkte->getZutaten(), 'zutaten_it' => $produkte->getZutaten_it(), 'icon' => $produkte->getIcon());
                echo "<div class='product'   onclick='editProdukt(" . json_encode($pdkt) . "," . $_GET['kategorie'] . ")'>";
                $produkt_kategorie = Kategorie::finde($produkte->getKategorie());
                $kat_image = $produkt_kategorie->getIcon();
                $background = ($produkte->getIcon() == NULL) ? "url(../images/kategorie/" . $kat_image : "url(../images/produkt/" . $produkte->getIcon();

                echo "<label><div class='images' style='background-image: " . $background . "'></div></label><br>";
                echo "<label><a class='product-titel'>" . $produkte->getName() . "</a><br><p class='product-description'>" . $produkte->getDescription() . "</p></label>";
                echo "</div>";
            }
        }

        ?>
    </div>
</div>
<?php
include("views/addProdukt.tpl.php");
include("views/addKategorie.tpl.php");
include("views/changeBackground.tpl.php");
?>

<script type="text/javascript">

    function showPopup(id, kat) {
        var popup = document.getElementById(id);
        popup.classList.toggle("visible");
        document.getElementById("content").classList.toggle("blur");

        //revert values to null
        if (id == 'addProdukt') {

            var produkttitel = document.getElementById('produkt-title');
            produkttitel.innerHTML = 'Produkt erstellen';
            var herstellerfield = document.getElementById('hersteller-input');
            herstellerfield.value = '';
            var namefield = document.getElementById('name-input');
            namefield.value = '';
            var namefield_it = document.getElementById('name-input_it');
            namefield_it.value = '';
            var desfield = document.getElementById('description-input');
            desfield.value = '';
            var desfield_it = document.getElementById('description-input_it');
            desfield_it.value = '';
            var pricefield = document.getElementById('price-input');
            pricefield.value = '';
            var zutatenfield = document.getElementById('zutaten-input');
            zutatenfield.value = '';
            var zutatenfield_it = document.getElementById('zutaten-input_it');
            zutatenfield_it.value = '';
            var idfield = document.getElementById('id-input');
            idfield.value = '';
            var submitfield = document.getElementById('produkt-submit');
            submitfield.value = "Produkt erstellen";
            popup.action = 'index.php?aktion=saveProdukt&kategorie=' + kat;
        }
        if (id == 'addKategorie') {
            var produkttitel = document.getElementById('kategorie-title');
            produkttitel.innerHTML = 'Kategorie erstellen';
            var namefield = document.getElementById('name-inp');
            namefield.value = '';
            var namefield_it = document.getElementById('name-inp-it');
            namefield_it.value = '';
            var desfield = document.getElementById('description-inp');
            desfield.value = '';
            var desfield_it = document.getElementById('description-inp-it');
            desfield_it.value = '';
            var subkatfield = document.getElementById('subkat-inp');
            subkatfield.value = kat;
            var idfield = document.getElementById('id-input');
            idfield.value = '';
            var iconfield = document.getElementById('icon-inp');
            iconfield.required = true;
            var submitfield = document.getElementById('kategorie-submit');
            submitfield.value = "Kategorie erstellen";
            popup.action = 'index.php?aktion=saveKategorie&kategorie=' + kat;
        }
        if (id == 'addKategorie' || id == 'addProdukt') {
            if (document.getElementById("delete-produkt"))
                document.getElementById("delete-produkt").remove();
        }
    }

    function openKategorie(url) {
        location.href = 'index.php?aktion=backend&kategorie=' + url;
    }

    function deleteKategorie(kat) {
        location.href = 'index.php?aktion=deleteKategorie&kategorie=' + kat;
    }

    function deleteProdukt(prod, kat) {
        //  location.href = 'index.php?aktion=deleteProdukt&produkt='+prod+'kategorie='+kat;
    }

    function editProdukt(json, kat) {
        console.log(json);
        var popup = document.getElementById('addProdukt');
        //inputs from editfield
        var produkttitel = document.getElementById('produkt-title');
        produkttitel.innerHTML = 'Produkt bearbeiten';
        var herstellerfield = document.getElementById('hersteller-input');
        herstellerfield.value = (json['hersteller'] == undefined) ? "" : json['hersteller'];
        var namefield = document.getElementById('name-input');
        namefield.value = (json['name'] == undefined) ? "" : json['name'];
        var namefield_it = document.getElementById('name-input_it');
        namefield_it.value = (json['name_it'] == undefined) ? "" : json['name_it'];
        var desfield = document.getElementById('description-input');
        desfield.value = (json['description'] == undefined) ? "" : json['description'];
        var desfield_it = document.getElementById('description-input_it');
        desfield_it.value = (json['description_it'] == undefined) ? "" : json['description_it'];
        var pricefield = document.getElementById('price-input');
        pricefield.value = (json['price'] == undefined) ? "" : json['price'];
        var zutatenfield = document.getElementById('zutaten-input');
        zutatenfield.value = (json['zutaten'] == undefined) ? "" : json['zutaten'];
        var zutatenfield_it = document.getElementById('zutaten-input_it');
        zutatenfield_it.value = (json['zutaten_it'] == undefined) ? "" : json['zutaten_it'];
        var idfield = document.getElementById('id-input');
        idfield.value = (json['id'] == undefined) ? "" : json['id'];
        var submitfield = document.getElementById('produkt-submit');
        submitfield.value = "Produkt bearbeiten";
        popup.action = 'index.php?aktion=editProdukt&id=' + json['id'] + '&kategorie=' + kat;

        var img = document.createElement('div');
        img.id = 'delete-produkt';
        img.className = 'delete-product';
        img.title = 'Produkt löschen';
        img.onclick = function deleteProdukt() {
            location.href = 'index.php?aktion=deleteProdukt&produkt=' + json['id'] + '&kategorie=' + kat;
        }

        popup.appendChild(img);
        //toggle
        popup.classList.toggle("visible");
        document.getElementById("content").classList.toggle("blur");
    }

    function editKategorie(json, kat) {
        var popup = document.getElementById('addKategorie');
        var obj = json;
        //inputs from editfield
        var produkttitel = document.getElementById('kategorie-title');
        produkttitel.innerHTML = 'Kategorie bearbeiten';
        var namefield = document.getElementById('name-inp');
        namefield.value = (json['name'] == undefined) ? "" : json['name'];
        var namefield_it = document.getElementById('name-inp-it');
        namefield_it.value = (json['name_it'] == undefined) ? "" : json['name_it'];
        var desfield = document.getElementById('description-inp');
        desfield.value = (json['description'] == undefined) ? "" : json['description'];
        var desfield_it = document.getElementById('description-inp-it');
        desfield_it.value = (json['description_it'] == undefined) ? "" : json['description_it'];
        var subkatfield = document.getElementById('subkat-inp');
        subkatfield.value = (json['subkategorie'] == undefined) ? "" : json['subkategorie'];
        var iconfield = document.getElementById('icon-inp');
        iconfield.required = false;
        var idfield = document.getElementById('id-input');
        idfield.value = (json['id'] == undefined) ? "" : json['id'];
        var submitfield = document.getElementById('kategorie-submit');
        submitfield.value = "Kategorie bearbeiten";
        popup.action = 'index.php?aktion=editKategorie&id=' + json['id'] + '&kategorie=' + kat;
        //toggle
        popup.classList.toggle("visible");
        document.getElementById("content").classList.toggle("blur");
    }

    function back(kat) {
        location.href = 'index.php?aktion=stepback&kategorie=' + kat;

    }
</script>

</body>
</html>
