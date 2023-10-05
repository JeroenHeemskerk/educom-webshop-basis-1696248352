<?php
$page = getRequestedPage();
showResponsePage($page);

function showResponsePage($page){
    showHTMLStart();
    
    
    showFooter();
}

function getRequestedPage() {
    
    $request = $_GET["page"];
    
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

function showHeadSection () {
    echo "<head>";
}

function showBodySection() {
}


function showFooter() {
    echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
}
?>



