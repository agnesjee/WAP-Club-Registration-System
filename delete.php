<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['Stu_Num']) ) {
    $sql = "DELETE FROM student where Stu_Num = :Stu_Num";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':Stu_Num' => $_POST['Stu_Num']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that Stu_Num is present
if ( ! isset($_GET['Stu_Num']) ) {
  $_SESSION['error'] = "Missing Stu_Num";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT Stu_Name,Stu_Class, Stu_Tel, Stu_Email, Clubs_Num FROM student where Stu_Num = :Stu_Num");
$stmt->execute(array(":Stu_Num" => $_GET['Stu_Num']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for Stu_Num';
    header( 'Location: index.php' ) ;
    return;
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css.css"/>
</head>
<body>

  <!--Form to add a new student-->
  <div class="container">
      <h1 class="textGreen" style="margin-top: 0px;"><b>Delete Student</b></h1>
      <hr style="width:50px;border:5px solid #54C571" class="round">
      <form method="post">
        <div class="section">
          <!--The hidden field is not shown to the user, but the data is sent when the form is submitted.-->
          <input type="hidden" name="Stu_Num" value="<?= $row['Stu_Num'] ?>">
          <label>Name</label>
          <input class="formInput" type="text" disabled value="<?= $row['Stu_Name'] ?>"/>
        </div>
        <div class="section">
          <label>Class</label>
          <input class="formInput" type="text" disabled value="<?= $row['Stu_Class'] ?>"/>
        </div>
        <div class="section">
          <label>Telephone</label>
          <input class="formInput" type="text" disabled value="<?= $row['Stu_Tel'] ?>"/>
        </div>
        <div class="section">
          <label>Email</label>
          <input class="formInput" type="text" disabled value="<?= $row['Stu_Email'] ?>"/>
        </div>
        <div class="section">
          <label>Club Number</label>
          <input class="formInput" type="text" disabled value="<?= $row['Clubs_Num'] ?>"/>
        </div>
        <p>Confirm: Deleting <?= htmlentities($row['Stu_Name']) ?></p>
        <input type="submit" name="delete" value="Delete" class="formBtn" style="font-family: Georgia, sans-serif;"/>
        <a href="index.php" style="margin-left: 10px; text-decoration: none;">Cancel</a>
      </form>
    </div>

</body>
</html>
