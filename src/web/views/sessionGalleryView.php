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
                <li><a class="dropdown-item" href="../index.html">Strona glówna</a></li>
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
            <a href="../web/frontcontroller.php?action=/gallery">Galeria użytkowników</a>
        </div>
        <a href="../web/frontcontroller.php?action=/login" id="register" style="margin-top:1.5%"><i class="fas fa-user fa-lg"></i></a>
    </nav>
    <main>
        <br />
        <h3>Galeria Zdjęć</h3>
        <form action="../web/frontcontroller.php?action=/gallery/forget" method="post" enctype="multipart/form-data">
            <table style="width:100%">
                <?php
                    echo "<tr>";
                    foreach($sessionImages as $i){
                        $photoName = $i['author'].$i['title'].$i['image'];
                        if(($i['type'] === 'public' || $i['user'] === $_SESSION['login']) && in_array($photoName, $_SESSION['images'])){
                            echo "<td style='display:inline-block; margin-left:3%'>";
                            echo "<a href='../images/wtrmrk/".$i['author'].$i['image']."'><img src='../images/min/".$photoName."' alt='photo' style='width:100%'/><br /></a>";
                            echo "<p>Autor: ".$i['author']."</p>";
                            echo "<p>Tytuł: ".$i['title']."</p>";
                            if($i['type'] === 'private') echo "<p>Zdjęcie prywatne</p>";
                            echo "Usuń z zapamiętanych <input type='checkbox' name='toForget[]' value='".$photoName."'/>";
                            echo "</td>";
                        }
                    }
                    echo "</tr><br/>";
                ?>
            </table>
            <input type="submit" value="Zapomnij wybrane"/>
        </form>
    </main>
</body>
</html>