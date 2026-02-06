<?php
require 'registerdbcon.php';
$name = $_REQUEST['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="workexp.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Work Experience</title>
</head>
<body>
<form class="register" action="workexpquery.php" method="post">
  <div class="login">
    <div class="login-triangle"></div>
    <h2 class="login-header">Work Experience</h2>
    <!-- Existing Form -->
    <div class="login-container">
      <p><input type="text" name="name" value="<?= htmlspecialchars($name) ?>" readonly></p>
      <p><input type="number" name="year" placeholder="Duration Years" required></p>
      <p><input type="text" name="companyname" placeholder="Company Name" required></p>
      <p><input type="text" name="role" placeholder="Your Role" required></p>
      <p><input type="text" name="referrals" placeholder="location"></p>
      <p><button type="submit" name="action" value="add"
                 style="width:370px;height:49px;background-color:grey;color:white;border-radius:80px;border:none;cursor:pointer;">
            Submit
      </button></p>
    </div>
  </div>
</form>

<?php if ($name): ?>
<div style="max-width:800px;margin:20px auto;font-family:Arial,sans-serif;">
  <h3 style="text-align:center;">Work Experiences</h3>
  <table style="
      width:100%;
      border-collapse:collapse;
      box-shadow:0 2px 6px rgba(0,0,0,0.1);
    ">
    <thead style="background:#49708f;color:#fff;">
      <tr>
        <th style="padding:10px;text-align:left;">Years</th>
        <th style="padding:10px;text-align:left;">Company</th>
        <th style="padding:10px;text-align:left;">Role</th>
        <th style="padding:10px;text-align:left;">Referrals</th>
        <th style="padding:10px;text-align:center;">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = $conn->query(
        "SELECT sno, year, companyname, role, referrals 
         FROM workexp WHERE name='" . $conn->real_escape_string($name) . "'"
      );
      while ($row = $res->fetch_assoc()):
      ?>
      <tr style="background:#f9f9f9;border-bottom:1px solid #ddd;">
        <td style="padding:10px;"><?= htmlspecialchars($row['year']) ?></td>
        <td style="padding:10px;"><?= htmlspecialchars($row['companyname']) ?></td>
        <td style="padding:10px;"><?= htmlspecialchars($row['role']) ?></td>
        <td style="padding:10px;"><?= htmlspecialchars($row['referrals']) ?></td>
        <td style="padding:10px;text-align:center;">
          <form action="workexpquery.php" method="post"
                onsubmit="return confirm('Delete this entry?');">
            <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
            <input type="hidden" name="delete_sno" value="<?= intval($row['sno']) ?>">
            <button type="submit" name="action" value="delete"
                    style="
                      background-color:#dc3545;
                      color:white;
                      padding:6px 12px;
                      border:none;
                      border-radius:4px;
                      cursor:pointer;
                      transition:background-color .2s;
                    "
                    onmouseover="this.style.backgroundColor='#c82333';"
                    onmouseout="this.style.backgroundColor='#dc3545';">
              Delete
            </button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

</body>
</html>