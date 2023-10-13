<?php    

    function showContactBody() {
    
        //Data (indien ingegeven) wordt gevalideerd. Vervolgens wordt een lege pagina weergegeven of een pagina met foutmelding aan de hand van de validatie
        //Bij correct ingegeven data wordt de bedankpagina getoond
        $data = validateForm();
        if (!$data['validInput']){
            showContactForm($data);
        } else {
            showContactThanks($data);
        }
        echo '<br>';
    }
    
    function validateForm() {
        
        $salutation = $name = $email = $phonenumber = $contactmode = $message = "";
        $errSalutation = $errName = $errMail = $errPhonenumber = $errContactmode = "";
        $validInput = False;        
        
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
            
            $validInput = True;
        } else {
            $validInput = False;
        }        
            
        //Ik weet niet of dit zo werkt, het is de bedoeling dat de pagina opnieuw geladen wordt wanneer er een GET-request wordt gedaan
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header("contact.php");
        }
        
        
        return array('salutation' => $salutation, 'errSalutation' => $errSalutation, 'name' => $name, 'errName' => $errName, 'email' => $email, 'errMail' => $errMail, 'phonenumber' => $phonenumber,
        'errPhonenumber' => $errPhonenumber, 'contactmode' => $contactmode, 'errContactmode' => $errContactmode, 'message' => $message, 'validInput' => $validInput);
    }
    
        
    //Haalt ongewenste karakters en spaties weg
    function testInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    
    function showContactForm($data) {
    
        echo '<br><form method="post" action="index.php">';     
    
        //Aanhefkeuze
        echo '<label for="salutation"> Aanhef:</label><br>';        
            echo '<select name="salutation" id="salutation">';
            if ($data['salutation'] == "mr."){
                echo '<option value="mr." selected>Dhr.</option>';
            } else {
                echo '<option value="mr.">Dhr.</option>';
            }
            if ($data['salutation'] == "mrs."){
                echo '<option value="mrs." selected>Mvr.</option>';
            } else {
                echo '<option value="mrs.">Mvr.</option>';
            }
            if ($data['salutation'] == "neither"){
                echo '<option value="neither" selected>Geen van beide</option>';
            } else {
                echo '<option value="neither">Geen van beide</option>';
            }
        echo '</select><span>'; echo $data['errSalutation']; echo '</span><br>';
        
    
        //Formulier met naam, emailadres en telefoonnummer
        echo '<label for="name">Naam:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $data['name']; echo '"><span>'; echo $data['errName']; echo '</span><br>
            <label for="email">Emailadres:</label>
            <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $data['email']; echo '"><span>'; echo $data['errMail']; echo '</span><br>
            <label for="phonenumber">Telefoonnummer:</label>
            <input type="text" id="phonenumber" name="phonenumber" placeholder="0612345678" value="'; echo $data['phonenumber']; echo '"><span>'; echo $data['errPhonenumber']; echo '</span><br><br>';
    
        //Radio button met contactwijze
        echo '<label for="contactmode1">Contactwijze:</label><span>'; echo ' ' . $data['errContactmode']; echo '</span><br>
            <input type="radio" id="contactmode1" name="contactmode" value="email">
            <label for="contactmode1">Email</label><br>
            <input type="radio" id="contactmode2" name="contactmode" value="phone">
            <label for="contactmode2">Telefoon</label><br><br>';
    
        //Mogelijkheid tot verzenden bericht
        echo '<label for="message">Uw bericht:</label><br>
            <textarea id="message" name="message" rows="3" cols="50"></textarea><br><br>';
    
        //Verborgen variabele om ervoor te zorgen dat de contactpagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="contact">';
    
        //Verzendknop
        echo '<input type="submit" value="Verzenden">
        </form>';   
    
        }
        
    function showContactThanks($data) {            
    
        //Bedanktformulier wordt opgemaakt met de ingevulde gegevens
        echo '<h2>Hartelijk dank voor uw bericht. U zal spoedig een reactie ontvangen.</h2>
                <h3>Ingevulde gegevens:</h3>
                <p>Aanhef: ';
        echo $data['salutation'];
        echo '<br>Naam: ';
        echo $data['name']; 
        echo '<br>Emailadres: ';
        echo $data['email'];
        echo '<br>Telefoonnummer: ';
        echo $data['phonenumber'];
        echo '<br>Contactwijze: '; 
        if ($data['contactmode'] == "email") {
            
            echo "email";
        } else {
            echo "telefonisch";
        }
        echo '<br>Bericht: ';
        echo $data['message'];
        echo '</p>';    
        }
?>