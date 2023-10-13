<?php

    function loginUser($name) {
        
        $_SESSION["user"] = $name;
    }
    
    function logoutUser() {
        
        unset($_SESSION["user"]);
    }
    
?>