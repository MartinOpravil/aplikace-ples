<?php

function generatePassword() {
    include("../../settings/settings.php");
    $pass_string = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; //36

    $password = "";
    for ($i=0; $i < $password_lenght; $i++) {
        //$password .= random_int(0, 9);
        $password .= substr($pass_string,random_int(0, 35),1);
    }

    echo $password;
    // Zkontroluj zda heslo existuje, pokud ano, znovu zavolej funkci
    include("../_access/mysqli_connect.php");
    $sql = "SELECT * FROM sedadla WHERE code='$password'";
    if($vysledek = mysqli_query($link,$sql)) {
        if (!mysqli_num_rows($vysledek) == 0) {
            generatePassword();
        } else {
            return $password;
        }
    }
}

generatePassword();

if (isset($_POST["order"])) {
    session_name ("aplikaceples");
    session_start();

    include("../_access/mysqli_connect.php");
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["seats_id"]) && isset($_POST["seats_text"])) {

        $name = $_POST["name"];
        $email = $_POST["email"];
        $seats_id = $_POST["seats_id"];
        $seats_text = $_POST["seats_text"];

        // Vytvoření hesla
        $generatedPassword = generatePassword();

        // Aktualizace dat v DB
        // 1. Zkontrolovat zda jsou skutečně volná
        $are_seats_valid = true;
        foreach ($seats_id as &$id) {
            $sql_select = "SELECT * FROM sedadla WHERE state='reserved' AND id='$id'";
            if($vysledek = mysqli_query($link,$sql_select)) {
                if (mysqli_num_rows($vysledek) > 0) {
                    $are_seats_valid = false;
                    break;
                }
            }
        }
        
        if (!$are_seats_valid) {
            // Některá sedadla jsou již obsazená
            $_SESSION['ordered'] = false;
            header("location:../../guest.php");
            exit;
        } else {
            $date_now = Date('Y-m-d');

            for ($i=0; $i < count($seats_id); $i++) {
                $sql_update = "UPDATE sedadla SET name='$name', email='$email', order_date='$date_now', state='reserved', code='$generatedPassword' WHERE id='$seats_id[$i]'";
                if($vysledek=mysqli_query($link, $sql_update)) {
                    echo "Sedadlo úspěšně rezervováno.<br>";
                } else {
                    echo mysqli_error($link); 
                }
            }
            echo "Všechna sedadla byla zarezervována";

            // Vytvoření data týden ode dneška pro email
            $newData = Date("d. m. Y", strtotime("+1 week"));

            // Vytvoření mailu
            $subject = "Aplikace Ples - Potvrzení objednávky";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            $message = '<html><body>';
            $message .= "Děkujeme Vám za objednávku." . '<br />';
            $message .= "Termín zaplacení: " . '<strong>' . $newData . '</strong><br /><br />';
            $message .= "Vaše rezervovaná místa:" . '<br />';

            foreach ($seats_text as &$seat) {
                $message .= '<strong style="font-size: large;">' . $seat . '</strong>&nbsp;&nbsp;&nbsp;';
            }

            $message .= '<br><br>' . "Vaše heslo:" . '<br />';
            $message .= '<strong style="font-size: xx-large;">' . $generatedPassword . '</strong>';
            $message .= '<p style="color:red">' . "Tímto heslem se prokážete při zaplacení." . '<br /> Děkujeme za pochopení.</p>';
            $message .= '</body></html>';

            //odeslání emailu
            mail($email, $subject, $message, $headers);
            $_SESSION['ordered'] = true;
            header("location:../../guest.php");
            exit;
        }
    }
    // Prázdné - nevybrány žádná sedadla
    $_SESSION['empty'] = true;
    header("location:../../guest.php");
}
?>