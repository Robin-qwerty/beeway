<?php
  require_once '../private/dbconnect.php';
  session_start();

  $sql = 'SELECT schoolid
       FROM users
       WHERE schoolid<>0
       AND archive<>1
       AND userid=:userid';
  $sth = $conn->prepare($sql);
  $sth->bindValue(':userid', $_SESSION['userid']);
  $sth->execute();

  $result = $sth->fetch();

  if ($result !== false) {
      $schoolid = $result['schoolid'];
  } else {
      // Handle the case when no rows were found
      $_SESSION['error'] = "er ging iets mis met het ophalen van je school. <br> je kan deze beeway nu niet opslaan!";
  }

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
  $stmt->bindValue(':schoolid', '1');
  $stmt->bindValue(':groupid', $groepen);
  $stmt->bindValue(':beewayname', $beewaynaam);
  $stmt->bindValue(':begood', $begoed);
  $stmt->bindValue(':beenough', $bevoldoende);
  $stmt->bindValue(':benotgood', $beonvoldoende);
  $stmt->bindValue(':mainthemeid', $hoofdthemaid);
  $stmt->bindValue(':concretegoal', $concreetdoel);
  $stmt->bindValue(':disciplineid', $vakgebiedid);
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
          $planningStmt->bindValue(':beewayid', $beewayid);
          $planningStmt->bindValue(':planning', $planning['planning']);
          $planningStmt->bindValue(':planningwhat', $planning['planningwhat']);
          $planningStmt->bindValue(':planningwho', $planning['planningwho']);
          $planningStmt->bindValue(':planningdeadline', $planning['planningdeadline']);
          $planningStmt->bindValue(':planningdone', isset($planning['planningdone']) ? '1' : '0');
          $planningStmt->execute();
      }

      // Iterate through the observation data and execute the SQL statement for each row
      foreach ($_POST['observation'] as $observation) {
          $observationStmt->bindValue(':beewayid', $beewayid);
          $observationStmt->bindValue(':dataclass', $observation['dataclass']);
          $observationStmt->bindValue(':learninggoal', $observation['learninggoal']);
          $observationStmt->bindValue(':evaluation', $observation['evaluation']);
          $observationStmt->bindValue(':workgoal', $observation['workgoal']);
          $observationStmt->bindValue(':action', $observation['action']);
          $observationStmt->execute();
      }
  }

  // Redirect the user or show a success message
  // ...

  echo "Data has been successfully saved.";
?>
