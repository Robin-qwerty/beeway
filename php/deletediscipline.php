<?php
  require_once '../private/dbconnect.php';
  session_start();

  if (isset($_SESSION['userid']) && isset($_SESSION['userrole']) && $_SESSION['userrole'] == 'admin') { // check if user is logedin
    $sql = "UPDATE disciplines SET archive=1
            WHERE disciplineid=:disciplineid";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':disciplineid',$_GET['disciplineid']);
    $sth->execute();

    $sql2 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`)
            VALUES (:userid, :useragent, '3', '2', :interactionid)";
    $sth2 = $conn->prepare($sql2);
    $sth2->bindParam(':userid', $_SESSION['userid']);
    $sth2->bindParam(':useragent', $_SESSION['useragent']);
    $sth2->bindParam(':interactionid', $_GET['disciplineid']);
    $sth2->execute();

    $_SESSION['info'] = "deleted successful";
    header("location: ../index.php?page=vakkenlijst");
  } else {
    $_SESSION['error'] = "er ging iets mis. Pech!";
    header("location: ../index.php?page=vakkenlijst#");
  }
?>
