<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrole']) && ($_SESSION['userrole'] === 'superuser' || $_SESSION['userrole'] === 'admin')) {
    try {
      // Check if the user is an admin
      if (!isset($_SESSION['userid'], $_SESSION['userrole']) || $_SESSION['userrole'] !== 'admin') {
        $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
        header('location: ../index.php?page=dashboard');
        exit;
      }

      // Retrieve schoolid from the database based on userid
      $sql = "SELECT schoolid FROM users WHERE userid = :userid";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':userid', $_SESSION['userid']);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);

      if ($result === false) {
        $sql = 'INSERT INTO logs (userid, useragent, action, info, tableid, interactionid, error) VALUES ("9999", :useragent, 1, "userid not found", 2, 0, 5)';
        $sth = $conn->prepare($sql);
        $sth->bindValue(':useragent', $_SESSION['useragent']);
        $sth->execute();

        $_SESSION['error'] = "Unable to fetch user's schoolid.";
        header("location: ../index.php?page=adddiscipline");
        exit;
      }

      $schoolid = $result['schoolid'];

      // Proceed with the rest of the code
      if ($_POST['disciplinename'] == '') {
        $_SESSION['error'] = "Please fill in the discipline name.";
        header("location: ../index.php?page=adddiscipline");
      } elseif (checkForIllegalCharacters($_POST['disciplinename'])) {
        $_SESSION['error'] = "Illegal character used.";
        header("location: ../index.php?page=adddiscipline");
      } else {
        $sql = "INSERT INTO disciplines (`schoolid`, `disciplinename`, `createdby`, `updatedby`)
                VALUES (:schoolid, :disciplinename, :createdby, :updatedby)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':schoolid', $schoolid); // Use the retrieved schoolid
        $sth->bindParam(':disciplinename', $_POST['disciplinename']);
        $sth->bindParam(':createdby', $_SESSION['userid']);
        $sth->bindParam(':updatedby', $_SESSION['userid']);
        $sth->execute();

        $disciplineid = $conn->lastInsertId();

        $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '1', '2', :interactionid)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':userid', $_SESSION['userid']);
        $sth->bindParam(':useragent', $_SESSION['useragent']);
        $sth->bindParam(':interactionid', $disciplineid);
        $sth->execute();

        $_SESSION['info'] = "Discipline added successfully.";
        header("location: ../index.php?page=vakkenlijst");
      }
    } catch (\Exception $e) {
      $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 1, 4, 0, 5)';
      $sth = $conn->prepare($sql);
      $sth->bindValue(':useragent', $_SESSION['useragent']);
      $sth->execute();

      $_SESSION['error'] = "er ging iets mis. Pech.";
      header("location: ../index.php?page=adddiscipline");
      exit;
    }
  } else {
    $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 6, 6, 0, 1)';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':useragent', $_SESSION['useragent']);
    $sth->execute();
    
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }

  function checkForIllegalCharacters($str) { // check for illegal characters
    $illegalChars = array('<', '>', '{', '}', '(', ')', '[', ']', '*', '$', '^', '`', '~', '|', '\\', '\'', '"', ':', ';', ',', '/');
    foreach ($illegalChars as $char) {
      if (strpos($str, $char) !== false) {
        return true;
      }
    }
    return false;
  }
?>
