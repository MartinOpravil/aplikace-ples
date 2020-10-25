<?php 
include ("../_access/mysqli_connect.php");
if(isset($_POST['update-table'])) {
    if(isset($_POST['direction']) && isset($_POST['number']) && isset($_POST['canvas']) && isset($_POST['data_table_id'])) {
        $direction = $_POST['direction'];
        $number = $_POST['number'];
        $canvas = $_POST['canvas'];
        $data_table_id = $_POST['data_table_id'];

        $sql_table = "UPDATE stoly SET direction='$direction', number='$number', canvas='$canvas' WHERE id='$data_table_id'";

        
        if($vysledek=mysqli_query($link, $sql_table)){
            // Vše proběhlo v pořádku
            $is_table_removed = false;
            session_name ("aplikaceples");
            session_start();
            if (isset($_POST['ids']) && isset($_POST['names']) && isset($_POST['emails']) && isset($_POST['dates']) && isset($_POST['states'])) {
                $seats_length = count($_POST['ids']);
                
                for ($i = 0; $i < $seats_length; $i++) {
                    $id = $_POST['ids'][$i];
                    $name = $_POST['names'][$i];
                    $email = $_POST['emails'][$i];
                    $date = $_POST['dates'][$i];
                    $state = $_POST['states'][$i];
                    echo $date; //STR_TO_DATE('1-01-2012', '%d-%m-%Y')
                    echo $id;

                    if ($id !== "undefined") {
                        echo "Aktualizace<br>";
                        if (strlen($date)>0) {
                            $sql_seat = "UPDATE sedadla SET name='$name', email='$email', order_date='$date', state='$state' WHERE id='$id'";
                        } else {
                            $sql_seat = "UPDATE sedadla SET name='$name', email='$email', order_date=NULL, state='$state' WHERE id='$id'";
                        }
                    } else {
                        echo "Vložení nového<br>";
                        $sql_seat = "INSERT INTO sedadla (state,name,email,order_date,table_id,code) VALUES ('$state','$name','$email',NULL,'$data_table_id','')";
                    }
                    
                    if($vysledek=mysqli_query($link, $sql_seat)) {
                        echo "Sedadlo aktualizováno<br>";
                    } else {
                        echo mysqli_error($link);
                    }
                }

                // DELETE
                if (isset($_POST['ids_to_remove'])) {
                    $ids_to_remove = $_POST['ids_to_remove'];
                    $seats_to_remove_length = count($ids_to_remove);
                    
                    for ($i = 0; $i < $seats_to_remove_length; $i++) {
                        $id = $ids_to_remove[$i];
                        
                        $sql_seat_delete = "DELETE FROM sedadla WHERE id='$id'";
                        if($vysledek=mysqli_query($link, $sql_seat_delete)) {
                            echo "Sedadlo odstraněno.<br>";
                        } else {
                            echo mysqli_error($link);
                        }
                    }
                }

            } else {
                // Chyba v sedadlech
                $is_table_removed = true;
                // DELETE TABLE
                $seats_exists = isset($_POST['ids']);
                if (!$seats_exists) {
                    $sql_remove_table = "DELETE FROM stoly WHERE id='$data_table_id'";
                    if($vysledek=mysqli_query($link, $sql_remove_table)){
                        echo "Stůl byl odstraněn";
                    } else {
                        echo mysqli_error($link);
                    }
                }
            }
            // Je stůl odstraněn?
            if ($is_table_removed == false) {
                $_SESSION['table_update_error'] = "aktualizovat";
            } else {
                $_SESSION['table_update_error'] = "odstranit";
            }

            header("location:../../admin.php");
        } else {
            echo mysqli_error($link);
        }
    }
}
?>