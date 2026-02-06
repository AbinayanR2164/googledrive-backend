<?php
require"registerdbcon.php";

$name =$_POST['name'];
$skills =$_POST['skills'];
$skills_description =$_POST['skills_description'];


$sql = "INSERT INTO `tools`( `name`,`skills`, `skills_description`) VALUES ('$name','$skills','$skills_description')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";

    require 'searchquery.php';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



?>