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
    
    function checkEmailRegisterForm($email) {
    
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

    function validateContact() {
    
        $salutation = $name = $email = $phonenumber = $contactmode = $message = "";
        $errSalutation = $errName = $errMail = $errPhonenumber = $errContactmode = "";
        $valid = False;        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            //de input vanuit het formulier wordt hier in variabelen gezet en vervolgens opgeschoond door middel van de testInput functie
            $salutation = testInput($_POST["salutation"]);
            $name = testInput($_POST["name"]);
            $email = testInput($_POST["email"]);
            $phonenumber = testInput($_POST["phonenumber"]);
            $message = testInput($_POST["message"]);
    
        if (!empty($_POST["salutation"])) {
                
                //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
                if (!($salutation == "mr." || $salutation == "mrs." || $salutation == "neither")) {
                
                    $errSalutation = "Enkel 'Dhr.', 'Mvr.' of 'Geen van beide' zijn valide input";
                }
            } else {
                $errSalutation = "Aanhef moet ingevuld zijn";
            }
            
            if (!empty($_POST["name"])) {
                
                //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $errName = "Enkel letters en whitespaces zijn toegestaan";
                }
            } else {
                $errName = "Naam moet ingevuld zijn";
            }
            
            if (!empty($_POST["email"])) {
                
                //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errMail = "Vul een valide emailadres in";
                }
            } else {
                $errMail = "Emailadres moet ingevuld zijn";
            }
            
            if (!empty($_POST["phonenumber"])) {
                
                //Als phonenumber niet leeg is wordt gekeken of phonenumber enkel uit nummers bestaat
                if (!is_numeric($phonenumber)) {
                    $errPhonenumber = "Enkel cijfers zijn toegestaan";
                }
            } else {
                $errPhonenumber = "Telefoonnummer moet ingevuld zijn";
            }
            
            //Als contactmode leeg is wordt een foutmelding opgenomen
            if (!empty($_POST["contactmode"])) {
            
                $contactmode = $_POST["contactmode"];
            } else {
                $errContactmode = "U moet een contactwijze kiezen";
            }
        
            //Als er geen errors voorkomen wordt validInput op true gezet zodat de bedankpagina getoond kan worden
            if (($errSalutation == "") && ($errName == "") && ($errMail == "") && ($errPhonenumber == "") && ($errContactmode == "")){
            
                $valid = True;
            } else {
                $valid = False;
            }        
        }
        
        
        return array('salutation' => $salutation, 'errSalutation' => $errSalutation, 'name' => $name, 'errName' => $errName, 'email' => $email, 'errMail' => $errMail, 'phonenumber' => $phonenumber,
        'errPhonenumber' => $errPhonenumber, 'contactmode' => $contactmode, 'errContactmode' => $errContactmode, 'message' => $message, 'valid' => $valid, 'page' => "");    
    }
    
    function validateLogin() {
    
        $email = $password = $name = $errMail = $errPassword = "";
        $valid = False;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
            //Eerst worden ongewenste karakters verwijderd
            $email = testInput($_POST["email"]);
            $password = testInput($_POST["password"]);
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $errMail = checkEmail($email);
            $errPassword = checkPassword($password);
        
            //Indien geen foutmeldingen gegeven zijn bij het checken van het emailadres en password is sprake van valide input
            if ($errMail == "" && $errPassword == "") {
            
                if (authenticateUser($email, $password)) {
                    $name = findUserByEmail($email);
                    $valid = True;
                } else {
                    $errMail = "Opgegeven emailadres is niet gekoppeld aan een gebruiker of incorrect wachtwoord";
                }
            }
        }
    
        return array('email'=> $email, 'errMail' => $errMail, 'name' => $name, 'password' => $password, 'errPassword' => $errPassword, 'valid' => $valid, 'page' => "");
    }
    
    function validateRegister() {
    
        $name = $email = $password = $passwordTwo = $errName = $errMail = $errPassword = "";
        $valid = False;

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
            //Eerst worden ongewenste karakters verwijderd
            $name = testInput($_POST["name"]);
            $email = testInput($_POST["email"]);
            $password = testInput($_POST["password"]);
            $passwordTwo = testInput($_POST["passwordTwo"]);
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $errName = checkName($name);
            $errMail = checkEmail($email);
        
            //Nadat een correct emailadres is opgegeven wordt ook gekeken of er sprake is van een nieuw uniek emailadres
            if ($errMail == "") {
            
                $errMail = checkNewEmail($email);        
        
                //Vervolgens wordt bekeken of er wachtwoorden opgegeven zijn, waarna de wachtwoorden met elkaar vergeleken worden
                $errPassword = checkRegisterPassword($password, $passwordTwo);
        
                //Indien sprake is van correcte input wordt een nieuw account aangemaakt en de gebruiker geredirect naar de loginpagina
                if ($errName == "" && $errMail == "" && $errPassword == "") {
                    $valid = True;        
                }
            }
        }
    
        return array('name' => $name, 'errName' => $errName,'email'=> $email, 'errMail' => $errMail, 'password' => $password,'passwordTwo' => $passwordTwo, 'errPassword' => $errPassword, 'valid' => $valid, 'page' => "");
    }
?>