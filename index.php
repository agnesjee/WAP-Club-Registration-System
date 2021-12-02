<?php
require_once "pdo.php";
session_start();
 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link type="text/css" rel="stylesheet" href="css.css"/>
 </head>
 <body>

   <?php
      if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
      }
      if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
      }
    ?>

   <h2>Student List</h2>

   <table>
   	<tr>
   	<th style = "background-color: #54C571; color: #FFFFFF; text-align: center;">Student Number</th>
   	<th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Student Name</th>
   	<th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Student Class</th>
   	<th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Student Telephone</th>
     <th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Student Email</th>
     <th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Student Clubs Number</th>
     <th style = "background-color: #54C571; color: #FFFFFF; text-align: center; font-weight: bold">Modify or Delete Data</th>
   	</tr>

   <?php

   //To display all the student data in table form
   $stmt = $pdo->query("SELECT student.Stu_Num, student.Stu_Name, student.Stu_Class, student.Stu_Tel, student.Stu_Email, clubs.Clubs_Name
                        FROM student
                        INNER JOIN clubs ON student.Clubs_Num = clubs.Clubs_Num; ");
   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

   foreach ($rows as $row){
   echo ("<tr><td>");
   echo ($row['Stu_Num']);
   echo ("</td><td>");
   echo ($row['Stu_Name']);
   echo ("</td><td>");
   echo ($row['Stu_Class']);
   echo ("</td><td>");
   echo ($row['Stu_Tel']);
   echo ("</td><td>");
   echo ($row['Stu_Email']);
   echo ("</td><td>");
   echo ($row['Clubs_Name']);
   echo ("</td><td>");
   echo('<a style="text-decoration: none;" href="modify.php?Stu_Num='.$row['Stu_Num'].'">Modify</a> / ');
   echo('<a style="text-decoration: none;" href="delete.php?Stu_Num='.$row['Stu_Num'].'">Delete</a>');
   echo ("</td></tr>\n");
   }

   ?>

   </table>
   <br/>

   <a style="text-decoration: none;" href="add.php">Add New</a>


 </body>
 </html>
