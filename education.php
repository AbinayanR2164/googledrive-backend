<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="education.css">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Education details</title>
</head>

<body>
  <form class="register" action="educationquery.php" method="post">
<div class="login">
  <div class="login-header">
    <h1>Education Details</h1>
  </div>
  <div class="login-form">
    <h3>Student Name</h3>
    <input type="text" name="name" <?php $name=$_REQUEST['id'];?>   value="<?php echo "$name"; ?>"   readonly  ><br>
     <h3>SSLC Marks</h3>
    <input type="text" name="sslcmarks" placeholder="SSLC Marks in %"/><br>
    <h3>HSC Marks</h3>
    <input type="text" name="hscmarks" placeholder="HSC Marks in %"/>
    <br>
    <h3>UG Degree</h3>
    <input type="text" name="ugdegree" placeholder="UG Degree"/>
    <br>
    <h3>UG Degree Marks</h3>
    <input type="text" name="ugmarks" placeholder="UG Degree Marks"/>
    <br>
    <h3>PG Degree</h3>
    <input type="text" name="pgdegree" placeholder="PG Degree"/>
    <br>
    <h3>PG Degree Marks</h3>
    <input type="text" name="pgmarks" placeholder="PG Degree Marks"/>
    <br>
    <h3>School Name</h3>
    <input type="text" name="schoolname" placeholder="SSLC and HSC School Name"/>
    <br>
    <h3>College Name</h3>
    <input type="text" name="collegename" placeholder="UG and PG Degree College Name"/>
    <br>


    <button value="submit" class="form__input">Submit</button>
    <br>
  </div>
</div>
</form>

    </form>
    </body>
  
</html>