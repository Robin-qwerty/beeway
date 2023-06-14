<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid']) && isset($_SESSION['userrole']) && $_SESSION['userrole'] == 'admin') { // check if user is logedin
    try {
      $loggedInUserId = $_SESSION['userid'];

      $timestamp = time();
      $date_time = date('Y-m-d H:i:s', $timestamp);

      $sql = "UPDATE disciplines SET archive=1, deletedby=:deletedby, deletedat=:deletedat
              WHERE disciplineid=:disciplineid";
      $sth = $conn->prepare($sql);
      $sth->bindParam(':disciplineid',$_GET['disciplineid']);
      $sth->bindParam(':deletedby', $loggedInUserId);
      $sth->bindParam(':deletedat', $date_time);
      $sth->execute();

      $sql2 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`)
              VALUES (:userid, :useragent, '3', '2', :interactionid)";
      $sth2 = $conn->prepare($sql2);
      $sth2->bindParam(':userid', $_SESSION['userid']);
      $sth2->bindParam(':useragent', $_SESSION['useragent']);
      $sth2->bindParam(':interactionid', $_GET['disciplineid']);
      $sth2->execute();

      $_SESSION['info'] = "archive successful";
      header("Location: ../index.php?page=vakkenlijst");
    } catch (\Exception $e) {
      $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 3, 2, 0, 5)';
      $sth = $conn->prepare($sql);
      $sth->bindValue(':useragent', $_SESSION['useragent']);
      $sth->execute();

      $_SESSION['error'] = "archive failed";
      header("Location: ../index.php?page=vakkenlijst");
    }
  } else {
    $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 3, 2, 0, 1)';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':useragent', $_SESSION['useragent']);
    $sth->execute();

    $_SESSION['error'] = "Unauthorized access. Please log in with appropriate credentials.";
    header("Location: ../index.php?page=vakkenlijst");
  }
?>
