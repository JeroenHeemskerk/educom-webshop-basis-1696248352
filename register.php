<?php
    $name = $errName = $errMail = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Eerst worden ongewenste karakters verwijderd
        $name = testInput($_POST["name"]);
        $email = testInput($_POST["email"]);
        $emailTwo = testInput($_POST["emailTwo"]);
        
        //Vervolgens wordt gekeken of correcte input gegeven is
        $errName = checkName($name);
        $errMail = checkEmailTwo($email, $emailTwo);
        $errMail = checkEmail($email);
        
        //Indien sprake is van correcte input wordt doorgegaan naar het mogelijk registreren van het account
        if ($errName == "" && $errMail == "") {
            registerAccount();
        }
    }
    
    showBody($name, $errName, $errMail);

    function checkName($name) {    
    
        if (!empty($_POST["name"])) {
                
            //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                return "Enkel letters en whitespaces zijn toegestaan";
            } else {
                return "";
            }
        } else {
            return "Naam moet ingevuld zijn";            
        }
    }
    
    function checkEmail($email) {
    
        if (!empty($_POST["email"])) {
                
            //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Vul een valide emailadres in";
            } else {
                return "";
            }
        } else {
            return "Emailadres moet ingevuld zijn";
        }
    }
    
    function checkEmailTwo($email, $emailTwo) {

        if (!empty($_POST["emailTwo"])) {
                
            //Als email niet leeg is wordt gekeken of er sprake is van een tweede emailadres welke gelijk moet zijn aan de eerste
            if ($email == $emailTwo) {
                return "";
            } else {
                return "Emailadressen moeten gelijk zijn aan elkaar";
            }
        } else {
            return "Een tweede emailadres moet ingevuld zijn";
        }    
    }

    function registerAccount() {
    }


    function showBody($name, $errName, $errMail){
        
        //Formulier met naam, emailadres en emailadrescheck
        echo '<br>
            <form method="post" action="index.php">
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $name; echo '"><span>'; echo $errName; echo '</span><br>
            <label for="email">Emailadres:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value=""><span>'; echo $errMail; echo '</span><br>
            <label for="emailTwo">Herhaal uw emailadres:</label>
            <input type="text" id="emailTwo" name="emailTwo" placeholder="j.doe@example.com" value=""><br>';
            
        //Verborgen variabele om ervoor te zorgen dat de registerpagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="register">';
        
        //Verzendknop
        echo '<input type="submit" value="Verzenden">
        </form>';
    }
    
    //Haalt ongewenste karakters en spaties weg
    function testInput($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
    }
?>