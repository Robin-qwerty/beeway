<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid'], $_SESSION['userrole']) && ($_SESSION['userrole'] === 'superuser')) {
    // Check if all required fields are filled in
    if (empty($_POST['schoolname'])) {
      // If the school name field is empty, redirect back to the add user page with an error message
      $_SESSION['schoolname'] = $_POST['schoolname'];
      $_SESSION['error'] = 'Please fill in all required fields';
      header('Location: ../index.php?page=addschool');
      exit;
    }

    // Check for illegal characters in user input
    if (strpbrk($_POST['schoolname'], '<>{()}[]*$^`~|\\\'":;,/')) {
      // If illegal characters are found in the school name, redirect back to the add user page with an error message
      $_SESSION['error'] = 'Illegal character used';
      header('Location: ../index.php?page=addschool');
      exit;
    }

    // Insert school into database
    try {
      // Begin a transaction to ensure the database is consistent if there is an error
      $conn->beginTransaction();

      // Prepare an SQL statement to insert the school into the schools table
      $sql = "INSERT INTO schools (`schoolname`, `createdby`, `updatedby`)
              VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$_POST['schoolname'], $_SESSION['userid'], $_SESSION['userid']]);

      // Get the ID of the newly inserted school
      $schoolid = $conn->lastInsertId();

      // Insert a school admin user into the database
      if ($schoolid) {
        $sql1 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `info`, `tableid`, `interactionid`)
                VALUES (:userid, :useragent, '1', 'school created', '5', :interactionid)";
        $sth1 = $conn->prepare($sql1);
        $sth1->bindParam(':userid', $_SESSION['userid']);
        $sth1->bindParam(':useragent', $_SESSION['useragent']);
        $sth1->bindParam(':interactionid', $schoolid);
        $sth1->execute();

        if (isset($_POST['schooladmin']) and $_POST['schooladmin'] == 1) {
          // Create a temporary password for the school admin user
          $schoolname = $_POST['schoolname'];
          $schoolname = str_replace(' ', '', $schoolname); // remove spaces from schoolname

          $schooladminpassword = $schoolname . '2023!';

          // echo $schooladminpassword;
          // Hash the password
          $password = password_hash($schooladminpassword, PASSWORD_DEFAULT);

          // Prepare an SQL statement to insert the user into the users table
          $sql2 = "INSERT INTO users (`schoolid`, `firstname`, `lastname`, `email`, `password`, `role`, `createdby`, `updatedby`)
                  VALUES (?, 'schooladmin', 'one', ?, ?, '1', ?, ?)";
          $stmt2 = $conn->prepare($sql2);
          $stmt2->execute([$schoolid, $_POST['schoolname'], $password, $_SESSION['userid'], $_SESSION['userid']]);

          $userId = $conn->lastInsertId();

          $sql3 = "INSERT INTO `logs` (`userid`, `useragent`, `info`, `action`, `tableid`, `interactionid`)
          VALUES (:userid, :useragent, CONCAT('User added for new school ', :schoolid), '1', '6', :interactionid)";
          $sth3 = $conn->prepare($sql3);
          $sth3->bindParam(':userid', $_SESSION['userid']);
          $sth3->bindParam(':useragent', $_SESSION['useragent']);
          $sth3->bindParam(':schoolid', $schoolid);
          $sth3->bindParam(':interactionid', $userId);
          $sth3->execute();

          // Commit the transaction
          $conn->commit();

          // Redirect to the school list page with a success message
          $_SESSION['info'] = 'School and user added successfully';
          header('Location: ../index.php?page=scholenlijst');
          exit;
        } else {
          // Commit the transaction
          $conn->commit();

          // Redirect to the school list page with a success message
          $_SESSION['info'] = 'School added successfully';
          header('Location: ../index.php?page=scholenlijst');
          exit;
        }
      } else {
        // If the school ID cannot be retrieved, throw an exception
        throw new Exception('Failed to insert user into database');
      }
    } catch (Exception $e) {
      // If there is an error, rollback the transaction and redirect back to the add user page with an error message
      $conn->rollback();

      $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 1, 5, 0, 5)';
      $sth = $conn->prepare($sql);
      $sth->bindValue(':useragent', $_SESSION['useragent']);
      $sth->execute();

      $_SESSION['schoolname'] = $_POST['schoolname'];
      $_SESSION['error'] = 'Failed to add school';
      header('Location: ../index.php?page=addschool');
      exit;
    }
  } else {
    $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 1, 5, 0, 1)';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':useragent', $_SESSION['useragent']);
    $sth->execute();

    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=dashboard');
    exit;
  }
?>
