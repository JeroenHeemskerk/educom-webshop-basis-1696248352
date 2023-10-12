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
            case "login";
                return "login";
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
    
    showNavMenu();
    
    switch ($page) {
        case "home":
            include 'home.php';
            break;
        case "about":
            include 'about.php';
            break;
        case "contact":
            include 'contact.php';
            break;
        case "register":
            include 'register.php';
            break;
        case "login":
            include 'login.php';
            break;
    }

}

function showNavMenu() {
    
    echo '<ul class="nav">
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=about">About</a></li>
            <li><a href="index.php?page=contact">Contact</a></li>
            <li><a href="index.php?page=register">Register</a></li>
            <li><a href="index.php?page=login">Login</a></li>
         </ul>
         <br>';
}


function showFooter() {
    
    echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
}
?>



