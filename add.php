<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['stuName']) && isset($_POST['stuClass']) && isset($_POST['stuTel']) && isset($_POST['stuEmail']) && isset($_POST['clubsNum']) ) {

    $stuName = $_POST['stuName'];
    $stuClass = $_POST['stuClass'];
    $stuTel = $_POST['stuTel'];
    $stuEmail = $_POST['stuEmail'];
    $clubsNum = $_POST['clubsNum'];

    $_SESSION['stuName'] = $stuName;
    $_SESSION['stuClass'] = $stuClass;
    $_SESSION['stuTel'] = $stuTel;
    $_SESSION['stuEmail'] = $stuEmail;
    $_SESSION['clubsNum'] = $clubsNum;

    // Data validation
    if ( $_POST['stuName'] == " " || $_POST['stuClass'] == " " || $_POST['stuTel'] == " "  || $_POST['stuEmail'] == " " || $_POST['clubsNum'] == " "  ) {
        $_SESSION['error'] = 'The data should not contain white space only.';
        header("Location: add.php");
        return;
    }

    if ( strpos($_POST['stuEmail'],'@') === false ) {
        $_SESSION['error'] = 'Please enter a valid email format.';
        header("Location: add.php");
        return;
    }

    if ( ! preg_match("/^[a-zA-Z-' ]*$/", $_POST['stuName'])) {
        $_SESSION['error'] = "Only letters and white space are allowed in the name field.";
        header("Location: add.php");
        return;
    }

    if ( ! is_numeric($_POST['clubsNum'])) {
        $_SESSION['error'] = "Club number must contain numbers only.";
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO student (Stu_Name, Stu_Class, Stu_Tel, Stu_Email, Clubs_Num) VALUES (:stuName, :stuClass, :stuTel, :stuEmail, :clubsNum)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':stuName' => $_POST['stuName'],
        ':stuClass' => $_POST['stuClass'],
        ':stuTel' => $_POST['stuTel'],
        ':stuEmail' => $_POST['stuEmail'],
        ':clubsNum' => $_POST['clubsNum']));

    $_SESSION['success'] = 'Record Added';
    unset($_SESSION['stuName']);
    unset($_SESSION['stuClass']);
    unset($_SESSION['stuTel']);
    unset($_SESSION['stuEmail']);
    unset($_SESSION['clubsNum']);

    header( 'Location: index.php' ) ;
    return;
}

    // Prints flash message on top of the form if have error message
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }

    //Set session to make the values retain on each inputs
    $stuName = isset($_SESSION['stuName']) ? $_SESSION['stuName'] : '';
    $stuClass = isset($_SESSION['stuClass']) ? $_SESSION['stuClass'] : '';
    $stuTel = isset($_SESSION['stuTel']) ? $_SESSION['stuTel'] : '';
    $stuEmail = isset($_SESSION['stuEmail']) ? $_SESSION['stuEmail'] : '';
    $clubsNum = isset($_SESSION['clubsNum']) ? $_SESSION['clubsNum'] : '';


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
      <h1 class="textGreen" style="margin-top: 0px;"><b>Add a New Student</b></h1>
      <hr style="width:50px;border:5px solid #54C571" class="round">
      <form method="post">
        <div class="section">
          <label>Name</label>
          <input class="formInput" type="text" name="stuName" required
          <?php
            echo 'value = "' . htmlentities($stuName) . '"';
          ?>
          />
        </div>
        <div class="section">
          <label>Class</label>
          <input class="formInput" type="text" name="stuClass" required
          <?php
            echo 'value = "' . htmlentities($stuClass) . '"';
          ?>
          />
        </div>
        <div class="section">
          <label>Telephone</label>
          <input class="formInput" type="text" name="stuTel" required
          <?php
            echo 'value = "' . htmlentities($stuTel) . '"';
          ?>
          />
        </div>
        <div class="section">
          <label>Email</label>
          <input class="formInput" type="text" name="stuEmail" required
          <?php
            echo 'value = "' . htmlentities($stuEmail) . '"';
          ?>
          />
        </div>
        <div class="section">
          <label>Club Number</label>
          <input class="formInput" type="text" name="clubsNum" required
          <?php
            echo 'value = "' . htmlentities($clubsNum) . '"';
          ?>
          />
        </div>
        <button type="submit" class="formBtn" style="font-family: Georgia, sans-serif;">Add New</button>
        <a href="index.php" style="margin-left: 10px; text-decoration: none;">Cancel</a>
      </form>
    </div>

</body>
</html>
