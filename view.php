<?php
session_start();
require_once 'pdo.php';

if(!isset($_SESSION['email'])){
  die ("Not logged in");
}

if (isset($_POST['cancel'])){
  header('Location: index.php');
  return;
}


if ( ! isset($_GET['id']) ) {
  $_SESSION['failmessage'] = "Missing user_id";
  header('Location: index.php');
  return;
}
$stmt = $pdo->prepare('SELECT first_name, last_name, email, headline, summary  FROM Profile WHERE profile_id = :pid');
$stmt->execute(array(':pid' => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['failmessage'] = 'Could not load profile';
    header( 'Location: index.php' ) ;
    return;
}

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
  <h1>Profile information</h1>

<p>First name: <b> <?php echo(htmlentities($row['first_name'])); ?> </b></p>
<p>Last name: <b> <?php echo(htmlentities($row['last_name'])); ?> </b></p>
<p>Headline: <b> <?php echo(htmlentities($row['email'])); ?> </b></p>
<p>Email: <b> <?php echo(htmlentities($row['headline'])); ?> </b></p>
<p>Summary: <b> <?php echo(htmlentities($row['summary'])); ?> </b></p>


<a href="index.php">Done</a>

</div>
</body>
</html>
