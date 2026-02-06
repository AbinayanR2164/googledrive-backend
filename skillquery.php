<?php
require "registerdbcon.php";

$name = $_POST['name'];
$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $skill = $_POST['skill'];
    $skill_level = $_POST['skill_level'];
    $interestedfields = $_POST['interestedfields'];

    $sql = "INSERT INTO skills (name, skill, skill_level, interestedfields)
            VALUES ('$name', '$skill', '$skill_level', '$interestedfields')";

    if ($conn->query($sql) === TRUE) {
        header("Location: skill.php?id=" . urlencode($name));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($action === 'delete' && isset($_POST['delete_sno'])) {
    $sno = intval($_POST['delete_sno']);

    $sql = "DELETE FROM skills WHERE sno = $sno AND name = '$name'";
    if ($conn->query($sql) === TRUE) {
        header("Location: skill.php?id=" . urlencode($name));
        exit();
    } else {
        echo "Error deleting: " . $conn->error;
    }
}
?>