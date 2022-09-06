<html lang="en">
<head>
    <title>Galeria</title>
    <meta name="author" content="Lukasz Nowakowski 189396" />
    <meta name="description" content="galeria" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-32"/>
    <link type="text/css" rel="stylesheet" href="../web/static/style.css" />
    <link type="image/x-icon" rel="icon" href="../web/static/img/icon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/v4-shims.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <figure>
            <img src="../web/static/img/logo.png" alt="logo" id="logo" />
            <figcaption></figcaption>
        </figure>
    </header>
    <nav style="clear:both">
        <div class="dropdown" style="width:100%;">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color:white; color:black;">
                Menu
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="../web/static/index.html">Strona glówna</a></li>
                <li><a class="dropdown-item" href="../web/static/ruins.html">Opuszczone budowle</a></li>
                <li><a class="dropdown-item" href="../web/static/viewpoints.html">Punkty widokowe</a></li>
                <li><a class="dropdown-item" href="../web/frontcontroller.php?action=/gallery">Galeria użytkowników</a></li>
                <li><a class="dropdown-item" href="../web/frontcontroller.php?action=/login">Rejestracja</a></li>
            </ul>
            <a href="#logo" style="color:white;"><i class="fas fa-arrow-circle-up fa-3x" style="float:right; line-height:75px; padding-right:2%;"></i></a>
        </div>
        <div class="classic" style="width:100%;">
            <a href="../index.html">Strona glowna</a>
            <a href="../web/static/ruins.html">Opuszczone budowle</a>
            <a href="../web/static/viewpoints.html">Punkty widokowe</a>
            <a href="/web/frontcontroller.php?action=/gallery">Galeria użytkowników</a>
        </div>
        <a href="/web/frontcontroller.php?action=/login" id="register" style="margin-top:1.5%"><i class="fas fa-user fa-lg"></i></a>
    </nav>
    <main>
        <br />
        <h3>Galeria Zdjęć</h3>
        <form action="../web/frontcontroller.php?action=/gallery/remember" method="post" enctype="multipart/form-data">
            <table style="width:100%">
                <?php
                    if(!isset($_SESSION['login'])) $_SESSION['login'] = '';
                    if(!isset($_SESSION['images'])) $_SESSION['images'] = [];
                    echo "<tr>";
                    foreach($images as $i){
                        $photoName = $i['author'].$i['title'].$i['image'];
                        if($i['type'] === 'public' || $i['user'] === $_SESSION['login']){
                            echo "<td style='display:inline-block; margin-left:3%'>";
                            echo "<a href='../images/wtrmrk/".$photoName."'><img src='../images/min/".$photoName."' alt='photo'/><br /></a>";
                            echo "<p>Autor: ".$i['author']."</p>";
                            echo "<p>Tytuł: ".$i['title']."</p>";
                            if(in_array($photoName, $_SESSION['images'])) echo "Zapamiętaj <input type='checkbox' name='checked[]' value='".$photoName."' checked/>";
                            else echo "Zapamiętaj <input type='checkbox' name='checked[]' value='".$photoName."'/>";
                            if($i['type'] === 'private') echo "<br/> Zdjęcie prywatne";
                            echo "</td>";
                        }
                    }
                    echo "</tr>";
                ?>
            </table>
            <input type="hidden" name="action" value="remember"/>
            <input type="submit" value="Zapamiętaj wybrane"/>
        </form>
        <div style="display:flex; margin-left:31%;">
            <?php
                if(!isset($_GET['page'])) $page = 1;
                else $page = $_GET['page'];
            
                if($page > 1) echo '<h3><a href="../web/frontcontroller.php?action=/gallery&page='.($page-1).'" style=" text-decoration:none; color:black">Poprzednia strona</a></h3>';
                echo "<pre>   </pre>";
                if($page < getNumberOfPages()) echo ' <h3><a href="../web/frontcontroller.php?action=/gallery&page='.($page+1).'" style=" text-decoration:none; color:black">Następna strona</a></h3>';
            ?>
        </div>
        <h3><a href="../web/frontcontroller.php?action=/gallery/addImageForm" style="color:black; text-decoration:none">Kliknij by dodać zdjęcie</a></h3>
        <h3><a href="../web/frontcontroller.php?action=/gallery/remember/display" style="color:black; text-decoration:none">Kliknij by wyświetlić zaznaczone</a></h3>
        <h3><a href="../web/frontcontroller.php?action=/gallery/search" style="color:black; text-decoration:none">Kliknij by wyszukać po tytule</a></h3>
        <h3><a href="../web/frontcontroller.php?action=/gallery/removeAll" style="color:black; text-decoration:none">Kliknij by wyczyścić galerię</a></h3>
    </main>
</body>
</html>