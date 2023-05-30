<?php
  require_once '../private/dbconnect.php';
  session_start();

  // Check user privileges
  if (!(isset($_SESSION['userid'], $_SESSION['userrol']) && ($_SESSION['userrol'] === 'superuser' || $_SESSION['userrol'] === 'admin'))) {
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }

  // Check if all required fields are filled in
  $requiredFields = ['firstname', 'lastname', 'role', 'school', 'email', 'password'];
  foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
      $_SESSION['school'] = $_POST['school'];
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['error'] = 'Please fill in all required fields';
      header('Location: ../index.php?page=adduser');
      exit;
    }
  }

  // Check for illegal characters in user input
  $illegalCharacters = ['<', '>', '{', '}', '(', ')', '[', ']', '*', '$', '^', '`', '~', '|', '\\', '\'', '"', ':', ';', ',', '/'];
  $inputFields = ['firstname', 'lastname', 'email', 'password'];
  foreach ($inputFields as $field) {
    if (strpbrk($_POST[$field], implode('', $illegalCharacters))) {
      $_SESSION['error'] = 'Illegal character used';
      header('Location: ../index.php?page=adduser');
      exit;
    }
  }

  try {
    $conn->beginTransaction();

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (`schoolid`, `firstname`, `lastname`, `email`, `password`, `role`, `createdby`, `updatedby`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['school'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $password, $_POST['role'], $_SESSION['userid'], $_SESSION['userid']]);

    $userId = $conn->lastInsertId();

    // Insert user into selected groups
    if ($userId) {
      $selectedGroups = $_POST['groepen'];

      foreach ($selectedGroups as $groupId) {
        $sql = "INSERT INTO `linkgroups` (`userid`, `groupid`)
                VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $groupId]);
      }

      $sql2 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`)
              VALUES (:userid, :useragent, '1', '6', :interactionid)";
      $sth2 = $conn->prepare($sql2);
      $sth2->bindParam(':userid', $_SESSION['userid']);
      $sth2->bindParam(':useragent', $_SESSION['useragent']);
      $sth2->bindParam(':interactionid', $userId);
      $sth2->execute();

      $conn->commit();

      $_SESSION['info'] = 'User added';
      header('Location: ../index.php?page=userlijst');
      exit;
    } else {
      throw new Exception('Failed to insert user into database');
    }
  } catch (Exception $e) {
    $conn->rollback();

    $_SESSION['school'] = $_POST['school'];
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['error'] = 'Failed to add user';
    header('Location: ../index.php?page=adduser');
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
