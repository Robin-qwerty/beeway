<?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }

  include'private/dbconnect.php';
  session_start();

  $_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];

  // test if mysql user can delete from table (he can't)
  // $sql = 'DELETE FROM `users` WHERE userid=24';
  // $sth = $conn->prepare($sql);
  // $sth->execute();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title> <?php if(isset($page)) { echo $page; } else {echo "Home";}?></title>
  <link rel="icon" type="image/x-icon" href="media/favicon.ico">
  <link href="style/style.css" rel="stylesheet">
  <link href="style/beheer.css" rel="stylesheet">
  <link href="style/beewaystyle.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.0-beta.3/dist/iconify-icon.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>

  <?php
    include 'include/navbar.inc.php';

    if (isset($page) && isset($_SESSION['userid']) && isset($_SESSION['userrol'])) {
      include 'include/'.$page.'.inc.php';
    } else {
      include 'include/login.inc.php';
    }

    echo "<pre>", print_r($_SESSION),"</pre>";
  ?>

</body>
</html>
