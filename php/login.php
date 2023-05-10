<?php
  // Include the database connection file
  require_once '../private/dbconnect.php';

  // Start the session
  session_start();

  try {
    // Validate the input fields
    if (empty($_POST['email']) || empty($_POST['password']) || $_POST['school'] == '') {
      $_SESSION['error'] = 'Please fill in all fields.';
      header('Location: ../index.php?page=login');
      exit();
    }

    // Check for illegal characters in the input fields
    if (checkForIllegalCharacters($_POST['email']) || checkForIllegalCharacters($_POST['password'])) {
      $_SESSION['error'] = 'Illegal characters used.';
      header('Location: ../index.php?page=login');
      exit();
    }

    // Get the user from the database
    $sql = 'SELECT role, userid, password FROM users WHERE email=:email AND schoolid=:schoolid AND archive <> 1';
    $sth = $conn->prepare($sql);
    $sth->bindParam(':email', $_POST['email']);
    $sth->bindParam(':schoolid', $_POST['school']);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_OBJ);

    // Log the login attempt
    if ($user) {
      $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid) VALUES (:userid, :useragent, 4, 6, :interactionid)';
      $sth = $conn->prepare($sql);
      $sth->bindParam(':userid', $user->userid);
      $sth->bindParam(':useragent', $_SESSION['useragent']);
      $sth->bindParam(':interactionid', $user->userid);
      $sth->execute();
    }

    // Check if the user exists and the password is correct
    if (!$user || !password_verify($_POST['password'], $user->password)) {
      $_SESSION['school'] = $_POST['school'];
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['error'] = 'Invalid email or password. Please try again.';
      header('Location: ../index.php?page=login');
      exit();
    }

    // Set the session variables based on the user role
    if ($user->role == 2) {
      $_SESSION['userrol'] = 'superuser';
    } elseif ($user->role == 1) {
      $_SESSION['userrol'] = 'admin';
    } else {
      $_SESSION['userrol'] = 'docent';
    }

    $_SESSION['userid'] = $user->userid;
    header('Location: ../index.php?page=dashboard');
    exit();
  } catch (\Exception $e) {
    $_SESSION['school'] = $_POST['school'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['error'] = "er ging iets mis. Pech";
    header("location: ../index.php?page=login");
  }

  // Check for illegal characters in a string
  function checkForIllegalCharacters($str) {
    $illegalChars = array('<', '>', '{', '}', '(', ')', '[', ']', '*', '$', '`', '|', '\\', '\'', '"', ':', ';', ',', '/');
    foreach ($illegalChars as $char) {
      if (strpos($str, $char) !== false) {
        return true;
      }
    }
    return false;
  }

?>
