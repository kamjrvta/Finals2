<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    // Check if POST variable "first_name$first_name" exists, if not default the value to blank, basically the same for all variables
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : date('Y-m-d H:i:s');
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    
    // Insert new record into the records table
    $stmt = $pdo->prepare('INSERT INTO records VALUES (?, ?, ?, ?, ?, ?,?,?)');
    $stmt->execute([$id, $first_name, $last_name, $address, $phone, $course, $birthdate, $contact]);
    // Output message
    $msg = 'Submitted Successfully!';
}
?>

<?=template_header('Create')?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student ID Form</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
    <div class="header">
        <h2>Student ID Form</h2>
        <h5>FILL UP THE FORM WITH CORRECT VALUES<h5>
    </div>
     <form action="create.php" method="post">
        <div class="input-group">
            <label>Last Name</label>
            <input type="text"id="last_name" name="last_name" value="" placeholder ="Jaravata">
        </div>

        <div class="input-group">
            <label>First Name</label>
            <input type="text" id="first_name" name="first_name" value="" placeholder ="Kristine Adel Marie">
        </div>      

        <div class="input-group">
            <label>ID Number</label>
            <input type="text" id="id" name="id"placeholder ="19-2518-829" maxlength="11" oninput ="this.value = this.value.replace(/[^0-9-]/g,'').replace(/(\..*)\./g,'$1');">
        </div>
 
<div class="input-group">
        <form action="/action_page.php">
        <label for="course">Course</label>
        <select name="course" id="course">
         <option value="BSIT">Bachelor of Science In Information Technology</option>
         <option value="BSCS">Bachelor of Science In Computer Science</option>
        <option value="BAPS">Bachelor of Arts in Political Science</option>
        <option value="BSCPE">Bachelor of Science in Computer Engineering</option>
         <option value="BSAcc">Bachelor of Science in Accountancy</option>
        <option value="BSArchi">Bachelor of Science in Architecture</option>
       </select>
</div>

        <div class="input-group">
            <label>Address</label>
            <input type="text" id="address" name="address" placeholder="Barangay, Town, Province">
        </div>

        <div class="input-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder ="09203559953" maxlength="11" oninput ="this.value = this.value.replace(/[^0-9-]/g,'').replace(/(\..*)\./g,'$1');">
        </div>

        <div class="input-group">
        <label for="birthday">Birthday</label>
        <input type="date" id="birthdate" name="birthday">
         </div>

        <div class="input-group">
            <label>In case of emergency, please contact:</label>
            <input type="text" id="contact" name="contact" placeholder="Park Seo Joon (spouse)">
        </div>
    
     
  <br>
  <div class="container">
  <button class="btn">Submit</button>

  </form>

</body>
</html>
<?=template_footer()?>