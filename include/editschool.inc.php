<?php
  // check if user is logged in and has superuser role
  if (isset($_SESSION['userid']) && isset($_SESSION['userrol']) && $_SESSION['userrol'] == 'superuser') {
?>

  <div class="addeditschool">
    <form class="form" action="php/editschool.php" method="POST">
      <div id="name">
        <div id="logintittle"><h1>school aanpassen <iconify-icon icon="fa6-solid:school"></iconify-icon></h1></div>
        <p style="color:white;">pas deze school aan</p>
        <hr>
      </div>
      <?php
        $sql = 'SELECT * FROM schools
                WHERE schoolid=:schoolid';
        $sth = $conn->prepare($sql);
        $sth->bindParam(':schoolid', $_GET['schoolid']);
        $sth->execute();

        if ($school = $sth->fetch(PDO::FETCH_OBJ)) {
          $sql1 = 'SELECT firstname, lastname FROM users WHERE userid = :userid1
                  UNION ALL
                  SELECT firstname, lastname FROM users WHERE userid = :userid2';
          $sth1 = $conn->prepare($sql1);
          $sth1->bindParam(':userid1', $school->createdby);
          $sth1->bindParam(':userid2', $school->updatedby);
          $sth1->execute();

          $y = 1;
          echo'<div id="editedby">';

          while ($editedby = $sth1->fetch(PDO::FETCH_OBJ)) {
            if ($y == 1) {
              echo'<p>Aangemaakt door: <b>'.$editedby->firstname.' '.$editedby->lastname.'</b></p>';
            } else {
              echo'<p>Als laast bewerkt door: <b>'.$editedby->firstname.' '.$editedby->lastname.'</b></p>';
            }

            $y++;
          }

          echo'
        </div>

        <hr style="margin: 20px 0;">
        <label for="NaamThemaP4"><b>School naam</b></label>

        <input type="text" placeholder="school naam" name="schoolname" id="naamschool" maxlength="40" value="'.$school->schoolname.'" required>';
        }
      ?>
      <br>

      <hr style="margin: 20px 0;">
      <button type="submit" class="registerbtn" style="font-weight: bold;">School aanpassen</button>
    </form>
  </div>

<?php
  // include any error messages
  include 'include/error.inc.php';

  } else {
    // redirect to dashboard if user is not logged in or does not have superuser role
    $_SESSION['error'] = "Er ging iets mis. Pech!";
    header("location: index.php?page=dashboard");
  }
?>
