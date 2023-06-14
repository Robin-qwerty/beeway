<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrole']) && ($_SESSION['userrole'] === 'superuser' || $_SESSION['userrole'] === 'admin')) {
    try {
      if ($_POST['groups'] == '' ) {
        $_SESSION['error'] = "vul ff iets in";
        header("Location: ../index.php?page=addgroups");
      } elseif (checkForIllegalCharacters($_POST['groups'])) {
        $_SESSION['error'] = "illegal character used";
        header("Location: ../index.php?page=addgroups");
      } else {

        $sql = "select schoolid from users WHERE userid=:userid";
        $sth1 = $conn->prepare($sql);
        $sth1->bindParam(':userid', $_SESSION['userid']);
        $sth1->execute();

       while ($school = $sth1->fetch(PDO::FETCH_OBJ)) {
        $sql = "INSERT INTO groups (`groups`, `schoolid`, `createdby`, `updatedby`)
                VALUES (:groups, :schoolid, :createdby, :updatedby)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':groups', $_POST['groups']);
        $sth->bindParam(':schoolid', $school->schoolid);
        $sth->bindParam(':createdby', $_SESSION['userid']);
        $sth->bindParam(':updatedby', $_SESSION['userid']);
        $sth->execute();

        $groupid = $conn->lastInsertId();

        $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '1', '3', :interactionid)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':userid', $_SESSION['userid']);
        $sth->bindParam(':useragent', $_SESSION['useragent']);
        $sth->bindParam(':interactionid', $groupid);
        $sth->execute();

        $_SESSION['info'] = "added successful";
        header("Location: ../index.php?page=klassenlijst");
        }
      }
    } catch (\Exception $e) {
      $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 1, 3, 0, 5)';
      $sth = $conn->prepare($sql);
      $sth->bindValue(':useragent', $_SESSION['useragent']);
      $sth->execute();

      $_SESSION['error'] = "er ging iets mis. Pech";
      header("Location: ../index.php?page=addgroups");
    }
  } else {
    $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 1, 3, 0, 1)';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':useragent', $_SESSION['useragent']);
    $sth->execute();

    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
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
