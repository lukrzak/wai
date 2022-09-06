<?php
    function registerUser(){
        $db = getDb();
        $login = $_POST['registerLogin'];
        $email = $_POST['registerMail'];
        $pass = $_POST['registerPassword'];
        $q = [
            'login' => $login,
            'password' => password_hash($pass, PASSWORD_DEFAULT),
            'email' => $email
        ];
        $db->user->insertOne($q);
    }
    function isRegisterValid(){
        $db = getDb();
        $login = $_POST['registerLogin'];
        $email = $_POST['registerMail'];
        $pass = $_POST['registerPassword'];
        $passRepeat = $_POST['registerPasswordRepeat'];
        $usr = $db->user->findOne(['login' => $login]);
        
        if(empty($login) || empty($email) || empty($pass) || empty($passRepeat)) return false;
        else if($usr !== NULL) return false;
        else if($pass !== $passRepeat) return false;
        return true;
    }
    
    function getRegisterMessage(){
        $db = getDb();
        $login = $_POST['registerLogin'];
        $email = $_POST['registerMail'];
        $pass = $_POST['registerPassword'];
        $passRepeat = $_POST['registerPasswordRepeat'];
        $usr = $db->user->findOne(['login' => $login]);
        
        if(empty($login) || empty($email) || empty($pass) || empty($passRepeat)) return 'notAllFieldsFilled';
        else if($usr !== NULL) return 'takenLogin';
        else if($pass !== $passRepeat) return 'differentPasswords';
    }

    function loginUser(){
        $db = getDb();
        $login = $_POST['login'];
        $usr = $db->user->findOne(['login' => $login]);
        $_SESSION['login'] = $usr['login'];
        $_SESSION['userId'] = $usr['_id'];
    }

    function isLoginValid(){
        $db = getDb();
        $login = $_POST['login'];
        $password = $_POST['password'];
        $usr = $db->user->findOne(['login' => $login]);
        
        if($usr === NULL) return false;
        else if($usr !== NULL && !password_verify($password, $usr['password'])) return false;
        return true;
    }

    function getLoginMessage(){
        $db = getDb();
        $login = $_POST['login'];
        $password = $_POST['password'];
        $usr = $db->user->findOne(['login' => $login]);
        
        if($usr === NULL) return 'noSuchLogin';
        else if($usr !== NULL && !password_verify($password, $usr['password'])) return 'wrongPassword';
    }
?>