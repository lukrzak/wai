<?php
    if(!isset($_SESSION['images'])) $_SESSION['images'] = [];
    function getAllImages(){
        $db = getDb();
        $images = $db->images->find();
        return $images;
    }
    
    function uploadFile($file){
        $author = $_POST['author'];
        $title = $_POST['title'];
        $uploadDirectory = '/var/www/prod/src/web/images/img/';
        $tmp = $file['tmp_name'];
        $fileName = basename($file['name']);
        $path = $uploadDirectory.$author.$title.$fileName;
        if(move_uploaded_file($tmp, $path)){
            createFileWithWatermark($file, $path);
            createResizedFile($file, $path);
            setTitleAndAuthor();
        }
    }

    function createFileWithWatermark($file, $path){
        if($file['type'] === 'image/png') $image = imagecreatefrompng($path);
        else $image = imagecreatefromjpeg($path);
        
        imagealphablending($image, false);
        imagestring($image, 5, imagesx($image)-255, imagesy($image)-30, $_POST['watermark'], 255);
        imagesavealpha($image, true);
        imagepng($image, "/var/www/prod/src/web/images/wtrmrk/".$_POST['author'].$_POST['title'].basename($file['name']));
        imagedestroy($image);
    }

    function createResizedFile($file, $path){
        if($file['type'] === 'image/png') $image = imagecreatefrompng($path);
        else $image = imagecreatefromjpeg($path);

        list($width, $height) = getimagesize($path);
        $newImg = imagecreatetruecolor(200,125);
        imagealphablending($newImg, false);
        imagecopyresized($newImg, $image, 0, 0, 0, 0, 200, 125, $width, $height);
        imagesavealpha($newImg, true);
        imagepng($newImg, "/var/www/prod/src/web/images/min/".$_POST['author'].$_POST['title'].basename($file['name']));
        imagedestroy($newImg);
    }

    function isFileValid($file){
        global $model;
        if($file['size'] <= 0){
            return false;
        } 
        else if(!($file['type'] === 'image/png' || $file['type'] === 'image/jpeg') && $file['size']/(1024*1024) > 1){
            return false;
        }
        else if($file['size']/(1024*1024) > 1){
            return false;
        } 
        else if(!($file['type'] === 'image/png' || $file['type'] === 'image/jpeg')){
            return false;
        }
        return true;
    }

    function getStatusMessage($file){
        if($file['size'] <= 0) return 'noFileChoosen';
        else if(!($file['type'] === 'image/png' || $file['type'] === 'image/jpeg') && $file['size']/(1024*1024) > 1) return 'wrongExtensionAndFileTooLarge';
        else if($file['size']/(1024*1024) > 1) return 'fileTooLarge';
        else if(!($file['type'] === 'image/png' || $file['type'] === 'image/jpeg')) return 'wrongExtension';
    }
    
    function setTitleAndAuthor(){
        $db = getDb();
        if($_SESSION['login'] !== ''){
            $type = $_POST['visibility'];
            $user = $_SESSION['login'];
        }
        else{
            $type = 'public';
            $user = '';
        }
        $imageDescription = [
            'author' => $_POST['author'],
            'title' => $_POST['title'],
            'image' => basename($_FILES['fileToUpload']['name']),
            'type' => $type,
            'user' => $user
        ];
        $db->images->insertOne($imageDescription);
    }

    function getImagesForCurrentPage(){
        $db = getDb();
        $elementsPerPage = 5;
        if(!isset($_GET['page'])){
            $page = 1;
        }
        else{
            $page = $_GET['page'];
        }
        $opts = [
            'skip' => ($page-1) * $elementsPerPage,
            'limit' => $elementsPerPage
        ];
        $images = $db->images->find([], $opts);
        return $images;
    }

    function getNumberOfPages(){
        $images = getAllImages();
        $elements = 0;
        foreach($images as $i){
            $elements++;
        }
        return $elements/5;
    }

    function deleteImages(){
        $db = getDb();
        $img = $db->images->find();
        foreach($img as $i){
            $db->images->deleteOne(['author' => $i['author']]);
        }
        $dir = '/var/www/prod/src/web/images';
        $images = array_diff(scandir($dir."/img"), array('.', '..'));
        foreach($images as $i){
            unlink($dir."/img/".$i);
            unlink($dir."/wtrmrk/".$i);
            unlink($dir."/min/".$i);
        }
        header('Location: ../index.html');
    }

    function remember(){
        if(isset($_POST['checked'])){
            $images = $_POST['checked'];
            foreach($images as $i){
                array_push($_SESSION['images'], $i);
            }
        }
    }

    function getImagesInSession(){
        $db = getDb();
        $images = $db->images->find();
        $img = [];
        foreach($images as $i){
            $photoName = $i['author'].$i['title'].$i['image'];
            if(($i['type'] === 'public' || $i['user'] === $_SESSION['login']) && in_array($photoName, $_SESSION['images'])){
                array_push($img, $i);
            }
        }
        return $img;
    }

    function removeFromSession(){
        if(isset($_POST['toForget'])){
            $images = $_POST['toForget'];
            foreach($images as $i){
                $name = array_search($i, $_SESSION['images']);
                unset($_SESSION['images'][$name]);
                $_SESSION['images'] = array_values($_SESSION['images']);
            }
        }
    }
?>