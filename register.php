<?php
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
        
        //Indien sprake is van correcte input wordt doorgegaan naar het checken of er sprake is van een nieuw account
        if ($errName == "" && $errMail == "" && $errPassword == "") {
            
            if(checkNewAccount($email)) {
                
                //Bij het bestaan van een nieuw uniek account wordt deze aangemaakt
                registerNewAccount($name, $email, $password);
            } else {
                $errMail = "Dit emailadres is al in gebruik";
            }
        }
    }
    
    showBody($name, $email, $errName, $errMail, $errPassword);

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

    function checkNewAccount($email) {
        
        $users = fopen("users.txt", "r") or die("Unable to open file!");
        
        $accounts = array();        
        $i = 0;
        
        //Leest eerst de users uit het bestand in een array
        while(!feof($users)) {
            $accounts[$i] = fgets($users);
            $i++;
        }
        fclose($users);
    
        //Vergelijkt de emailadressen van users vervolgens met het opgegeven emailadres
        $amountOfAccounts = count($accounts);
        for($x = 0; $x < $amountOfAccounts; $x++) {
            $checkEmail[$x] = explode("|", $accounts[$x]);
        
            if($checkEmail[$x][0] == $email) {
                return False;
            } 
        }
        
        return True;            
    }
    
    function registerNewAccount($name, $email, $password) {
        
        //Zet de nieuw opgegeven user op de volgende line
        $users = fopen("users.txt", "a") or die("Unable to open file!");
        $txt = $email . '|' . $name . '|' . $password . PHP_EOL;
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