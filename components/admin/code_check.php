<?php 
    include ("../_access/mysqli_connect.php");
    if(isset($_POST['code_submit'])) {
        if(isset($_POST['code'])) {
            $code = $_POST['code'];

            // Najdi jestli existují místa se zadaným kódem
            $sql_select = "SELECT * FROM sedadla WHERE code='$code'";
            if($vysledek=mysqli_query($link, $sql_select)) {
                session_name ("aplikaceples");
                session_start();
                if (mysqli_num_rows($vysledek) > 0) {
                    $num = mysqli_num_rows($vysledek);
                    // Následně je aktualizuj
                    $sql_update = "UPDATE sedadla SET state='bought' WHERE code='$code'";
                    if($vysledek=mysqli_query($link, $sql_update)) {
                        echo "Sedadla zakoupeny.";
                    } else {
                        echo mysqli_error($link);
                    }
                    $_SESSION['code_error'] = false;
                    $_SESSION['code_seat_quantity'] = $num;
                } else {
                    $_SESSION['code_error'] = true;
                    echo "Zadaný kód se nezhoduje s žádným místem";
                }
            } else {
                echo mysqli_error($link);
            }
            header("location:../../admin.php");
        }
    }
?>