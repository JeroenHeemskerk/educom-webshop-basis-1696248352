<?php

    function showLoginBody(){
        
    $email = $errMail = $errPassword = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Eerst worden ongewenste karakters verwijderd
        $email = testInput($_POST["email"]);
        $password = testInput ($_POST["password"]);
        
        //Vervolgens wordt gekeken of correcte input gegeven is
        $errMail = checkEmail($email);
        $errPassword = checkPassword($password);
        
        //Indien sprake is van correcte input wordt doorgegaan naar het checken of er sprake is van een bestaand account en wordt daarop ingelogd
        if ($errMail == "" && $errPassword == "") {
            
            if (!login($email, $password)) {
                
                $errMail = "Emailadres onbekend of foutieve combinatie emailadres en wachtwoord";
            } else {
                //HIER EEN REDIRECT NAAR HOME.
            }
        }
    }
    
    showContentBody($email, $errMail, $errPassword);
    
    }
    
    function showContentBody($email, $errMail, $errPassword){
        
        //Inlogformulier welke om een emailadres en een wachtwoord verzoekt
        echo '<br>
            <form method="post" action="index.php">
            <label for="email">Vul uw emailadres in:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $email; echo '"><span>'; if ($errMail != "") {echo '<br>' . $errMail;} echo '</span><br>
            <label for="password">Vul uw wachtwoord in:</label>
            <input type="password" id="password" name="password" value=""><br><span>'; echo $errPassword; echo '</span><br>';

            
        //Verborgen variabele om ervoor te zorgen dat de loginpagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="login">';
        
        //Verzendknop
        echo '<input type="submit" value="Login">
        </form>';
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
    
    function checkPassword($password) {
        
        if (empty($_POST["password"])){
            return "Er is geen wachtwoord opgegeven";
        }        
    }
    
    function login($email, $password) {
        
        $users = fopen("users.txt", "r") or die("Unable to open file!");
        
        //Controleer of email en password overeenkomen met een bestaande user
        while(!feof($users)) {
            
            $account = explode("|", fgets($users));
            trim($account[2]);
            if ($account[0] == $email && $account[2] == $password) {
                
                //De naam van het bestaand account wordt toegevoegd aan de session indien emailadres en wachtwoord met elkaar overeenkomen
                $_SESSION["user"] = $account[1];
                return True;
            }
        }
        fclose($users);
        
        return False;        
    }
    
    function testInput($input) {
        
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>