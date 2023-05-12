<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrol']) && ($_SESSION['userrol'] === 'superuser' || $_SESSION['userrol'] === 'admin')) {
    // User has the necessary privileges
  } else {
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }

  try {
    $sql = "UPDATE users SET 
            WHERE userid=:userid";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':schoolid', $_POST['school']);
    $sth->bindParam(':firstname', $_POST['firstname']);
    $sth->bindParam(':lastname', $_POST['lastname']);
    $sth->bindParam(':email', $_POST['email']);
    $sth->bindParam(':password', $password);
    $sth->bindParam(':updatedby', $_SESSION['userid']);
    $sth->bindParam(':userid', $_GET['userid']);
    $sth->execute();
  } catch (\Exception $e) {
    $_SESSION['error'] = 'er ging iets mis, pech.';
    header("location: ../index.php?page=edituser&userid=".$_GET['userid']);
    exit;
  }



?>
