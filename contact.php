<?php
    $salutation = $name = $email = $phonenumber = $contactmode = $message = "";
    $errSalutation = $errName = $errMail = $errPhonenumber = $errContactmode = "";
    $displayForm = True;
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $validInput = True;
            
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
                $validInput = False;
            }
        } else {
            $errSalutation = "Aanhef moet ingevuld zijn";
            $validInput = False;
        }
            
        if (!empty($_POST["name"])) {
                
            //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $errName = "Enkel letters en whitespaces zijn toegestaan";
                $validInput = False;
            }
        } else {
            $errName = "Naam moet ingevuld zijn";
            $validInput = False;
        }
            
        if (!empty($_POST["email"])) {
                
            //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errMail = "Vul een valide emailadres in";
                $validInput = False;
            }
        } else {
            $errMail = "Emailadres moet ingevuld zijn";
            $validInput = False;
        }
            
        if (!empty($_POST["phonenumber"])) {
                
            //Als phonenumber niet leeg is wordt gekeken of phonenumber enkel uit nummers bestaat
            if (!is_numeric($phonenumber)) {
                $errPhonenumber = "Enkel cijfers zijn toegestaan";
                $validInput = False;
            }
        } else {
            $errPhonenumber = "Telefoonnummer moet ingevuld zijn";
            $validInput = False;
        }
            
        if (!empty($_POST["contactmode"])) {
            $contactmode = $_POST["contactmode"];
        } else {
            $errContactmode = "U moet een contactwijze kiezen";
            $validInput = False;
        }
            
        //Indien validInput true is, is het formulier correct ingevuld en aangeleverd. Hierdoor wordt de bedanktpagina zichtbaar.
        if ($validInput) {
            $displayForm = False;
        }
            
        //Ik weet niet of dit zo werkt, het is de bedoeling dat de pagina opnieuw geladen wordt wanneer er een GET-request wordt gedaan
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header("contact.php");
        }
        
        //haalt ongewenste karakters en spaties weg
        function testInput($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        
        if ($displayForm) {
      
    
    
    //Post-request wordt middels htmlspecialcharacters aangepast naar enkel HTML entities indien speciale karakters worden gevonden
    echo '<p>'; echo $_SERVER['PHP_SELF']; echo '</p>';
    echo '<form method="post" action="'; echo htmlspecialchars($_SERVER["PHP_SELF"]); echo '">';
    
    //Aanhefkeuze
    echo '<label for="salutation"> Aanhef:</label><br>
        <select name="salutation" id="salutation">
            <option value="mr.">Dhr.</option>
            <option value="mrs.">Mvr.</option>
            <option value="neither">Geen van beide</option>
        </select><span><?php echo $errSalutation;?></span><br>';
        
    
    //Formulier met naam, emailadres en telefoonnummer
    echo '<label for="name">Naam:</label>
        <input type="text" id="name" name="name" placeholder="John Doe" value="'; echo $name; echo '"><span>'; echo $errName; echo '</span><br>
        <label for="email">Emailadres:</label>
        <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="'; echo $email; echo '"><span>'; echo $errMail; echo '</span><br>
        <label for="phonenumber">Telefoonnummer:</label>
        <input type="text" id="phonenumber" name="phonenumber" placeholder="0612345678" value="'; echo $phonenumber; echo '"><span>'; echo $errPhonenumber; echo '</span><br><br>';
    
    //Radio button met contactwijze
    echo '<label for="contactmode1">Contactwijze:</label><br><span>'; echo $errContactmode; echo '</span><br>
        <input type="radio" id="contactmode1" name="contactmode" value="email">
        <label for="contactmode1">Email</label><br>
        <input type="radio" id="contactmode2" name="contactmode" value="phone">
        <label for="contactmode2">Telefoon</label><br><br>';
    
    //Mogelijkheid tot verzenden bericht
    echo '<label for="message">Uw bericht:</label><br>
        <textarea id="message" name="message" rows="3" cols="50"></textarea><br><br>';
    
    //Verzendknop
    echo '<input type="submit" value="Verzenden">
        </form>';
    
    
        } else {            
    
    echo '<h2>Hartelijk dank voor uw bericht. U zal spoedig een reactie ontvangen.</h2>
    <h3>Ingevulde gegevens:</h3>
    <p>Aanhef: ';
    echo $salutation;
    echo '<br>Naam: ';
    echo $name; 
    echo '<br>Emailadres: ';
    echo $email;
    echo '<br>Telefoonnummer: ';
    echo $phonenumber;
    echo '<br>Contactwijze: '; 
    if ($contactmode == "email") {
        echo "email";
    } else {
        echo "telefonisch";
    }
    echo '<br>Bericht: ';
    echo $message;
    echo '</p>';
    
    
        }
    echo '<br>'
?>