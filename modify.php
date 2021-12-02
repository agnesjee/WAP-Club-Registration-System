<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['stuName']) && isset($_POST['stuClass']) && isset($_POST['stuTel']) && isset($_POST['stuEmail']) && isset($_POST['clubsNum']) && isset($_POST['Stu_Num']) ) {

    // Data validation
    if ( $_POST['stuName'] == " " || $_POST['stuClass'] == " " || $_POST['stuTel'] == " "  || $_POST['stuEmail'] == " " || $_POST['clubsNum'] == " " ) {
        $_SESSION['error'] = 'The data should not contain white space only.';
        header("Location: modify.php?Stu_Num=".$_POST['Stu_Num']);
        return;
    }

    if ( strpos($_POST['stuEmail'],'@') === false ) {
        $_SESSION['error'] = 'Please enter a valid email format.';
        header("Location: modify.php?Stu_Num=".$_POST['Stu_Num']);
        return;
    }

    if ( ! preg_match("/^[a-zA-Z-' ]*$/", $_POST['stuName'])) {
        $_SESSION['error'] = "Only letters and white space are allowed in the name field.";
        header("Location: modify.php?Stu_Num=".$_POST['Stu_Num']);
        return;
    }

    if ( ! is_numeric($_POST['clubsNum'])) {
        $_SESSION['error'] = "Club number must contain numbers only.";
        header("Location: modify.php?Stu_Num=".$_POST['Stu_Num']);
        return;
    }

    $sql = "UPDATE student SET Stu_Name = :stuName, Stu_Class = :stuClass, Stu_Tel = :stuTel, Stu_Email = :stuEmail, Clubs_Num = :clubsNum
            WHERE Stu_Num = :stuNum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':stuName' => $_POST['stuName'],
        ':stuClass' => $_POST['stuClass'],
        ':stuTel' => $_POST['stuTel'],
        ':stuEmail' => $_POST['stuEmail'],
        ':clubsNum' => $_POST['clubsNum'],
        ':stuNum' => $_POST['Stu_Num']));

    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that Stu_Num is present
if ( ! isset($_GET['Stu_Num']) ) {
  $_SESSION['error'] = "Missing Stu_Num";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM student where Stu_Num = :zip");
$stmt->execute(array(":zip" => $_GET['Stu_Num']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for Stu_Num';
    header( 'Location: index.php' ) ;
    return;
}

// Prints flash message on top of the form if have error message
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

// Make the server can show the values on each respective input fields automatically
$stuName = htmlentities($row['Stu_Name']);
$stuClass = htmlentities($row['Stu_Class']);
$stuTel = htmlentities($row['Stu_Tel']);
$stuEmail = htmlentities($row['Stu_Email']);
$clubsNum = htmlentities($row['Clubs_Num']);
$stuNum = $row['Stu_Num'];

?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css.css"/>
</head>
<body>

  <!--Form to modify a student data-->
  <div class="container">
      <h1 class="textGreen" style="margin-top: 0px;"><b>Edit a Student's Information</b></h1>
      <hr style="width:50px;border:5px solid #54C571" class="round">
      <form method="post">
        <div class="section">
          <!--The hidden field is not shown to the user, but the data is sent when the form is submitted.-->
          <input type="hidden" name="Stu_Num" value="<?= $stuNum ?>">
          <label>Name</label>
          <input class="formInput" type="text" name="stuName" value="<?= $stuName ?>" required/>
        </div>
        <div class="section">
          <label>Class</label>
          <input class="formInput" type="text" name="stuClass" value="<?= $stuClass ?>" required/>
        </div>
        <div class="section">
          <label>Telephone</label>
          <input class="formInput" type="text" name="stuTel" value="<?= $stuTel ?>" required/>
        </div>
        <div class="section">
          <label>Email</label>
          <input class="formInput" type="text" name="stuEmail" value="<?= $stuEmail ?>" required/>
        </div>
        <div class="section">
          <label>Club Number</label>
          <input class="formInput" type="text" name="clubsNum" value="<?= $clubsNum ?>" required/>
        </div>
        <button type="submit" class="formBtn" style="font-family: Georgia, sans-serif;">Update</button>
        <a href="index.php" style="margin-left: 10px; text-decoration: none;">Cancel</a>
      </form>
    </div>

</body>
</html>
