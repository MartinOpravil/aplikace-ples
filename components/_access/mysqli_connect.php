<?php
//$link = mysqli_connect('localhost', 'vos17opravilmmzf', 'overlord', 'bozenka');
$link = mysqli_connect('localhost', 'root', '', 'bozenka');

        if (!$link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }

        $link->query('SET NAMES utf8');
?>
