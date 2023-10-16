<?php

    function getLoggedInUserName() {
        return $_SESSION["user"];
    }
    
    function isUserLoggedIn() {
        return isset($_SESSION["user"]);
    }
    
    function loginUser($name) {        
        $_SESSION["user"] = $name;
    }
    
    function logoutUser() {        
        unset($_SESSION["user"]);
    }
    
?>