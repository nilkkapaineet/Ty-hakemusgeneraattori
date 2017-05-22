<?php

echo '
<head>
<Content-Type: text/html; charset=ISO-8859-1>
<title>TyÃÂ¶hakemusgeneraattori</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <style>
        body {
            max-width: 50em;
            margin: auto;
            margin-top: 80px;
            padding: 8px;
            font-family: "Myriad Web Pro", sans-serif;
            line-height: 2.7ex;
            background-color: white;
            background-repeat: repeat-x;
            padding-bottom: 64px;
        }
        #hakemus {
            white-space: pre-line;
        }
        label {
        }
        input {
            padding-left: 4px;
            font-family: "Myriad Web Pro", sans-serif;
            border: none;
            border-bottom: 1px solid gray;
        }
        button {
            border: none;
            background-color: #bf83a9;
            color: #fbe9f4;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0px 2px 0px #88446f;
            margin-bottom: 2px;
            outline: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #ce8eb7;
        }
        button:active {
            margin-top: 2px;
            margin-bottom: 0px;
            box-shadow: none;
        }
        hr {
            border: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<html>
Tervetuloa työhakemusgeneraattoriin. Hallitus suunnittelee karenssin uhalla tehtäviä pakkotyöhakemuksia. 
 Tämän generaattorin tarkoituksena on helpottaa työhakemusten tekoa. Kirjoita nimikenttään nimesi ja anna toivottu työpaikkakunta.
 Generaattori hakee työpaikkoja Oikotien hausta ja generoi sinulle yksilöllisen hakemuksen sopivin palkkatoiveineen.<p></p>
<form method=post action=tyohakemusgeneraattori.php>
  Anna nimesi: <input type="text" name="name">
  Toivottu työpaikan sijainti: <input type=text name=city value=Helsinki>
  <input type="submit" value="Submit">
</form>
</html>

';

$adjectives = array(
"älykäs",
"looginen",
"nopea oppija",
"osaan katsoa asioita isossa kuvassa",
"tiimipelaaja",
"ulospäin suuntautunut",
"innostunut",
"välittävä",
"huolehtiva",
"ahkera",
"iloinen",
"empaattinen",
"ystävällinen",
"kärsivällinen"
);

$descriptions = array(
"Pystyn sopeutumaan helposti tilanteisiin. Olen parhaimmillani muuttuvassa ympäristössä ja pystyn muuttamaan esteet mahdollisuuksiksi.",
"Pyrin koko ajan tuomaan lisäarvoa. Etsin aktiivisesti mahdollisuuksia tilanteista, joista muut eivät niitä löydä. Muutan ideat projekteiksi ja projektit menestykseksi.", 
"Olen luova. Laajan osaamisalueeni takia pystyn ratkaisemaan pulmatilanteet luovasti ja tuomaan monipuolisia ratkaisuvaihtoehtoja. Uskon luovuuteni nostavan yrityksenne kilpailukykyä.",
"Keskityn aina asetettuun tavoitteeseen ja pyrin aina tuottamaan hyvälaatuista työtä ajoissa.",
"Tiedän tämän alan kuin omat taskuni. Monen kokemusvuoteni jälkeen voin varmuudella sanoa olevani loistava kandidaatti tähän tehtävään, sillä olen tehokas ja osaan soveltaa osaamaani.",
"Olen motivoitunut työskentelemään täällä. Olen seurannut yrityksen kehitystä jo pitkään, ja koen olevani loistava lisä tiimiinne.",
"Olen loistava tiimipeluri. Olen iloinen, motivoitunut, ja rakastan työtä. Saan myös muut ympärilläni innostumaan.",
"Olen ekstrovertti, jolta luonnistuu myös itsenäinen työskentely. Uskon olevani paras kandidaatti tähän tehtävään, sillä aiempien työkokemusteni lisäksi olen futisharrastukseni kautta oppinut myös esimiestaitoja toimiessani joukkueen kapteenina.",
"Olen asunut useissa eri maissa. Näiden vuosien aikana opin selviytymään uusista tilanteista ja selättämään odottamattomat haasteet. Näenkin ongelmat kehityksen kohteina, ja keksin ratkaisuja nopeasti.",
"Olen älyttömän nopea oppimaan. Ennen Pariisin matkaani opettelin puhumaan ranskaa kahdessa kuukaudessa omatoimisesti."
);

$haut = array("MOL:n", "Oikotien", "Monsterin", "Uranuksen", "Baronan", "tuttavan", "entisen kolleegan");

if (isset($_POST['city'])) { 
	$city = $_POST['city'];
} else {
	$city = "";
}
if (isset($_POST['name'])) { 
	$name = $_POST['name'];
} else {
	$name = "";
}

$adjSize = count($adjectives);
$desSize = count($descriptions);

$numbers = range(0, ($adjSize-1));
shuffle($numbers);
$adjo1 = $adjectives[$numbers[0]];
$adjo2 = $adjectives[$numbers[1]];
$adjo3 = $adjectives[$numbers[2]];

$desc = $descriptions[rand(0,count($descriptions))];

$homepage = file_get_contents('https://tyopaikat.oikotie.fi/haku?jq=' . $city . '&sort_by=score&page=0');

$results1 = getContents($homepage, '<h4 class="job-title" property="schema:title schema:description">', '</h4>');
$results2 = getContents($homepage, '<span property="schema:name">', '</span>');

$merged = array();
$merged = array_combine($results1, $results2);

if ($name != '') {
foreach($merged as $x => $x_value) {
	$x = preg_replace('/[\[{\(].*[\]}\)]/U' , '', $x);
	echo $name . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " . date("d.m.Y");
	echo "<p></p>";
	echo $x_value;
	echo "<p></p>
	Hyvä rekryvastaava,<br>
	Sain tietää " . $haut[rand(0,(count($haut)-1))] . " kautta, että teillä on haussa " . $x. ".";
	echo " Olen kovin kiinnostunut tästä työpaikasta. <p>";
	echo $descriptions[rand(0,(count($descriptions)-1))];
	echo " Voisin kuvailla itseäni sanoilla ";
	echo "" . $adjo1 . ", " . $adjo2 . " ja " . $adjo3 . ". Näillä ominaisuuksilla olen taatusti erittäin pätevä työntekijä " . $x_value . "-yrityksessä.";
	echo "<p>Toivon, että hakemukseni johtaa positiiviseen yhteydenottoon. 
	Toiveeni palkasta " . $x . "-ammatissa " . rand(1570, 5800) . " euroa kuussa. <br> 
	Keskustelen mieluusti lisää tästä tehtävästä.<p>
	Ystävällisin terveisin, <br> " . $name . "</p>";
	echo "<p>----------------------------------------------------------------------------</p>";
    //echo "Työpaikka: " . $x . ", Työnantaja: " . $x_value;
    echo "<br>";
}
}


function getContents($str, $startDelimiter, $endDelimiter) {
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($str, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }
    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }

  return $contents;
}

?>
