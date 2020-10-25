<?php
    include("mysqli_connect.php");

    if(isset($_POST['prihlaseni'])) {
        $nick = mysqli_real_escape_string($link, $_POST["nick"]);
        $pass = $_POST["password"];
        $sql="SELECT id, nick FROM uzivatel WHERE password='$pass' AND nick='$nick'";
        
        if ($vysledek=mysqli_query($link,$sql)) {
            session_name ("aplikaceples");
            session_start();
            if (mysqli_num_rows($vysledek)>0) {
                while ($row = mysqli_fetch_assoc($vysledek)) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['nick'] = $row['nick'];
                }

                echo "JDI na admina";
                $_SESSION['login_error'] = false;
                header("location:../../admin.php");
            } else {
                echo "JDI na index";
                $_SESSION['login_error'] = true;
                header("location:../../index.php") ;
            }
        } else {
            echo mysql_error(); 
        } 
    } else {
        echo mysqli_error($link);
    }
?>
