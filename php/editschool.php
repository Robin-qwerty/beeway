<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrole']) && ($_SESSION['userrole'] === 'superuser' || $_SESSION['userrole'] === 'admin')) {
    // User has the necessary privileges
  } else {
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }

  try {
    if ($_POST['schoolname'] == '') {
      $_SESSION['error'] = "vul ff iets in";
      header("location: ../index.php?page=edituser&userid=".$_GET['userid']);
    } elseif (checkForIllegalCharacters($_POST['schoolname'])) {
      $_SESSION['error'] = "illegal character used";
      header("location: ../index.php?page=edituser&userid=".$_GET['userid']);
    } else {
      $timestamp = time();
      $date_time = date('Y-m-d H:i:s', $timestamp);

      $sql = "UPDATE schools SET schoolname=:schoolname, updatedby=:updatedby, updatedat=:updatedat
              WHERE schoolid=:schoolid";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':schoolname', $_POST['schoolname']);
      $sth->bindParam(':updatedby', $_SESSION['userid']);
      $sth->bindParam(':updatedat', $date_time);
      $sth->bindParam(':schoolid', $_GET['schoolid']);
      $sth->execute();

      if ($sth->rowCount() > 0) {
        $sql1 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '2', '5', :interactionid)";
        $sth1 = $conn->prepare($sql1);
        $sth1->bindParam(':userid', $_SESSION['userid']);
        $sth1->bindParam(':useragent', $_SESSION['useragent']);
        $sth1->bindParam(':interactionid', $_GET['schoolid']);
        $sth1->execute();

        $_SESSION['info'] = 'school aangepast';
        header('location: ../index.php?page=scholenlijst');
      } else {
        $_SESSION['error'] = "er ging iets mis. Pech";
        header("location: ../index.php?page=scholenlijst");
      }
    }
  } catch (\Exception $e) {
    $_SESSION['error'] = "er ging iets mis. Pech";
    header("location: ../index.php?page=scholenlijst");
  }

  function checkForIllegalCharacters($str) { // check for iliegal characters
    $illegalChars = array('<', '>', '{', '}', '(', ')', '[', ']', '*', '$', '^', '`', '~', '|', '\\', '\'', '"', ':', ';', ',', '/');
    foreach ($illegalChars as $char) {
      if (strpos($str, $char) !== false) {
        return true;
      }
    }
    return false;
  }
?>
