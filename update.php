<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the records id exists, for example update.php?id=1 will get the records with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : date('Y-m-d H:i:s');
        $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE records SET id = ?, first_name = ?, last_name = ?, address = ?, phone = ?, course = ?, birthdate = ? ,contact = ? WHERE id = ?');
        $stmt->execute([$id, $first_name, $last_name,$address, $phone, $course, $birthdate, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the records from the records table
    $stmt = $pdo->prepare('SELECT * FROM records WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $records = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$records) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>
<div class="content update">
    <h2>Update Contact #<?=$records['id']?></h2>
</div>
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
            <input type="text" name="last_name" value="<?=$records['last_name']?>"  id="last_name" >
        </div>

        <div class="input-group">
            <label>First Name</label>
            <input type="text"  name="first_name" value="<?=$records['first_name']?>" id="first_name">
        </div>      

        <div class="input-group">
            <label>ID Number</label>
            <input type="text"  name="id number" maxlength="11" value="<?=$records['id']?>" id="id">
        </div>
 
<div class="input-group">
        <form action="/action_page.php">
        <label for="course">Course</label>
        <select name="courses" value="<?=$records['course']?>" id="course">
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
            <input type="text"  name="Address" value="<?=$records['address']?>" id="address">
        </div>

        <div class="input-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?=$records['phone']?>" maxlength="11" oninput ="this.value = this.value.replace(/[^0-9-]/g,'').replace(/(\..*)\./g,'$1');">
        </div>

        <div class="input-group">
        <label for="birthday">Birthday</label>
        <input type="date"  name="birthdate" value="<?=date('m-d-Y\TH:i', strtotime($records['birthdate']))?>" id="birthdate">
         </div>

        <div class="input-group">
            <label>In case of emergency, please contact:</label>
            <input type="text"  name="EmergencyContact" value="<?=$records['contact']?>" id="contact">
        </div>
    
     
  <br>
  <div class="container">
  <button class="btn">Submit</button>

  <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
</form>
<?=template_footer()?>