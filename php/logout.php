<?php
  session_start();
  require_once '../private/dbconnect.php';

  try {
    $sql = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, 5, 6, :interactionid)";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':userid', $_SESSION['userid']);
    $sth->bindParam(':useragent', $_SESSION['useragent']);
    $sth->bindParam(':interactionid', $_SESSION['userid']);
    $sth->execute();
  } catch (\Exception $e) {
    $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES ("9999", :useragent, 5, "failed to proper logout, no userid set", 6, 0, 5)';
    $sth = $conn->prepare($sql);
    $sth->bindValue(':useragent', $_SESSION['useragent']);
    $sth->execute();
  }

  session_unset();
  session_destroy();
  session_start();

  $_SESSION['info'] = "You have been logged out.";

  header('Location: ../index.php');
  exit;
?>
