<?php 
include ("../_access/mysqli_connect.php");

if(isset($_POST['add-table'])) {
    if(isset($_POST['count']) && isset($_POST['canvas']) && isset($_POST['direction']) && isset($_POST['number'])) {
        $count = $_POST['count'];
        $canvas = $_POST['canvas'];
        $direction = $_POST['direction'];
        $number = $_POST['number'];
        $x = 0;
        $y = 0;
        echo $count;
        echo $canvas;
        echo $direction;
        echo $number;

        $sql="INSERT INTO stoly (x,y,direction,canvas, number) VALUES ('$x','$y','$direction','$canvas','$number')";
        //echo "Nejsem to já";
        if($vysledek=mysqli_query($link, $sql)){
            session_name ("aplikaceples");
            session_start();
            $table_id = mysqli_insert_id($link);
            echo "Stůl přidán";
            for ($i = 0; $i < $count; $i++) {
                $sql2="INSERT INTO sedadla (state,name,email,table_id,code) VALUES ('free','','','$table_id','')";
                if($vysledek=mysqli_query($link, $sql2)){
                    echo "Tlačítko přidáno " . $i;
                } else {
                    echo mysqli_error($link);
                }
            }
            $_SESSION['table_add_error'] = false;
            header("location:../../admin.php");
        } else {
            echo mysqli_error($link);
        }
    }
}
?>