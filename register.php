<?php

    function showRegisterBody() {
        
    $name = $email = $errName = $errMail = $errPassword = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Eerst worden ongewenste karakters verwijderd
        $name = testInput($_POST["name"]);
        $email = testInput($_POST["email"]);
        $password = testInput($_POST["password"]);
        $passwordTwo = testInput($_POST["passwordTwo"]);
        
        //Vervolgens wordt gekeken of correcte input gegeven is
        $errName = checkName($name);
        $errMail = checkEmail($email);
        $errPassword = checkPassword($password, $passwordTwo);
        
        //Indien sprake is van correcte input wordt een nieuw account aangemaakt en de gebruiker geredirect naar de loginpagina
        if ($errName == "" && $errMail == "" && $errPassword == "") {
                
            //Bij het bestaan van een nieuw uniek emailadres wordt deze aangemaakt
            registerNewAccount($name, $email, $password);                
            //HIER EEN REDIRECT NAAR DE LOGINPAGINA
        }
    }
    
    showBody($name, $email, $errName, $errMail, $errPassword);
    
    }

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
            }
            if (checkNewEmail($email)) {
                //Als email niet leeg en valide is, wordt gekeken of sprake is van een nieuw emailadres
                return "";
            } else {
                return "Dit emailadres is al in gebruik";
            }
        } else {
            return "Emailadres moet ingevuld zijn";
        }
    }
    
    
    function checkPassword($password, $passwordTwo) {
        
        if (empty($_POST["password"])){
            return "Er is geen wachtwoord opgegeven";
        }
            
        if (!empty($_POST["passwordTwo"])) {
                
            //Als password niet leeg is wordt gekeken of er sprake is van een tweede wachtwoord welke gelijk moet zijn aan de eerste
            if ($password == $passwordTwo) {
                return "";
            } else {
                return "De wachtwoorden moeten gelijk zijn aan elkaar";
            }
        } else {
            return "Het wachtwoord moet ter controle nog een keer ingevuld worden";
        }    
    }

    function checkNewEmail($email) {
        
        $users = fopen("users.txt", "r") or die("Unable to open file!");                
        //Bekijkt of het nieuw ingegeven emailadres identiek is
        while(!feof($users)) {
            $account = explode("|", fgets($users));
            if ($account[0] == $email) {
                return false;
            }
        }
        fclose($users);
        
        return True;            
    }
    
    function registerNewAccount($name, $email, $password) {
        
        //Zet de nieuw opgegeven user op de volgende line
        $users = fopen("users.txt", "a") or die("Unable to open file!");
        $txt = PHP_EOL . $email . '|' . $name . '|' . $password;
        fwrite($users, $txt);
        fclose($users);
    }
    

    function showBody($name, $email, $errName, $errMail, $errPassword){
        
        //Formulier met naam, emailadres en emailadrescheck
        echo '<br>
            <form method="post" action="index.php">
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $name; echo '"><span>'; echo $errName; echo '</span><br>
            <label for="email">Emailadres:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $email; echo '"><span>'; echo $errMail; echo '</span><br>
            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" value=""><span>'; echo $errPassword; echo '</span><br>
            <label for="passwordTwo">Herhaal uw wachtwoord:</label>
            <input type="password" id="passwordTwo" name="passwordTwo" value=""><br>';
            
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