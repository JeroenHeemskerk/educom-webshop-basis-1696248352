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
            return getPostVar('home');
    
        //Indien sprake is van een GET-request wordt bepaald welke pagina weergegeven moet worden
        } else if ($_SERVER["REQUEST_METHOD"] == "GET"){        
            return getUrlVar('home');
            
        } else {
			//Als geen page geset is met $_GET wordt home weergegeven
			return "home";
		}
    }
    
    function getPostVar($default=''){
        return isset($_POST['page']) ? $_POST['page'] : $default;
    }
    
    function getUrlVar($default='') {
        return isset($_GET['page']) ? $_GET['page'] : $default;
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
        
        //Aan dat wordt een array menu toegevoegd met de standaard weer te geven items
        //Naar aanleiding van of de user ingelogd is wordt register en login of logout toegevoegd
        $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact');
        if (isUserLoggedIn()) {
            $data['menu']['logout'] = "Logout " . getLoggedInUserName();
        } else {
            $data['menu']['register'] = "Register";
            $data['menu']['login'] = "Login";
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

    function showBodySection($data) {
    
        echo '<body class="pagetext">';    
        showHeader($data);    
        showNavMenu($data);    
        showContent($data);    
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

    function showNavMenu($data) {
        
        //Het navigatiemenu wordt door middel van de eerder gedefinieerde items in processRequest opgemaakt
        echo '<ul class="nav">';        
        foreach($data['menu'] as $link => $label) {
            showMenuItem($link, $label);
        }
        echo '</ul><br>';                
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



