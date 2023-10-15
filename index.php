<?php
    include 'user_service.php';
    include 'file_repository.php';
    include 'validations.php';
    include 'session_manager.php';

    session_start();

    $page = getRequestedPage();
    $data = processRequest($page);
    showResponsePage($data);

    function getRequestedPage() {
    
        //Indien sprake is van een POST-request wordt onderzocht welk formulier is opgegeven
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            switch ($_REQUEST['page']) {
                case "contact":
                    return "contact";
                case "register":
                    return "register";
                case "login":
                    return "login";
            }
    
        //Indien sprake is van een GET-request wordt bepaald welke pagina weergegeven moet worden
        } else if ($_SERVER["REQUEST_METHOD"] == "GET"){
        
			if (isset($_GET['page'])) {
				
				switch ($_GET['page']) {
					case "home":
						return "home";
					case "about":
						return "about";
					case "contact":
						return "contact";
					case "register":
						return "register";
					case "login":
						return "login";
					case "logout":
						return "logout";
				}
			} else {
				//Als geen page geset is met $_GET wordt home weergegeven
				return "home";
			}
        }
    }

    function processRequest($page) {
    
        switch ($page) {        
            case "login":            
                $data = validateLogin();
                if ($data['valid']) {                
                    loginUser($data['name']);
                    $page = "home";
                }
                break;        
            case "logout":        
                logoutUser();
                $page = "home";
                break;        
            case "contact":            
                $data = validateContact();
                if ($data['valid']) {                
                    $page = "thanks";
                }
                break;
            case "register":
                $data = validateRegister();
                if ($data['valid']) {
                    registerNewAccount($data);
                    $page = "login";
                }
        }
    
        $data['page'] = $page;
    
        return $data;
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
                    $errMail = "Geen gebruiker bij emailadres kunnen vinden of incorrect wachtwoord";
                }
            }
        }
    
        return array('email'=> $email, 'errMail' => $errMail, 'name' => $name, 'password' => $password, 'errPassword' => $errPassword, 'valid' => $valid, 'page' => "");
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
        
        //EVEN IN COMMENTS GELATEN VOOR DE ZEKERHEID
        //Ik weet niet of dit zo werkt, het is de bedoeling dat de pagina opnieuw geladen wordt wanneer er een GET-request wordt gedaan
        //} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //    header("contact.php");
        }
        
        
        return array('salutation' => $salutation, 'errSalutation' => $errSalutation, 'name' => $name, 'errName' => $errName, 'email' => $email, 'errMail' => $errMail, 'phonenumber' => $phonenumber,
        'errPhonenumber' => $errPhonenumber, 'contactmode' => $contactmode, 'errContactmode' => $errContactmode, 'message' => $message, 'valid' => $valid, 'page' => "");    
    }

    function showResponsePage($data){
    
        showHTMLStart();
        showHeadSection($data);
        showBodySection($data);    
        showFooter();
        showHTMLEnd();
    }

    function showHeadSection ($data) {
    
        echo '<head>';
    
        switch ($data['page']) {
            case "home":
                echo '<title>Nick zijn website</title>';
                break;
            case "about":
                echo '<title>About</title>';
                break;
                case "contact":
                echo '<title>Contact</title>';
                break;
            case "register":
                echo '<title>Register</title>';
                break;
            case "login":
                echo '<title>Login</title>';
                break;
            case "thanks":
                echo '<title>Dankuwel</title>';
                break;
            default:
                echo '<title>Nick zijn website</title>';
                break;
        }
    
        echo '<link rel="stylesheet" href="./CSS/stylesheet.css">';
        echo '</head>';
    }

    function showBodySection($page) {
    
        echo '<body class="pagetext">';    
        showHeader($page);    
        showNavMenu();    
        showContent($page);    
        echo '</body>';
    }

    function showContent($data) {
    
        switch ($data['page']) {
            case "home":
                include 'home.php';
                showHomeBody();
                break;
            case "about":
                include 'about.php';
                showAboutBody();
                break;
            case "contact":
                include 'contact.php';
                showContactBody($data);
                break;
            case "register":
                include 'register.php';
                showRegisterBody($data);
                break;
            case "login":
                include 'login.php';
                showLoginBody($data);
                break;
            case "thanks":
                include 'thanks.php';
                showThanksBody($data);
                break;
            default:
                include 'home.php';
                showHomeBody();
                break;
        }
    }

    function showNavMenu() {
    
        echo '<ul class="nav">';
                showMenuItem("home", "Home");
                showMenuItem("about", "About");
                showMenuItem("contact", "Contact");
            
                If (isset($_SESSION["user"])) {

                    echo '<li><a href="index.php?page=logout">Logout '; echo $_SESSION["user"] ; echo '</a></li>';
                    } else {
                        showMenuItem("register", "Register");
                        showMenuItem("login", "Login");
                    }          
        echo '</ul>
                <br>';
    }

    function showMenuItem($page, $title) {
        echo '<li><a href="index.php?page=' . $page . '">' . $title . '</a></li>';
    }

    function showHeader($data) {
    
        switch ($data['page']) {
            case "home":
                echo '<h1>Home</h1><br>';
                break;
            case "about":
                echo '<h1>About</h1><br>';
                break;
            case "contact":
                echo '<h1>Contact</h1><br>';
                break;
            case "register":
                echo '<h1>Register</h1><br>';
                break;
            case "login":
                echo '<h1>Login</h1><br>';
                break;
            case "thanks":
                echo '<h1>Dankuwel</h1><br>';
                break;
            default:
                echo '<h1>Home</h1><br>';
                break;
        }
    }

    function showFooter() {
    
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
    }

    function showHTMLStart() {
    
        echo "<html>";
    }

    function showHTMLEnd() {
    
        echo "</html>";
    }
?>



