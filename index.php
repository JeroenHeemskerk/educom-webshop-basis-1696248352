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



