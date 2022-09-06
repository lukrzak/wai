<?php
    function searchImages(){
        $db = getDb();
        $q = [
            'title' => ['$regex' => $_GET['search']]
        ];
        $images = $db->images->find($q);
        return $images;
    }

    if(isset($_GET['search'])){
        echo "<table><tr>";
        $images = searchImages();
        foreach($images as $i){
            $photoName = $i['author'].$i['title'].$i['image'];
            if($i['type'] === 'public' || $i['user'] === $_SESSION['login']){
                echo "<td style='display:inline-block; margin-left:3%'>";
                echo "<a href='../images/wtrmrk/".$photoName."'><img src='../images/min/".$photoName."' alt='photo' style='width:100%'/><br /></a>";
                echo "<p>Autor: ".$i['author']."</p>";
                echo "<p>Tytuł: ".$i['title']."</p>";
                if($i['type'] === 'private') echo "<br/> Zdjęcie prywatne";
                echo "</td>";
            }
        }
        echo "</tr></table>";
    }
?>