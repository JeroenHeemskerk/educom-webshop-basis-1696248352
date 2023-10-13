<?php    

    /*function showContactBody() {
    
        //Data (indien ingegeven) wordt gevalideerd. Vervolgens wordt een lege pagina weergegeven of een pagina met foutmelding aan de hand van de validatie
        //Bij correct ingegeven data wordt de bedankpagina getoond
        $data = validateForm();
        if (!$data['validInput']){
            showContactForm($data);
        } else {
            showContactThanks($data);
        }
        echo '<br>';
    }*/

    
    function showContactBody($data) {
    
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
        
?>