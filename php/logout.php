<?php
  session_start();
  include'../private/dbconnect.php';

  try {
    $sql = "INSERT INTO `logs` (`userid`, `action`, `tableid`, `interactionid`) VALUES (:userid, '5', '6', :interactionid)";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':userid', $_SESSION['userid']);
    $sth->bindParam(':interactionid', $_SESSION['userid']);
    $sth->execute();
  } catch (\Exception $e) {
    // $_SESSION['error'] = "Pech";
  }

  session_destroy();
  session_start();

  $_SESSION['info'] = "uitgelogd.";

  header('location: ../index.php');
?>
