<?php
    require_once 'usersFunctions.php';
    require_once 'databaseFunctions.php';
    require_once 'imagesFunctions.php';
    require 'messages.php';

    function gallery(&$model){
        $img = getImagesForCurrentPage();
        $model['images'] = $img;
        return 'galleryView';
    }
    
    function displayUploadForm(){
        return 'addPhotoView';
    }
    
    function upload(&$model){
        $file = $_FILES['fileToUpload'];
        $model['status'] = getStatusMessage($file);
        if(isFileValid($file)){
            $model['status'] = 'uploadSuccess';
            uploadFile($file);
        }
        return 'status';
    }

    function displayLoginForm(){
        if(isset($_SESSION['userId'])) return 'logoutView';
        else return 'loginView';
    }
    
    function register(&$model){
        $model['status'] = getRegisterMessage();
        if(isRegisterValid()){
            $model['status'] = 'registerSuccess';
            registerUser();
        }
        return 'status';
    }

    function login(&$model){
        $model['status'] = getLoginMessage();
        if(isLoginValid()){
            $model['status'] = 'loginSuccess';
            loginUser();
        }
        return 'status';
    }

    function logout(){
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        return 'loginView';
    }

    function rememberImages(&$model){
        remember();
        $model['status'] = 'rememberSuccess';
        return 'status';
    }

    function displayImagesInSession(&$model){
        $model['sessionImages'] = getImagesInSession();
        return 'sessionGalleryView';
    }

    function removeImagesFromSession(&$model){
        removeFromSession();
        $model['status'] = 'forgetSuccess';
        return 'status';
    }

    function displaySearch(){
        return 'searchView';
    }
    
    function searchResult(){
        return 'searchResult';
    }
?>