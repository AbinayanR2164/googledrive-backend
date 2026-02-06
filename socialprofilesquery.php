<?php
require "registerdbcon.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $_POST['name'];

// Fetch existing data before updating
$sql_fetch = "SELECT * FROM `socialprofiles` WHERE `name` = ?";
$stmt = $conn->prepare($sql_fetch);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Use existing values if new ones are not provided
    $linkedin = !empty($_POST['linkedin']) ? $_POST['linkedin'] : $row['linkedin'];
    $instagram = !empty($_POST['instagram']) ? $_POST['instagram'] : $row['instagram'];
    $facebook = !empty($_POST['facebook']) ? $_POST['facebook'] : $row['facebook'];
    $github = !empty($_POST['github']) ? $_POST['github'] : $row['github'];

    // Update the record
    $sql = "UPDATE `socialprofiles` SET 
            `linkedin` = ?, 
            `instagram` = ?, 
            `facebook` = ?, 
            `github` = ? 
            WHERE `name` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $linkedin, $instagram, $facebook, $github, $name);

    if ($stmt->execute()) {
        echo "Record updated successfully!";
        $conn->close();
        header("Location: searchquery.php"); // ✅ Redirect to avoid errors
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Insert new record if the user doesn't exist
    $linkedin = $_POST['linkedin'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $github = $_POST['github'];

    $sql = "INSERT INTO `socialprofiles` (`linkedin`, `instagram`, `facebook`, `name`,`github`) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $linkedin, $instagram, $facebook, $name, $github);

    if ($stmt->execute()) {
        echo "New record created successfully!";
        $conn->close();
        header("Location: searchquery.php"); // ✅ Redirect to avoid errors
        exit();
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

$conn->close();
?>
