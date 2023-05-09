<?php
  include'../private/dbconnect.php';
  session_start();

  try {
    if ($_POST['firstname'] == '' || $_POST['lastname'] == '' || $_POST['role'] == '' || $_POST['role'] == '2' || $_POST['school'] == '0' || $_POST['email'] == '' || $_POST['password'] == '') {
      $_SESSION['error'] = "vul ff iets in";
      header("location: ../index.php?page=adduser");
    } elseif (checkForIllegalCharacters($_POST['firstname']) || checkForIllegalCharacters($_POST['lastname']) || checkForIllegalCharacters($_POST['email']) || checkForIllegalCharacters($_POST['password'])) {
      $_SESSION['error'] = "illegal character used";
      header("location: ../index.php?page=adduser");
    } else {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $sql = "INSERT INTO users (`schoolid`, `firstname`, `lastname`, `email`, `password`, `role`, `createdby`, `updatedby`)
              VALUES (:schoolid, :firstname, :lastname, :email, :password, :role, :createdby, :updatedby)";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':schoolid', $_POST['school']);
      $sth->bindParam(':firstname', $_POST['firstname']);
      $sth->bindParam(':lastname', $_POST['lastname']);
      $sth->bindParam(':role', $_POST['role']);
      $sth->bindParam(':email', $_POST['email']);
      $sth->bindParam(':password', $password);
      $sth->bindParam(':createdby', $_SESSION['userid']);
      $sth->bindParam(':updatedby', $_SESSION['userid']);
      $sth->execute();

      $lastInsertedId = $conn->lastInsertId();

      if ($lastInsertedId) {
        try {
          $selectedGroepen = $_POST['groepen'];

          foreach ($selectedGroepen as $groep) {
            $sql = "INSERT INTO `linkgroups` (`userid`, `groupid`) VALUES (:userid, :groupid)";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':userid', $lastInsertedId);
            $sth->bindParam(':groupid', $groep);
            $sth->execute();
          }
        } catch (\Exception $e) {
          $_SESSION['error'] = 'kon geen groepen koppelen. Pech';
          header('location: ../index.php?page=userlijst');
        }

        $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '1', '6', :interactionid)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':userid', $_SESSION['userid']);
        $sth->bindParam(':useragent', $_SESSION['useragent']);
        $sth->bindParam(':interactionid', $lastInsertedId);
        $sth->execute();

        $_SESSION['info'] = 'user toegevoegt';
        header('location: ../index.php?page=userlijst');
      } else {
        $_SESSION['error'] = 'er ging iets mis. Pech';
        header('location: ../index.php?page=userlijst');
      }
    }
  } catch (\Exception $e) {
    $_SESSION['error'] = "er ging iets mis. Pech";
    header("location: ../index.php?page=userlijst");
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
