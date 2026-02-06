<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data Table</title>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            border: none;
            border-radius: 9px;
            width: 90px;
            height: 30px;
            color: white;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-delete {
            background-color: red;
        }

        .btn-update {
            background-color: blue;
        }
    </style>
</head>
<body>

<h2>Users Data Table</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Action</th>
    </tr>

    <?php
    require "registerdbcon.php";

    // Execute the query
    $sql = "SELECT * FROM registers";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch each row and display it in the table
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phonenumber']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td>
                    <form action="delete.php" method="POST" style="display:inline;">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                        <button type="submit" name="action" value="delete" class="btn btn-delete">Delete</button>
                    </form>
                    <form action="edit.php" method="POST" style="display:inline;">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                        <button type="submit" name="action" value="update" class="btn btn-update">Update</button>
                    </form>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='4'>No data found</td></tr>";
    }

    $conn->close();
    ?>

</table>

</body>
</html>
