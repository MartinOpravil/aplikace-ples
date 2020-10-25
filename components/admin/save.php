<?php 
include ("../_access/mysqli_connect.php");

if(isset($_POST['save'])) {
    // Uložit grafiku
    if(strlen($_POST['data_graphic']) > 0) {
        $data_graphic = $_POST['data_graphic'];
        $jArray = json_decode($data_graphic, true);

        // Projdi všechna data
        for ($i = 0; $i < count($jArray); $i++) {
            $id = $jArray[$i]['id'];
            $x = $jArray[$i]['x'];
            $y = $jArray[$i]['y'];
            $width = $jArray[$i]['width'];
            $height = $jArray[$i]['height'];
            $icon = $jArray[$i]['icon'];
            $canvas = $jArray[$i]['canvas'];

            $sql="INSERT INTO grafika (id,x,y,width,height,icon,canvas) VALUES('$id','$x','$y','$width','$height','$icon','$canvas') ON DUPLICATE KEY UPDATE
                x='$x',y='$y',width='$width',height='$height',icon='$icon',canvas='$canvas'";
            
            if($vysledek=mysqli_query($link, $sql)){
                // Zde nic nikdy nebude pravděpodobně
            } else {
                echo mysqli_error($link);
            }
        }
        echo "Grafika úspěšně uložena.<br>";
    } else {
        echo "Chyba v grafice.<br>";
    }
    // Uložit stoly
    if(strlen($_POST['data_tables']) > 0) {
        $data_tables = $_POST['data_tables'];
        $jArray = json_decode($data_tables, true);

        // Projdi všechna data
        for ($i = 0; $i < count($jArray); $i++) {
            $id = $jArray[$i]['id'];
            $x = $jArray[$i]['x'];
            $y = $jArray[$i]['y'];
            $direction = $jArray[$i]['direction'];
            $canvas = $jArray[$i]['canvas'];
            $number = $jArray[$i]['number'];

            $sql="INSERT INTO stoly (id,x,y,direction,canvas,number) VALUES('$id','$x','$y','$direction','$canvas','$number') ON DUPLICATE KEY UPDATE
                x='$x',y='$y',direction='$direction',canvas='$canvas',number='$number'";
            
            if($vysledek=mysqli_query($link, $sql)){
                // Zde nic nikdy nebude pravděpodobně
            } else {
                echo mysqli_error($link);
            }
        }
        echo "Stoly úspěšně uloženy.<br>";
    } else {
        echo "Chyba ve stolech.<br>";
    }
    // Uložit stoly
    if(strlen($_POST['data_seats']) > 0) {
        $data_seats = $_POST['data_seats'];
        $jArray = json_decode($data_seats, true);

        for ($i = 0; $i < count($jArray); $i++) {
            $id = $jArray[$i]['id'];
            $state = $jArray[$i]['state'];
            $name = $jArray[$i]['name'];
            $email = $jArray[$i]['email'];
            $order_date = $jArray[$i]['order_date'];
            $table_id = $jArray[$i]['table_id'];

            if (strlen($order_date)>0) {
                $sql="INSERT INTO sedadla (id,state,name,email,order_date,table_id,code) VALUES('$id','$state','$name','$email',NULL,'$table_id','') ON DUPLICATE KEY UPDATE
                state='$state',name='$name',email='$email',order_date='$order_date',table_id='$table_id'";
            } else {
                $sql="INSERT INTO sedadla (id,state,name,email,order_date,table_id,code) VALUES('$id','$state','$name','$email',NULL,'$table_id','') ON DUPLICATE KEY UPDATE
                state='$state',name='$name',email='$email',order_date=NULL,table_id='$table_id'";
            }
            
            if($vysledek=mysqli_query($link, $sql)){
                // Zde nic nikdy nebude pravděpodobně
            } else {
                echo mysqli_error($link);
            }
        }
        echo "Sedadla úspěšně uloženy.<br>";
    } else {
        echo "Chyba ve sedadlech.<br>";
    }
    header("location:../../admin.php");
}
?>