<?php
  require_once '../private/dbconnect.php';
  session_start();
  // try {
  if ($_POST['disciplinename'] == '' ) {
    $_SESSION['error'] = "vul ff iets in";
    header("location: ../index.php?page=editdiscipline");
  } elseif (checkForIllegalCharacters($_POST['disciplinename'])) {
    $_SESSION['error'] = "illegal character used";
    header("location: ../index.php?page=editdiscipline");
  } else {
       try {
         $sql = "UPDATE `disciplines` SET `disciplinename`=:disciplinename, `updatedby`=:updatedby
                WHERE disciplineid=:disciplineid";
         $sth = $conn->prepare($sql);
         $sth->bindParam(':disciplinename', $_POST['disciplinename']);
         $sth->bindParam(':updatedby', $_SESSION['userid']);
         $sth->bindParam(':disciplineid',$_GET['disciplineid']);
         $sth->execute();

         if ($sth->rowCount() > 0) {
           $sql1 = "INSERT INTO `logs` (`userid`, `useragent`, `action`, `tableid`, `interactionid`) VALUES (:userid, :useragent, '2', '2', :interactionid)";
           $sth1 = $conn->prepare($sql1);
           $sth1->bindParam(':userid', $_SESSION['userid']);
           $sth1->bindParam(':useragent', $_SESSION['useragent']);
           $sth1->bindParam(':interactionid', $_GET['disciplineid']);
           $sth1->execute();

           $_SESSION['info'] = "updated successful";
           header("location: ../index.php?page=vakkenlijst");
         } else {
           $_SESSION['error'] = "er ging iets mis. Pech";
           header("location: ../index.php?page=vakkenlijst");
         }
       } catch (\Exception $e) {
         $_SESSION['error'] = "er ging iets mis. Pech";
         header("location: ../index.php?page=vakkenlijst");
       }
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
