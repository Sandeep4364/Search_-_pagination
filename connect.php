<?php

$con = new mysqli("localhost", "root", "", "sandeep");

if (!$con) {
    die ( mysqli_error($con));
} 


?>