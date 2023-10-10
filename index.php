<?php

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
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $request = "contact.php";        
    } else {
        $request = $_GET["page"];
    }
    
    
    switch ($request) {
        case "home":
            return "home.php";
        case "about":
            return "about.php";
        case "contact":
            return "contact.php";
        default:
            return "home.php";
    }
}

function showHTMLStart() {
    
    echo "<html>";
}

function showHTMLEnd() {
    
    echo "</html>";
}

function showHeadSection ($page) {
    
    switch ($page) {
        case "home.php":
            echo    '<head>
                        <title>Nick zijn website</title>
                        <link rel="stylesheet" href="./CSS/stylesheet.css">
                    </head>';
            break;
        case "about.php":
            echo    '<head>
                        <title>About</title>
                        <link rel="stylesheet" href="./CSS/stylesheet.css">
                    </head>';
            break;
        case "contact.php":
            echo    '<head>
                        <title>Contact</title>
                        <link rel="stylesheet" href="./CSS/stylesheet.css">
                    </head>';
            break;
    }
    
}

function showBodySection($page) {
    
    echo '<body class="pagetext">';
    
    switch ($page) {
        case "home.php":
            echo '<h1>Home</h1><br>';
            break;
        case "about.php":
            echo '<h1>About</h1><br>';
            break;
        case "contact.php":
            echo '<h1>Contact</h1><br>';
            break;
    }
    
    showNavMenu();
    
    switch ($page) {
        case "home.php":
            include 'home.php';
            break;
        case "about.php":
            include 'about.php';
            break;
        case "contact.php":
            include 'contact.php';
            break;
    }

}

function showNavMenu() {
    
    echo '<ul class="nav">
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=about">About</a></li>
            <li><a href="index.php?page=contact">Contact</a></li>
         </ul>
         <br>';
}


function showFooter() {
    
    echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
}
?>



