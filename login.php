<?php
    $email = $errMail = $errPassword = "";
    
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
?>