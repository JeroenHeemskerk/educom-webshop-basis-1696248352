<?php

    /*function showRegisterBody() {
        
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
    
    }*/   

    function showRegisterBody($data){
        
        //Formulier met naam, emailadres en emailadrescheck
        echo '<br>
            <form method="post" action="index.php">
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $data['name']; echo '"><span>'; echo $data['errName']; echo '</span><br>
            <label for="email">Emailadres:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $data['email']; echo '"><span>'; echo $data['errMail']; echo '</span><br>
            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" value=""><span>'; echo $data['errPassword']; echo '</span><br>
            <label for="passwordTwo">Herhaal uw wachtwoord:</label>
            <input type="password" id="passwordTwo" name="passwordTwo" value=""><br>';
            
        //Verborgen variabele om ervoor te zorgen dat de registerpagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="register">';
        
        //Verzendknop
        echo '<input type="submit" value="Verzenden">
        </form>';
    }
?>