<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrol'])) {
    // User has the necessary privileges
  } else {
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }

  // Check if all required fields are filled in
  if (empty($_POST['beewaynaam']) || empty($_POST['groepen']) || empty($_POST['hoofdthemaid']) || empty($_POST['vakgebiedid'])) {
    // If the school name field is empty, redirect back to the add user page with an error message
    $_SESSION['schoolnaam'] = $_POST['schoolnaam'];
    $_SESSION['error'] = 'Please fill in all required fields ';
    header('Location: ../index.php?page=addbeeway');
    exit;
  }

  // Check for illegal characters in user input
  if (strpbrk($_POST['beewaynaam'], '<>{}[]$^`:;/')) {
    // If illegal characters are found in the school name, redirect back to the add user page with an error message
    $_SESSION['error'] = 'Illegal character used';
    header('Location: ../index.php?page=addbeeway');
    exit;
  }

  // Insert school into database
  // try {
    $sql = 'SELECT schoolid
         FROM users
         WHERE schoolid <> "0"
         AND archive <> "1"
         AND userid = :userid';

    $sth = $conn->prepare($sql);
    $sth->bindValue(':userid', $_SESSION['userid']);
    $sth->execute();

    $result = $sth->fetch(); // Fetch the result from the executed query
    $schoolid = $result['schoolid']; // Access the schoolid value from the result array

    if ($schoolid) {
      // Begin a transaction to ensure the database is consistent if there is an error
      if (isset($_POST['concreetdoel'])) {$concreetdoel = $_POST['concreetdoel'];} else {$concreetdoel == '';}
      if (isset($_POST['begoed'])) {$begoed = $_POST['begoed'];} else {$begoed == '';}
      if (isset($_POST['bevoldoende'])) {$bevoldoende = $_POST['bevoldoende'];} else {$bevoldoende == '';}
      if (isset($_POST['beonvoldoende'])) {$beonvoldoende = $_POST['beonvoldoende'];} else {$beonvoldoende == '';}

      $groepen = $_POST['groepen'];
      $beewaynaam = $_POST['beewaynaam'];
      $hoofdthemaid = $_POST['hoofdthemaid'];
      $vakgebiedid = $_POST['vakgebiedid'];

      $conn->beginTransaction();

      $sql = "INSERT INTO beeway (`schoolid`, `groupid`, `beewayname`, `begood`, `beenough`, `benotgood`, `mainthemeid`, `themeperiodid`, `disciplineid`, `concretegoal`, `createdby`, `updatedby`)
              VALUES (:schoolid, :groupid, :beewayname, :begoed, :bevoldoende, :beonvoldoende, 1, :mainthemeid, :disciplineid, :concreetdoel, :createdby, :updatedby)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':schoolid', $schoolid);
      $stmt->bindValue(':groupid', $groepen);
      $stmt->bindValue(':beewayname', $beewaynaam);
      $stmt->bindValue(':begoed', $begoed);
      $stmt->bindValue(':bevoldoende', $bevoldoende);
      $stmt->bindValue(':beonvoldoende', $beonvoldoende);
      $stmt->bindValue(':mainthemeid', $hoofdthemaid);
      $stmt->bindValue(':disciplineid', $vakgebiedid);
      $stmt->bindValue(':concreetdoel', $concreetdoel);
      $stmt->bindValue(':createdby', $_SESSION['userid']);
      $stmt->bindValue(':updatedby', $_SESSION['userid']);
      $stmt->execute();

      // Get the ID of the newly inserted school
      // $schoolid = $conn->lastInsertId();

      // Insert a school admin user into the database
      // if ($schoolid) {
      //   $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '1', '5', :interactionid)";
      //   $sth = $conn->prepare($sql);
      //   $sth->bindParam(':userid', $_SESSION['userid']);
      //   $sth->bindParam(':useragent', $_SESSION['useragent']);
      //   $sth->bindParam(':interactionid', $schoolid);
      //   $sth->execute();
      //
      //   if (isset($_POST['schooladmin']) == 1) {
      //     // Create a temporary password for the school admin user
      //     $schooladminpassword = $_POST['schoolname'] . '2023!';
      //     // Hash the password
      //     $password = password_hash($schooladminpassword, PASSWORD_DEFAULT);
      //
      //     // Prepare an SQL statement to insert the user into the users table
      //     $sql2 = "INSERT INTO users (`schoolid`, `firstname`, `lastname`, `email`, `password`, `role`, `createdby`, `updatedby`)
      //             VALUES (?, 'schooladmin', 'one', ?, ?, '1', ?, ?)";
      //     $stmt2 = $conn->prepare($sql2);
      //     $stmt2->execute([$schoolid, $_POST['schoolname'], $password, $_SESSION['userid'], $_SESSION['userid']]);
      //
      //     $userId = $conn->lastInsertId();
      //
      //     $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '1', '6', :interactionid)";
      //     $sth = $conn->prepare($sql);
      //     $sth->bindParam(':userid', $_SESSION['userid']);
      //     $sth->bindParam(':useragent', $_SESSION['useragent']);
      //     $sth->bindParam(':interactionid', $userId);
      //     $sth->execute();
      //
          // Commit the transaction
          $conn->commit();
      //
      //     // Redirect to the school list page with a success message
      //     $_SESSION['info'] = 'School and user added successfully';
      //     header('Location: ../index.php?page=scholenlijst');
      //     exit;
      //   } else {
      //     // Commit the transaction
      //     $conn->commit();
      //
      //     // Redirect to the school list page with a success message
      //     $_SESSION['info'] = 'School added successfully';
      //     header('Location: ../index.php?page=scholenlijst');
      //     exit;
      //   }
      // } else {
      //   // If the school ID cannot be retrieved, throw an exception
      //   throw new Exception('Failed to insert user into database');
      // }
    } else {
      echo "string";
    }
  // } catch (Exception $e) {
  //   // If there is an error, rollback the transaction and redirect back to the add user page with an error message
  //   $conn->rollback();
  //
  //   $_SESSION['schoolnaam'] = $_POST['schoolnaam'];
  //   $_SESSION['error'] = 'Failed to add beeway';
  //   header('Location: ../index.php?page=beewaylijst');
  //   exit;
  // }

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
