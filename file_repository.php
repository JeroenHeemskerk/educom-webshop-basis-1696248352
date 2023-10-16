<?php
    
    function registerNewAccount($data) {
        
        //Zet de nieuw opgegeven user op de volgende line
        $users = fopen("users.txt", "a") or die("Unable to open file!");
        $txt = PHP_EOL . $data['email'] . '|' . $data['name'] . '|' . $data['password'];
        fwrite($users, $txt);
        fclose($users);
    }
    
    function checkNewEmail($email) {
        
        $users = fopen("users.txt", "r") or die("Unable to open file!");
        try {
            //Bekijkt of het nieuw ingegeven emailadres identiek is
            while(!feof($users)) {
                $account = explode("|", fgets($users));
                if ($account[0] == $email) {
                    return "Dit emailadres is al in gebruik";
                }
            }
        
            return "";
        }
        finally {
            fclose($users);
        }        
    }

    function findUserByEmail($email) {
    
        $users = fopen("users.txt", "r") or die("Unable to open file!");
        try {
            while(!feof($users)) {            
                $account = explode("|", fgets($users));
                if ($account[0] == $email) {
                
                    return $account[1];
                }
            }
        }
        finally {
            fclose($users);
        }
    }
?>