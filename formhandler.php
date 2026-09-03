<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $naam = htmlspecialchars($_POST["naam"]); 
    $straat = htmlspecialchars($_POST["straat"]);
    $nr = htmlspecialchars($_POST["nr."]);
    $land = htmlspecialchars($_POST["land"]);
    $emailAdres = htmlspecialchars($_POST["email-adres"]);
    $landcode = htmlspecialchars($_POST["+"]);
    $telefoonnummer = htmlspecialchars($_POST["telefoonnummer"]);

    echo "Dit is de data die door de gebruiker is verstuurd:";
    echo "<br>";
    echo $naam;

    if (empty($naam)){
        header("Location: ./index.php");
        exit();  

    }   

    echo "<br>";
    echo $straat . $nr;
    echo "<br>";
    echo $land;
    echo "<br>";
    echo $emailAdres;
    echo "<br>";
    echo $landcode . $telefoonnummer;

    header("Location: ./index.php");

} 

else {
    header("Location: ./index.php");
}
