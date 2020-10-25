<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>Aplikace Ples</title>
    <meta name="author" content="Your Name">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="media/css/styles_index.css">
    <link href="media/fontawesome/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="wrong_login" class="popupform">
        <form class="content contenterror animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Přihlášení se nezdařilo.</h2>
                <span onclick="document.getElementById('wrong_login').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>

    <header>
        <img src="media/img/bg-photo.svg" alt="background">
        <div class="header-content">
            <h1>Aplikace <br />Ples</h1>
            
            <div id="buttons">
                <a href="guest.php" class="btn-show">Vstoupit</a>
                
                <?php
                    session_name ("aplikaceples");
                    session_start();
                    if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == true) {
                ?>
                <script>
                    console.log("Špatné přihlášení");
                    document.getElementById('wrong_login').style.display='flex';
                </script>
                <?php
                    }
                    $_SESSION['login_error'] = false;
                ?>
            </div>
        </div>
        <button id="admin-button" onclick="document.getElementById('popupform').style.display='flex'" style="width:auto;"><i class="fas fa-unlock-alt"></i></button>
        <div id="copyright">&copy; 2020 Martin Opravil</div>
    </header>

    <div id="popupform" class="popupform">
        <form class="content animate" action="components/_access/login.php" method="post">

            <div class="imgcontainer">
                <h1>Přihlášení</h1>
                <span onclick="document.getElementById('popupform').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>

            <div class="container">
                <label><b>Uživatelské jméno</b></label>
                <input type="text" placeholder="Vložte uživatelské jméno" name="nick" required>

                <label><b>Heslo</b></label>
                <input type="password" placeholder="Vložte heslo" name="password" required>

                <button id="submit-button" type="submit" name="prihlaseni"><i class="fas fa-sign-in-alt"></i> Přihlásit</button>
            </div>
        </form>
    </div>

    <script>
        // Vyskakovací okno
        var popupform = document.getElementById('popupform');

        window.onclick = function(event) {
            if (event.target == popupform) {
                popupform.style.display = "none";
            }
        }

    </script>
</body>

</html>
