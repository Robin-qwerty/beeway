<?php
require_once '../private/dbconnect.php';
session_start();

if (isset($_SESSION['userid'], $_SESSION['userrole'])) {
    try {
        $q = function ($s) use ($conn) {
            $stmt = $conn->prepare($s);
            $stmt->bindParam(':beewayid', $_GET['beewayid']);
            $stmt->execute();
        };

        $q('UPDATE beeway SET archive=0 WHERE beewayid=:beewayid');
        $q('UPDATE beewayobservation SET archive=0 WHERE beewayid=:beewayid');
        $q('UPDATE beewayplanning SET archive=0 WHERE beewayid=:beewayid');

        $sql = 'INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES (:userid, :useragent, 6, 1, :beewayid, 0)';
        $sth = $conn->prepare($sql);
        $sth->bindParam(':userid', $_SESSION['userid']);
        $sth->bindParam(':useragent', $_SESSION['useragent']);
        $sth->bindParam(':beewayid', $_GET['beewayid']);
        $sth->execute();

        $_SESSION['info'] = 'beeway terug gehaald.';
        header('location: ../index.php?page=beewaylijst');
        exit;
    } catch (\Exception $e) {
        $q('INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES (:userid, :useragent, 6, 1, 0, 5)');
        $_SESSION['error'] = 'An error occurred. Please try again. or contact an admin if this keeps happaning';
        header("Location: ../index.php?page=beewayarchivelijst");
    }
} else {
    $q('INSERT INTO logs (userid, useragent, action, tableid, interactionid, error) VALUES (9999, :useragent, 6, 1, 0, 1)');
    $_SESSION['error'] = 'Unauthorized access. Please log in with appropriate credentials.';
    header('location: ../index.php?page=beewayarchivelijst');
    exit;
}
?>
