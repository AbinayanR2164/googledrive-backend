<?php
require "registerdbcon.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_referral'])) {
        $referral_id = $_POST['delete_referral'];

        // Get image path before deleting
        $sql_select = "SELECT referralimage FROM workexp WHERE sno = ?";
        $stmt = $conn->prepare($sql_select);
        $stmt->bind_param("i", $referral_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Delete referral entry
        $sql = "DELETE FROM workexp WHERE sno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $referral_id);
        if ($stmt->execute()) {
            if (!empty($row['referralimage']) && file_exists($row['referralimage'])) {
                unlink($row['referralimage']);
            }
            $success = "Referral deleted successfully!";
        } else {
            $error = "Error deleting referral: " . $conn->error;
        }
    } else {
        if (empty($_POST['name']) || empty($_POST['referrals']) || empty($_POST['aboutreferral'])) {
            $error = "All fields are required.";
        } elseif (empty($_FILES['referralimage']['name'])) {
            $error = "Please upload a referral image.";
        } else {
            $name = $_POST['name'];
            $referrals = $_POST['referrals'];
            $aboutreferral = $_POST['aboutreferral'];

            // Check referral count for the user
            $sql_count = "SELECT COUNT(*) as count FROM workexp WHERE name = ?";
            $stmt = $conn->prepare($sql_count);
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $referral_count = $row['count'];

            if ($referral_count >= 5) {
                $error = "Maximum of 5 referrals allowed.";
            } else {
                // Check if referral title already exists for that user
                $sql_check = "SELECT sno FROM workexp WHERE name = ? AND referrals = ?";
                $stmt = $conn->prepare($sql_check);
                $stmt->bind_param("ss", $name, $referrals);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error = "This referral title already exists.";
                } else {
                    $referralimage = '';
                    if ($_FILES['referralimage']['error'] === UPLOAD_ERR_OK) {
                        $target_dir = "uploads/";
                        if (!file_exists($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }
                        $file_ext = strtolower(pathinfo($_FILES["referralimage"]["name"], PATHINFO_EXTENSION));
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                        if (in_array($file_ext, $allowed_ext)) {
                            $new_filename = uniqid('ref_', true) . '.' . $file_ext;
                            $target_file = $target_dir . $new_filename;
                            if (move_uploaded_file($_FILES["referralimage"]["tmp_name"], $target_file)) {
                                chmod($target_file, 0644);
                                $referralimage = $target_file;
                            } else {
                                $error = "Error uploading image.";
                            }
                        } else {
                            $error = "Only JPG, JPEG, PNG & GIF files allowed.";
                        }
                    }

                    if (empty($error)) {
                        $sql = "INSERT INTO workexp (name, referrals, aboutreferral, referralimage) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssss", $name, $referrals, $aboutreferral, $referralimage);
                        if ($stmt->execute()) {
                            $success = "Referral added successfully!";
                        } else {
                            $error = "Database error: " . $conn->error;
                        }
                    }
                }
            }
        }
    }
}

$name = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$referrals_list = [];
if (!empty($name)) {
    $sql_fetch = "SELECT * FROM workexp WHERE name = ? ORDER BY sno DESC";
    $stmt = $conn->prepare($sql_fetch);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $referrals_list = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Referral Information</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
    body { background: #456; font-family: 'Open Sans', sans-serif; padding: 20px; margin: 0; }
    .login { width: 90%; max-width: 800px; margin: 0 auto; font-size: 16px; }
    .login-header { background: #28d; padding: 20px; font-size: 1.4em; color: #fff; text-align: center; border-radius: 5px 5px 0 0; }
    .login-container { background: #ebebeb; padding: 20px; border-radius: 0 0 5px 5px; }
    .login input, .login textarea { width: 100%; padding: 16px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.95em; }
    .login textarea { min-height: 120px; resize: vertical; }
    .login input[type="submit"] { background: #28d; color: #fff; cursor: pointer; font-weight: bold; }
    .login input[type="submit"]:hover { background: #17c; }
    .error, .success { text-align: center; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
    .error { color: #d9534f; background: #f8d7da; border: 1px solid #f5c6cb; }
    .success { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; }
    .referrals-list { margin-top: 25px; }
    .referral-item { background: white; padding: 20px; border-radius: 5px; margin-bottom: 15px; position: relative; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .referral-item img { max-width: 100%; max-height: 200px; border-radius: 4px; margin-top: 15px; }
    .delete-btn { position: absolute; top: 15px; right: 15px; background: #d9534f; color: white; border: none; padding: 6px 12px; border-radius: 3px; cursor: pointer; }
    .delete-btn:hover { background: #c9302c; }
    .referral-count { text-align: center; font-weight: bold; margin: 20px 0; color: #333; }
    @media (max-width: 600px) {
      .delete-btn { position: static; display: block; margin-top: 10px; }
    }
  </style>
</head>
<body>
<div class="login">
  <h2 class="login-header">Referral Information</h2>

  <?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if (!empty($name)): ?>
    <div class="referral-count">You have submitted <?= count($referrals_list) ?> of 5 referrals.</div>

    <div class="referrals-list">
      <?php foreach ($referrals_list as $ref): ?>
        <div class="referral-item">
          <h4><?= htmlspecialchars($ref['referrals']) ?></h4>
          <p><?= nl2br(htmlspecialchars($ref['aboutreferral'])) ?></p>
          <?php if (!empty($ref['referralimage'])): ?>
            <img src="<?= htmlspecialchars($ref['referralimage']) ?>" alt="Referral Image">
          <?php endif; ?>
          <form method="POST" onsubmit="return confirm('Are you sure to delete this referral?');">
            <input type="hidden" name="delete_referral" value="<?= $ref['sno'] ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (count($referrals_list) < 5): ?>
      <div class="login-container">
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
          <input type="text" name="referrals" placeholder="Referral Title" required>
          <textarea name="aboutreferral" placeholder="Write about the referral..." required></textarea>
          <input type="file" name="referralimage" accept="image/*" required>
          <input type="submit" value="Add Referral">
        </form>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <div class="error">No user selected. Please provide ?id=USERNAME in the URL.</div>
  <?php endif; ?>
</div>
</body>
</html>
