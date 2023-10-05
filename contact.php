<!DOCTYPE html>
<html>
 <head>
    <title>Contact</title>
    <link rel="stylesheet" href="./CSS/stylesheet.css">
 </head>
 <body class="pagetext">
    
    <h1>Contact</h1>
    <br>
    <ul class="nav">
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <br>
    
    <?php
        $salutation = $name = $email = $phonenumber = $contactmode = $message = "";
        $errSalutation = $errName = $errMail = $errPhonenumber = $errContactmode = "";
        $displayForm = True;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            $displayForm = False;
            
            if (!empty($_POST["salutation"])) {
                $salutation = $_POST["salutation"];
                
                //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
                if (!($salutation == "mr." || $salutation == "mrs." || $salutation == "neither")) {
                    $errSalutation = "Enkel 'Dhr.', 'Mvr.' of 'Geen van beide' zijn valide input";
                    $displayForm = True;
                }
            } else {
                $errSalutation = "Aanhef moet ingevuld zijn";
                $displayForm = True;
            }
            
            if (!empty($_POST["name"])) {
                $name = $_POST["name"];
                
                //Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $errName = "Enkel letters en whitespaces zijn toegestaan";
                    $displayForm = True;
                }
            } else {
                $errName = "Naam moet ingevuld zijn";
                $displayForm = True;
            }
            
            if (!empty($_POST["email"])) {
                $email = $_POST["email"];
                
                //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errMail = "Vul een valide emailadres in";
                    $displayForm = True;
                }
            } else {
                $errMail = "Emailadres moet ingevuld zijn";
                $displayForm = True;
            }
            
            if (!empty($_POST["phonenumber"])) {
                $phonenumber = $_POST["phonenumber"];
                
                //Als phonenumber niet leeg is wordt gekeken of phonenumber enkel uit nummers bestaat
                if (!preg_match("/^[0-9]{10}+$/", $phonenumber)) {
                    $errPhonenumber = "Enkel cijfers zijn toegestaan";
                    $displayForm = True;
                }
            } else {
                $errPhonenumber = "Telefoonnummer moet ingevuld zijn";
                $displayForm = True;
            }
            
            if (!empty($_POST["contactmode"])) {
                $contactmode = $_POST["contactmode"];
            } else {
                $errContactmode = "U moet een contactwijze kiezen";
                $displayForm = True;
            }
            
            if (!empty($_POST["message"])) {
                $message = $_POST["message"];
            }
            
            //Ik weet niet of dit zo werkt, het is de bedoeling dat de pagina opnieuw geladen wordt wanneer er een GET-request wordt gedaan
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header("contact.php");
        }
        
        if ($displayForm) {
    ?>
    
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    
    <!--Aanhefkeuze-->
    <label for="salutation">Aanhef:</label><br>
        <select name="salutation" id="salutation">
            <option value="mr.">Dhr.</option>
            <option value="mrs.">Mvr.</option>
            <option value="neither">Geen van beide</option>
        </select><span><?php echo $errSalutation;?></span><br>
        
    
    <!--Formulier met naam, emailadres en telefoonnummer--> 
    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" placeholder="John Doe" value="<?php echo $name?>"><span><?php echo $errName;?></span><br>
    <label for="email">Emailadres:</label>
    <input type="text" id="email" name="email" placeholder="j.doe@example.com" value="<?php echo $email?>"><span><?php echo $errMail;?></span><br>
    <label for="phonenumber">Telefoonnummer:</label>
    <input type="text" id="phonenumber" name="phonenumber" placeholder="06-12345678" value="<?php echo $phonenumber?>"><span><?php echo $errPhonenumber;?></span><br><br>
    
    <!--Radio button met contactwijze-->
    <label for="contactmode1">Contactwijze:</label><br><span><?php echo $errContactmode;?></span><br>
    <input type="radio" id="contactmode1" name="contactmode" value="email">
    <label for="contactmode1">Email</label><br>
    <input type="radio" id="contactmode2" name="contactmode" value="phone">
    <label for="contactmode2">Telefoon</label><br><br>
    
    <!--Mogelijkheid tot verzenden bericht-->
    <label for="message">Uw bericht:</label><br>
    <textarea id="message" name="message" rows="3" cols="50"></textarea><br><br>
    
    <!--Verzendknop-->
    <input type="submit" value="Verzenden">
    </form>
    
    <?php
        } else {            
    ?>
    
    <h2>Hartelijk dank voor uw bericht. U zal spoedig een reactie ontvangen</h2>
    <h3>Ingevulde gegevens:</h3>
    <p>Aanhef: <?php echo $salutation?><br>
    Naam: <?php echo $name?><br>
    Emailadres: <?php echo $email?><br>
    Telefoonnummer: <?php echo $phonenumber?><br>
    Contactwijze: <?php if ($contactmode == "email") {
                            echo "email";
                        } else {
                            echo "telefonisch";
                        }?><br>
    Bericht: <?php echo $message?></p>
    
    <?php
        }
    ?>
    
    <br>
 
 </body>
 <footer>
    <p>&copy 2023<br>Nick Koole</p>
 </footer>
</html>