<?php
  // Include the database connection file
  require_once '../private/dbconnect.php';

  // Start the session
  session_start();

  // Check if all required fields are filled in
  if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['role'])
      || $_POST['role'] == '2' || $_POST['school'] == '0' || empty($_POST['email']) || empty($_POST['password'])) {
      $_SESSION['error'] = 'Please fill in all required fields';
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      $_SESSION['email'] = $_POST['email'];
      header('Location: ../index.php?page=adduser');
      exit;
  }

  // Check for illegal characters in user input
  if (strpbrk($_POST['firstname'] . $_POST['lastname'] . $_POST['email'] . $_POST['password'], '<>{()}[]*$^`~|\\\'":;,/')) {
      $_SESSION['error'] = 'Illegal character used';
      header('Location: ../index.php?page=adduser');
      exit;
  }

  // Insert user into database
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
              $sql = "INSERT INTO `linkgroups` (`userid`, `groupid`) VALUES (?, ?)";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$userId, $groupId]);
          }

          $conn->commit();

          $_SESSION['info'] = 'User added';
          header('Location: ../index.php?page=userlijst');
          exit;
      } else {
          throw new Exception('Failed to insert user into database');
      }
  } catch (Exception $e) {
      $conn->rollback();

      $_SESSION['error'] = 'Failed to add user';
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      $_SESSION['email'] = $_POST['email'];
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
