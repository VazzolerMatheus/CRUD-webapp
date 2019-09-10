<?php
session_start();
require_once 'pdo.php';

$stmt = $pdo->prepare('SELECT profile_id, user_id, first_name, last_name , headline FROM Profile');
$stmt->execute();

?>

<!DOCTYPE html>
<html>
<head>
<title>Matheus Kitamukai Vazzoler</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Matheus Kitamukai Vazzoler</h1>

    <!-- FLASH message -->
<?php
  if(isset($_SESSION['successmessage'])){
    echo('<p style="color:green">'.$_SESSION['successmessage'].'</p>');
    unset($_SESSION['successmessage']);
  }

  if(isset($_SESSION['failmessage'])){
    echo('<p style="color:red">'.$_SESSION['failmessage'].'</p>');
    unset($_SESSION['failmessage']);
  }
 ?>
<?php

if (isset($_SESSION['email'])){
  echo(
    '<a href="logout.php">Logout</a>'
  );

} else {
  echo(
    '<p><a href="login.php">Please log in</a></p>
  ');
}

echo('<table border="1">');
echo('
<tr>
<th>Name</th>
<th>Headline</th>
');
//If the user is logged in, we will be able to see the Action row
  if(isset($_SESSION['email'])){
    echo('<th>Action</th>');
  }
echo('</tr>');


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo('<tr>');
  echo('<td> <a href="view.php?id='.htmlentities($row['profile_id']).'">'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'</a> </td>');
  echo('<td>'.htmlentities($row['headline']).'</td>');

  if(isset($_SESSION['email'])){
    echo('<td> <a href="edit.php?id='.htmlentities($row['profile_id']).'">Edit</a>');
    echo(' ');
    echo('<a href="delete.php?id='.htmlentities($row['profile_id']).'">Delete</a></td>');

  }
}

echo("</tr>\n");
echo("</table>\n");?>

<?php if(isset($_SESSION['email'])){ print('<p><a href="add.php">Add New Entry</a></p>'); }?>

</div>
</body>
