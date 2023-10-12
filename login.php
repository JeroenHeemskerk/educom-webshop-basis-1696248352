<?php
    $email = $errMail = $errPassword = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Eerst worden ongewenste karakters verwijderd
        $email = testInput($_POST["email"]);
        $password = testInput ($_POST["password"]);
        
        //Vervolgens wordt gekeken of correcte input gegeven is
        $errMail = checkEmail($email);
        $errPassword = checkPassword($password);
        
        //Indien sprake is van correcte input wordt doorgegaan naar het checken of er sprake is van een bestaand account
        if ($errMail == "" && $errPassword == "") {
            
            if (login($email, $password)) {                
                //Het emailadres van het bestaand account wordt toegevoegd aan de session
                $_SESSION["user"] = $email;
            } else { 
            $errMail = "Emailadres onbekend of foutief wachtwoord";
            }
        }
    }
    
    showBody($email, $errMail, $errPassword);
    
    function showBody($email, $errMail, $errPassword){
        
        //Inlogformulier welke om een emailadres en een wachtwoord verzoekt
        echo '<br>
            <form method="post" action="index.php">
            <label for="email">Vul uw emailadres in:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $email; echo '"><span>'; echo $errMail; echo '</span><br>
            <label for="password">Vul uw wachtwoord in:</label>
            <input type="password" id="password" name="password" value=""><span>'; echo $errPassword; echo '</span><br>';

            
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
        
        //Leest eerst de users uit het bestand in een array
        $accounts = array();        
        $i = 0;
        while(!feof($users)) {
            $accounts[$i] = fgets($users);
            $i++;
        }
        fclose($users);
        
        $amountOfAccounts = count($accounts);
        for($x = 0; $x < $amountOfAccounts; $x++) {
            $checkUser[$x] = explode("|", $accounts[$x]);
        
            if($checkUser[$x][0] == $email && $checkUser[$x][2] == $password) {
                return True;
            } 
        }
        
        return False;
        
    }
    
    function testInput($input) {
        
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
    }
?>