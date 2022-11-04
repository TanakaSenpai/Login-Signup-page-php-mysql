<?php

    $conn = mysqli_connect("localhost","root","","test");

    if (mysqli_connect_error()){
        echo "Sql connection failed";
        echo "<script>alert('Sql connection failed');</script>";
        exit();
    }

?>