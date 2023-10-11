<?php
    $name = $errName = $errMail = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $geldigeInput = checkInput();
        if ($geldigeInput) {
            register();
        }
    }
    showBody($name, $errName, $errMail);

    function checkInput() {    
        $name = testInput($_POST["name"]);
        $email = testInput($_POST["email"]);
        $emailCheck = testInput($_POST["emailCheck"]);
    
        if (!empty($_POST["name"])) {
                
            //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $errName = "Enkel letters en whitespaces zijn toegestaan";
                return False;
            } else {
                return True;
            }
        } else {
            $errName = "Naam moet ingevuld zijn";
            return False;
        }
    
        if (!empty($_POST["email"])) {
                
            //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errMail = "Vul een valide emailadres in";
                return False;
            } else {
                return True;
            }
        } else {
            $errMail = "Emailadres moet ingevuld zijn";
            return False;
        }

        if (!empty($_POST["emailCheck"])) {
                
            //Als email niet leeg is wordt gekeken of er sprake is van een tweede emailadres welke gelijk moet zijn aan de eerste
            if ($email == $emailCheck) {
                return True;
            } else {
                $errMail = "Emailadressen moeten gelijk zijn aan elkaar";
                return False;
            }
        } else {
            $errMail = "Een tweede emailadres moet ingevuld zijn";
            return False;
        }    
    }

    function register() {
    }


    function showBody($name, $errName, $errMail){    
        echo '<form method="post" action="index.php">';
        echo '<label for="name">Naam:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $name; echo '"><span>'; echo $errName; echo '</span><br>
            <label for="email">Emailadres:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value=""><span>'; echo $errMail; echo '</span><br>
            <label for="emailCheck">Herhaal uw emailadres:</label>
            <input type="text" id="emailCheck" name="emailCheck" placeholder="j.doe@example.com" value=""><br>';
        
        echo '<input type="submit" value="Verzenden">
        </form>';
    }

    function testInput($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
    }
?>