<?php

$conn = new mysqli("localhost", "root", "", "aschool");

if ($conn->connect_error) {
    die("Connection error!");
}

?>