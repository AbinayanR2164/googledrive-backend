<?php
require 'registerdbcon.php';
$name = $_REQUEST['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="skill.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Yinka Enoch Adedokun">
  <title>Register Page</title>
</head>
<body>
  <!-- Your existing form structure unchanged -->
  <form class="register" action="skillquery.php" method="post">
    <div class="container-fluid">
      <div class="row main-content bg-success text-center">
        <div class="col-md-4 text-center company__info">
          <h2><span class="fa fa-android"></span></h2>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4OENIRhMJSSFfply5eouqd6qk7bgx3cmIFQ&s" alt="logo">
        </div>
        <div class="col-md-8 col-xs-12 col-sm-12 login_form">
          <div class="container-fluid">
            <div class="row"><h2>Skills</h2></div>
            <div class="row">
              <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
            <div class="row">
              <input type="text" name="skill" class="form__input" placeholder="Skill" required>
            </div>
            <div class="row">
              <input type="text" name="skill_level" class="form__input" placeholder="Skill Level" required>
            </div>
            <div class="row">
              <input type="text" name="interestedfields" class="form__input" placeholder="Interested Fields" required>
            </div>
            <button style="width:200px; background-color:seagreen; border-radius:100px; color:white;" name="action" value="add" class="form__input">
              Enter
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Enhanced Skills Table with Inline CSS -->
  <?php if ($name): ?>
  <div class="container-fluid text-center" style="margin-top:20px;">
    <h3>Skills Entered</h3>
    <table style="
        margin:auto;
        width:90%;
        max-width:800px;
        border-collapse:collapse;
        font-family:Arial,sans-serif;
        box-shadow:0 2px 6px rgba(0,0,0,0.1);
      ">
      <thead style="background:#49708f; color:#fff;">
        <tr>
          <th style="padding:10px; text-align:left;">Skill</th>
          <th style="padding:10px; text-align:left;">Level</th>
          <th style="padding:10px; text-align:left;">Fields</th>
          <th style="padding:10px; text-align:center;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $res = $conn->query("SELECT sno, skill, skill_level, interestedfields FROM skills WHERE name='" . $conn->real_escape_string($name) . "'");
        while ($row = $res->fetch_assoc()):
        ?>
        <tr style="background:#f9f9f9; border-bottom:1px solid #ddd;">
          <td style="padding:10px;"><?php echo htmlspecialchars($row['skill']); ?></td>
          <td style="padding:10px;"><?php echo htmlspecialchars($row['skill_level']); ?></td>
          <td style="padding:10px;"><?php echo htmlspecialchars($row['interestedfields']); ?></td>
          <td style="padding:8px; text-align:center;">
            <form action="skillquery.php" method="post" onsubmit="return confirm('Delete this skill?');">
              <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
              <input type="hidden" name="delete_sno" value="<?php echo intval($row['sno']); ?>">
              <button type="submit" name="action" value="delete" style="
                padding:6px 12px;
                background-color:#dc3545;
                color:#fff;
                border:none;
                border-radius:4px;
                cursor:pointer;
                transition:background-color .2s;
              " onmouseover="this.style.backgroundColor='#c82333';" onmouseout="this.style.backgroundColor='#dc3545';">
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

  <!-- Footer unchanged -->
  <div class="container-fluid text-center footer" style="margin-top:30px;">
    Coded with &hearts; by Tech Infinity
  </div>
</body>
</html>