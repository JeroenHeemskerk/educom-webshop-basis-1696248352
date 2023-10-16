<?php

    function showThanksHeader() {
        echo '<h1>Thanks</h1><br>';
    }
    
    function showThanksBody($data) {            
    
        //Bedankformulier wordt opgemaakt met de ingevulde gegevens
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