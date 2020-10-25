<?php 
    include "mysqli_connect.php";
    $date_now = Date('Y-m-d');
    $date_old = Date("Y-m-d", strtotime("-1 week"));
    // Najdi všechny se starým datem
    $sql_select = "SELECT * FROM sedadla WHERE order_date < '$date_old' AND state!='bought'";
    if($vysledek=mysqli_query($link, $sql_select)) {
        while ($radek = mysqli_fetch_assoc($vysledek)) {
            $id = $radek["id"];
            echo $id . "<br>";
            // Uvolni místo
            $sql_update = "UPDATE sedadla SET state='free', name='', email='', order_date=NULL, code='' WHERE id='$id'";
            if($vysledek_update=mysqli_query($link, $sql_update)) {
                echo "Sedadlo uvolněno";
            } else {
                echo mysqli_error($link); 
            }
        }
    } else {
        echo mysqli_error($link); 
    }
?>