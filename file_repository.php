<?php
    
    function findUserByEmail($email) {
    
        $users = fopen("users.txt", "r") or die("Unable to open file!");
        try {
            while(!feof($users)) {            
                $account = explode("|", fgets($users));
                if ($account[0] == $email) {
                    $password = trim($account[2]);
                    return array ('email' => $account[0], 'name' => $account[1], 'password' => $password);
                }
            }
        }
        finally {
            fclose($users);
        }
    }
    
    function registerNewAccount($data) {
        
        //Zet de nieuw opgegeven user op de volgende line
        $users = fopen("users.txt", "a") or die("Unable to open file!");
        $txt = PHP_EOL . $data['email'] . '|' . $data['name'] . '|' . $data['password'];
        fwrite($users, $txt);
        fclose($users);
    }
?>