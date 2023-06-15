<?php
  require_once '../private/dbconnect.php';
  session_start();

  try {
    $sql = 'SELECT schoolid
             FROM users
             WHERE schoolid <> 0
             AND archive <> 1
             AND userid = :userid';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':userid', $_SESSION['userid']);
    $sth->execute();

    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
      $schoolid = $result['schoolid'];

      // Retrieve the data from the first form (form0)
      $beewaynaam = $_POST['beewaynaam'];
      $groepen = $_POST['groepen'];
      $hoofdthemaid = $_POST['hoofdthemaid'];
      $concreetdoel = $_POST['concreetdoel'];
      $begoed = $_POST['begoed'];
      $bevoldoende = $_POST['bevoldoende'];
      $beonvoldoende = $_POST['beonvoldoende'];
      $vakgebiedid = $_POST['vakgebiedid'];

      // Insert the data into the `beeway` table
      $sql = 'INSERT INTO beeway (schoolid, groupid, beewayname, begood, beenough, benotgood, mainthemeid, concretegoal, disciplineid)
              VALUES (:schoolid, :groupid, :beewayname, :begood, :beenough, :benotgood, :mainthemeid, :concretegoal, :disciplineid)';
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':schoolid', $schoolid);
      $stmt->bindParam(':groupid', $groepen);
      $stmt->bindParam(':beewayname', $beewaynaam);
      $stmt->bindParam(':begood', $begoed);
      $stmt->bindParam(':beenough', $bevoldoende);
      $stmt->bindParam(':benotgood', $beonvoldoende);
      $stmt->bindParam(':mainthemeid', $hoofdthemaid);
      $stmt->bindParam(':concretegoal', $concreetdoel);
      $stmt->bindParam(':disciplineid', $vakgebiedid);
      $stmt->execute();

      // Get the last inserted ID
      $beewayid = $conn->lastInsertId();

      // Handle the second form data (planning and observation)
      if (isset($_POST['planning']) && isset($_POST['observation'])) {
        // Prepare the SQL statement for inserting planning data
        $planningSql = 'INSERT INTO beewayplanning (beewayid, planning, planningwhat, planningwho, planningdeadline, planningdone)
                        VALUES (:beewayid, :planning, :planningwhat, :planningwho, :planningdeadline, :planningdone)';
        $planningStmt = $conn->prepare($planningSql);

        // Prepare the SQL statement for inserting observation data
        $observationSql = 'INSERT INTO beewayobservation (beewayid, dataclass, learninggoal, evaluation, workgoal, action)
                           VALUES (:beewayid, :dataclass, :learninggoal, :evaluation, :workgoal, :action)';
        $observationStmt = $conn->prepare($observationSql);

        // Iterate through the planning data and execute the SQL statement for each row
        foreach ($_POST['planning'] as $planning) {
          $planningStmt->bindParam(':beewayid', $beewayid);
          $planningStmt->bindParam(':planning', $planning['planning']);
          $planningStmt->bindParam(':planningwhat', $planning['planningwhat']);
          $planningStmt->bindParam(':planningwho', $planning['planningwho']);
          $planningStmt->bindParam(':planningdeadline', $planning['planningdeadline']);
          $planningStmt->bindParam(':planningdone', isset($planning['planningdone']) ? '1' : '0');
          $planningStmt->execute();
        }

        // Iterate through the observation data and execute the SQL statement for each row
        foreach ($_POST['observation'] as $observation) {
          $observationStmt->bindParam(':beewayid', $beewayid);
          $observationStmt->bindParam(':dataclass', $observation['dataclass']);
          $observationStmt->bindParam(':learninggoal', $observation['learninggoal']);
          $observationStmt->bindParam(':evaluation', $observation['evaluation']);
          $observationStmt->bindParam(':workgoal', $observation['workgoal']);
          $observationStmt->bindParam(':action', $observation['action']);
          $observationStmt->execute();
        }
      }

      // Redirect the user or show a success message
      // ...

      echo "Data has been successfully saved.";
    } else {
      $_SESSION['error'] = "Er ging iets mis bij het ophalen van je school. Je kunt deze beeway nu niet opslaan!";
      // Redirect the user or show an error message
      // ...
    }
  } catch (PDOException $e) {
    // Handle database errors
    $_SESSION['error'] = "An error occurred while saving the data. Please try again later.";
    // Redirect the user or show an error message
    // ...
  }
?>
