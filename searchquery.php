<?php
session_start();
require "registerdbcon.php";

if (!isset($_SESSION['name'])) {
    echo "❌ Error: User not logged in!";
    exit();
}
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data Table</title> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: white;
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            background-color: #2e2e2e;
            color: white;
        }
        td, th {
            border: 1px solid #444;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #3a3a3a;
        }
        h2 {
            margin-bottom: 10px;
            color: #00c6ff;
        }

        .glow-button {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
            margin: 5px 3px;
        }

        .glow-button:hover {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            box-shadow: 0 0 15px #00c6ff, 0 0 30px #0072ff, 0 0 45px #0072ff;
            transform: scale(1.05);
        }

        .green-button {
            padding: 10px 20px;
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 5px 3px;
            box-shadow: 0 0 12px rgba(40, 167, 69, 0.4);
        }

        .green-button:hover {
            background: linear-gradient(135deg, #34d058, #28a745);
            box-shadow: 0 0 15px #34d058, 0 0 30px #28a745, 0 0 45px #28a745;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>   

<a href="register.php"><button class="glow-button">➕ New Register</button></a> 

<table>
    <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <?php
    $sql = "SELECT * FROM register WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['mobilenumber']); ?></td>
                <td><?php echo htmlspecialchars($row['emailid']); ?></td>
                <td>
                    <form action="edit.php" method="POST" style="display:inline;">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                        <button type="submit" name="action" value="update" class="glow-button">Update</button>
                    </form>

                    <?php
                    for ($i = 1; $i <= 14; $i++) {
                        $path = "";
                        switch ($i) {
                            case 1: $path = "Personal/index.php"; break;
                            case 2: $path = "techinfinity2/resume/index.php"; break;
                            case 3: $path = "mysecondtemplate/lmpixels.com/demo/unique/unique-vcard/index.php"; break;
                            case 4: $path = "techinfinity4/template4/themewagon.github.io/iPortfolio/index1.php"; break;
                            case 5: $path = "techinfinity5/www.wix.com/demone2/nicol-rider.php"; break;
                            case 6: $path = "techinfinity6/themewagon.github.io/meetme/index.php"; break;
                            case 7: $path = "template3/techinfinity3/resume/devfolio/index.php"; break;
                            case 8: $path = "techinfinity8/demo.templateflip.com/creative-cv/index.php"; break;
                            case 9: $path = "template9/techinfinity9/preview.colorlib.com/theme/clark/index.php"; break;
                            case 10: $path = "techinfinity10/demo.templateflip.com/material-resume/index.php"; break;
                            case 11: $path = "techinfinity11/preview.colorlib.com/theme/ronaldo/index.php"; break;
                            case 12: $path = "techinfinity12/preview.colorlib.com/theme/clark/index.php"; break;
                            case 13: $path = "techinfinity13/preview.colorlib.com/theme/clyde/index.php"; break;
                            case 14: $path = "template7/techinfinity7/resume/kelly/index-2.php"; break;
                        }
                        echo '<a href="'.$path.'?id='.htmlspecialchars($row['name']).'">
                                <button class="glow-button" style="width: 160px;">Resume Website '.$i.'</button>
                              </a> ';
                    }
                    ?>

                    <br><br>
                    <a href="education.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Education</button></a>
                    <a href="personal.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Personal</button></a>
                    <a href="workexp.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Work Exp</button></a>
                    <a href="skill.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Skills</button></a>
                    <a href="referral.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Referrals</button></a>
                    <a href="achieve.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Projects</button></a>
                    <a href="socialprofiles.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Social Links</button></a>
                     <a href="events.php?id=<?php echo htmlspecialchars($row['name']); ?>"><button class="green-button">Add Events,Competition </button></a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='4'>No user data found.</td></tr>";
    }
    ?>
</table>

</body>
</html>
