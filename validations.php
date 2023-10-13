<?php
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
    
    function checkRegisterEmail($email) {
    
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
    
    function checkPassword($password) {
        
        if (empty($_POST["password"])){
            return "Er is geen wachtwoord opgegeven";
        }
    }
    
    function checkRegisterPassword($password, $passwordTwo) {
            
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
    
    function testInput($input) {
        
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

?>