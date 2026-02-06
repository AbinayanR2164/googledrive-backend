<?php
require "registerdbcon.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $_POST['name'];

// Fetch existing data before updating
$sql_fetch = "SELECT * FROM `education` WHERE `name` = ?";
$stmt = $conn->prepare($sql_fetch);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Use existing values if new ones are not provided
    $sslcmarks = !empty($_POST['sslcmarks']) ? $_POST['sslcmarks'] : $row['sslcmarks'];
    $hscmarks = !empty($_POST['hscmarks']) ? $_POST['hscmarks'] : $row['hscmarks'];
    $ugdegree = !empty($_POST['ugdegree']) ? $_POST['ugdegree'] : $row['ugdegree'];
    $ugmarks = !empty($_POST['ugmarks']) ? $_POST['ugmarks'] : $row['ugmarks'];
    $pgdegree = !empty($_POST['pgdegree']) ? $_POST['pgdegree'] : $row['pgdegree'];
    $pgmarks = !empty($_POST['pgmarks']) ? $_POST['pgmarks'] : $row['pgmarks'];
    $schoolname = !empty($_POST['schoolname']) ? $_POST['schoolname'] : $row['schoolname'];
    $collegename = !empty($_POST['collegename']) ? $_POST['collegename'] : $row['collegename'];

    // Update the record
    $sql = "UPDATE `education` SET 
            `sslcmarks` = ?, 
            `hscmarks` = ?, 
            `ugdegree` = ?, 
            `ugmarks` = ?, 
            `pgdegree` = ?, 
            `pgmarks` = ?, 
            `schoolname` = ?, 
            `collegename` = ? 
            WHERE `name` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $sslcmarks, $hscmarks, $ugdegree, $ugmarks, $pgdegree, $pgmarks, $schoolname, $collegename, $name);

    if ($stmt->execute()) {
        echo "Record updated successfully!";
        $conn->close();
        header("Location: searchquery.php"); // ✅ Redirect to prevent multiple database interactions
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Insert new record if the user doesn't exist
    $sslcmarks = $_POST['sslcmarks'];
    $hscmarks = $_POST['hscmarks'];
    $ugdegree = $_POST['ugdegree'];
    $ugmarks = $_POST['ugmarks'];
    $pgdegree = $_POST['pgdegree'];
    $pgmarks = $_POST['pgmarks'];
    $schoolname = $_POST['schoolname'];
    $collegename = $_POST['collegename'];

    $sql = "INSERT INTO `education`(`sslcmarks`, `hscmarks`, `ugdegree`, `ugmarks`, `pgdegree`, `pgmarks`, `schoolname`, `collegename`, `name`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $sslcmarks, $hscmarks, $ugdegree, $ugmarks, $pgdegree, $pgmarks, $schoolname, $collegename, $name);

    if ($stmt->execute()) {
        echo "New record created successfully!";
        $conn->close();
        header("Location: searchquery.php"); // ✅ Redirect to searchquery.php
        exit();
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

$conn->close();
?>
