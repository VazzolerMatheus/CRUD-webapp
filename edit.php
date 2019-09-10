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


if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) &&  isset($_POST['summary']) && isset($_POST['id'])) {

  if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
    $_SESSION['failmessage'] = 'All fields are required';
    header('Location: edit.php?id='.$_POST['id']);
    return;

  } elseif (strpos($_POST['email'], '@') === false) {
    $_SESSION['failmessage'] = 'Email address must contain @';
    header('Location: edit.php?id='.$_POST['id']);
    return;

  } else {
    $stmt = $pdo->prepare('UPDATE Profile
                          SET user_id = :uid, first_name = :fn, last_name = :ln, email = :em, headline = :hl, summary = :sm
                            WHERE profile_id = :pid');
    $stmt->execute(array(
      ':pid' => $_POST['id'],
      ':uid' => $_SESSION['user_id'],
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':hl' => $_POST['headline'],
      ':sm' => $_POST['summary']
    ));

    $_SESSION['successmessage'] = 'Profile updated';
    header('Location: index.php');
    return;
  }
}


$view = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
$view->execute(array(':pid' => $_GET['id'] ));
$row = $view->fetch(PDO::FETCH_ASSOC);

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
<h1>Editing Profile for <?php echo($_SESSION['email']); ?></h1>

  <!-- FLASH message -->
<?php
if(isset($_SESSION['failmessage'])){
  echo('<p style="color:red">'.$_SESSION['failmessage'].'</p>');
  unset($_SESSION['failmessage']);
}
 ?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60" value="<?php echo (htmlentities($row['first_name']) ); ?>"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60" value="<?php echo (htmlentities($row['last_name']) ); ?>"/></p>
<p>Email:
<input type="text" name="email" size="30" value="<?php echo (htmlentities($row['email']) ); ?>"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80" value="<?php echo (htmlentities($row['headline']) ); ?>"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"><?php echo (htmlentities($row['summary']) ); ?></textarea>
<p>

<input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>"/>
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
