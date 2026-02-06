<?php
require "registerdbcon.php";

$name = $_POST['name'] ?? '';
$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $year = $_POST['year'];
    $companyname = $_POST['companyname'];
    $role = $_POST['role'];
    $referrals = $_POST['referrals'] ?? '';

    $stmt = $conn->prepare("
      INSERT INTO workexp (name, year, companyname, role, referrals)
      VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $name, $year, $companyname, $role, $referrals);
    $stmt->execute();
    $stmt->close();
}
elseif ($action === 'delete' && isset($_POST['delete_sno'])) {
    $sno = intval($_POST['delete_sno']);
    $stmt = $conn->prepare("
      DELETE FROM workexp WHERE sno = ? AND name = ?
    ");
    $stmt->bind_param("is", $sno, $name);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: workexp.php?id=" . urlencode($name));
exit();