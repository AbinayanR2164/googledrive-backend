<?php




$name=$_POST['name'];
$mobilenumber=$_POST['mobilenumber'];
$emailid=$_POST['emailid'];

 require 'registerdbcon.php';   


$sql = "UPDATE register SET mobilenumber='$mobilenumber', emailid='$emailid' WHERE name='$name'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<script>
        location.replace("nearsearch.php?id=<?php echo"$name" ?>");
</script>