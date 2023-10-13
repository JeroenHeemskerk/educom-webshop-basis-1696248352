<?php

session_start();
$page = getRequestedPage();
showResponsePage($page);

function showResponsePage($page){
    
    showHTMLStart();
    showHeadSection($page);
    showBodySection($page);    
    showFooter();
    showHTMLEnd();
}

function getRequestedPage() {
    
    //Indien sprake is van een POST-request wordt onderzocht welk formulier is opgegeven
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        switch ($_REQUEST["page"]) {
            case "contact":
                return "contact";
            case "register":
                return "register";
            case "login":
                return "login";
        }
    
    //Indien sprake is van een GET-request wordt bepaald welke pagina weergegeven moet worden
    } else if ($_SERVER["REQUEST_METHOD"] == "GET"){
        
        switch ($_GET["page"]) {
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
            default:
                return "home";
        }
    }
}

function showHTMLStart() {
    
    echo "<html>";
}

function showHTMLEnd() {
    
    echo "</html>";
}

function showHeadSection ($page) {
    
    echo '<head>';
    
    switch ($page) {
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

function showContent($page) {
    
    switch ($page) {
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
            showContactBody();
            break;
        case "register":
            include 'register.php';
            showRegisterBody();
            break;
        case "login":
            include 'login.php';
            showLoginBody();
            break;
        case "logout":
            include 'logout.php';
            logOut();
            break;
    }
}

function showHeader($page) {
    
    switch ($page) {
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
    }
}

function showMenuItem($page, $title) {
    echo '<li><a href="index.php?page=' . $page . '">' . $title . '</a></li>';
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


function showFooter() {
    
    echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
}
?>



