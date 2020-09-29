<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles/frontend.css?<?php echo date("h:i:sa"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon"
          type="image/png"
          href="images/FaviconRH.svg">
</head>
<body>
<?php
if ($lang === '') {
    if (isset($_GET["lang"])) {
        if ($_GET["lang"] == 'de' || $_GET["lang"] == 'it') {
            $lang = $_GET["lang"];
            $LANGUAGE = $lang;
        }
    } else {
        $lang = "de";
    }
} else {
    $_SESSION["language"] = $lang;
}
?>
<div id="content">
    <legend>
        <h1>

            <img src="images/FaviconRH.svg" id="logo"/>
            <a class="page-title">
            <?php
            if (isset($_GET['kategorie'])) {
                if ($_GET['kategorie'] == 'undefined') {
                    if ($lang == 'it') {
                        echo "Categorie";
                    } else {
                        echo "Kategorien";
                    }

                } else {
                    $kategorie = Kategorie::finde($_GET['kategorie']);
                    if ($lang == 'it') {
                        echo $kategorie->getName_it();
                    } else {
                        echo $kategorie->getName();
                    }
                }
            } else {
                if ($lang == 'it') {
                    echo "Categorie";
                } else {
                    echo "Kategorien";
                }
            }
            ?>
            </a>
            <?php

            if (isset($_GET['kategorie'])) {
                $kategorie_json = Kategorie::finde($_GET['kategorie']);
                $kat_json = array('id' => $kategorie_json->getId(), 'name' => $kategorie_json->getName(), 'description' => $kategorie_json->getDescription(), 'subkategorie' => $kategorie_json->getSubkategorie(), 'icon' => $kategorie_json->getIcon());
            }
            if (isset($_GET['kategorie'])) {
                ?>
                <div id="back" alt="Zurück" title="Zurück" onclick="back(<?php echo $_GET['kategorie'] ?>)"></div>
            <?php } ?>
            <div class="custom-select">
                <select name="languages" id="lang" onchange="changeLang(<?php if (isset($_GET["kategorie"])) {
                    echo $_GET['kategorie'];
                } ?>)">
                    <option value="de">DE</option>
                    <option value="it" <?php if (isset($_GET["lang"]) || isset($_SESSION["language"])) {
                        if ($_SESSION["language"] === "it" ) {
                            echo "selected";
                        }
                    } ?>>IT
                    </option>
                </select>
            </div>
        </h1>
    </legend>
    <div class="kategories">
        <?php

        if ($kategorien) {

            if (is_array($kategorien)) {
                foreach ($kategorien as $kat) {
                    echo "<div class='kategorie' onclick='openKategorie(" . $kat->getId() . ")'>";
                    echo "<label><div class='images' style='background-image: url(../images/kategorie/" . $kat->getIcon() . "'></div></label>";
                    $kat_name = ($lang == 'it') ? $kat->getName_it() : $kat->getName();
                    echo "<label><a class='kategorie-titel'>" . $kat_name . "</a></label>";
                    echo "</div>";
                }
            } else {
                echo "<div class='kategorie' onclick='openKategorie(" . $kategorien->getId() . ")'>";
                echo "<label><div class='images' style='background-image: url(../images/kategorie/" . $kategorien->getIcon() . "'></div></label>";
                $kat_name = ($lang == 'it') ? $kategorien->getName_it() : $kategorien->getName();

                echo "<label><a class='kategorie-titel'>" . $kat_name . "</a></label>";
                echo "</div>";
            }
        } elseif ($produkte) {
            if (is_array($produkte)) {
                foreach ($produkte as $pro) {
                    $produkt_kategorie = Kategorie::finde($pro->getKategorie());
                    $kat_image = $produkt_kategorie->getIcon();
                    $background = ($pro->getIcon() == NULL) ? "url(../images/kategorie/" . $kat_image . ')' : "url(../images/produkt/" . $pro->getIcon() . ')';
                    $pdkt = array('id' => $pro->getId(), 'name' => ($lang == 'it') ? $pro->getName_it() : $pro->getName(), 'description' => ($lang == 'it') ? $pro->getDescription_it() : $pro->getDescription(), 'price' => $pro->getPrice(), 'zutaten' => ($lang == 'it') ? $pro->getZutaten_it() : $pro->getZutaten(), 'icon' => $background);
                    echo "<div class='product'   onclick='showPopup(" . json_encode($pdkt) . "," . $_GET['kategorie'] . ")'>";
                    echo "<label><div class='images' style='background-image: " . $background . "'></div></label>";
                    $pro_name = ($lang == 'it') ? $pro->getName_it() : $pro->getName();
                    $pro_des = ($lang == 'it') ? $pro->getDescription_it() : $pro->getDescription();
                    $pro_crea = $pro->getHersteller();
                    $pro_pri = $pro->getPrice();
                    echo "<label class='product-informations'><a class='product-titel'>" . $pro_name . "</a><p class='product-creater'>" . $pro_crea . "</p><p class='product-description'>" . $pro_des . "</p><p class='product-price'>" . $pro_pri . "</p></label>";
                    echo "</div>";
                }
            } else {
                $produkt_kategorie = Kategorie::finde($produkte->getKategorie());
                $kat_image = $produkt_kategorie->getIcon() . ')';
                $background = ($produkte->getIcon() == NULL) ? "url(../images/kategorie/" . $kat_image . ')' : "url(../images/produkt/" . $produkte->getIcon();

                $pdkt = array('id' => $produkte->getId(), 'name' => ($lang == 'it') ? $produkte->getName_it() : $produkte->getName(), 'description' => ($lang == 'it') ? $produkte->getDescription_it() : $produkte->getDescription(), 'price' => $produkte->getPrice(), 'zutaten' => ($lang == 'it') ? $produkte->getZutaten_it() : $produkte->getZutaten(), 'icon' => $background);
                echo "<div class='product'   onclick='showPopup(" . json_encode($pdkt) . "," . $_GET['kategorie'] . ")'>";
                echo "<label><div class='images' style='background-image: " . $background . "'></div></label><br>";
                $pro_name = ($lang == 'it') ? $produkte->getName_it() : $produkte->getName();
                $pro_des = ($lang == 'it') ? $produkte->getDescription_it() : $produkte->getDescription();
                echo "<label><a class='product-titel'>" . $pro_name . "</a><br><p class='product-description'>" . $pro_des . "</p></label>";
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
    function showPopup(json, kat) {
        var popup = document.getElementById('popup');
        popup.classList.toggle("visible");
        document.getElementById("content").classList.toggle("blur");
        var namefield = document.getElementById('popup-name');
        namefield.innerHTML = json['name'];
        var desfield = document.getElementById('popup-description');
        desfield.innerHTML = json['description'];
        var pricefield = document.getElementById('popup-price');
        pricefield.innerHTML = json['price'];
        var zutatenfield = document.getElementById('popup-zutaten');
        zutatenfield.innerHTML = json['zutaten'];
        var iconfield = document.getElementById('popup-icon');
        iconfield.style.backgroundImage = json["icon"];

        var title = document.getElementById('produkt-title');
        title.innerHTML = json['name'];
    }

    function openKategorie(url) {
        location.href = 'index.php?kategorie=' + url;
    }

    function back(kat) {
        location.href = 'index.php?aktion=stepback&kategorie=' + kat;
    }

    function changeLang(kat) {
        var e = document.getElementById("lang");
        var pickedLang = e.options[e.selectedIndex].value;
        var link;
        if (kat == null) {
            link = 'index.php?&lang=' + pickedLang;
        } else {
            link = 'index.php?kategorie=' + kat + '&lang=' + pickedLang;
        }
        window.location.href = link;
    }
</script>
<!--<script type="text/javascript">
var x, i, j, l, ll, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);    
</script>-->

</body>
</html>
