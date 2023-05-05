<?php if (isset($_SESSION['userrol'])) {?>
  <div class="beewaylijst">
      <?php if ($_SESSION['userrol'] == "superuser") { ?>
        <div class="beewaylijsttitel"><h1>Welkom op het super user dashboard</h1></div>
        <h2>beheer hier dingen (:</h2>

        <div class="beewaylijstopties">
          <button onclick="window.location.href='index.php?page=userlijst';" id="beewaylijstopties5">Users</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=scholenlijst';" id="beewaylijstopties5">Scholen</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=logslijst';" id="beewaylijstopties5">Site Logs</button>
      <?php } else if ($_SESSION['userrol'] == "admin") {?>
        <div class="beewaylijsttitel"><h1>Welkom op het admin dashboard</h1></div>
        <h2>beheer hier dingen (:</h2>

        <div class="beewaylijstopties">
          <button onclick="window.location.href='index.php?page=beewaylijst';" id="beewaylijstopties1">Beeway's</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=klassenlijst';" id="beewaylijstopties4">Klassen</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=vakkenlijst';" id="beewaylijstopties2">Vakken</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=Hoofdthemalijst';" id="beewaylijstopties3">Hoofdthema's</button>
          <b>|</b>
          <button onclick="window.location.href='index.php?page=userlijst';" id="beewaylijstopties5">Users</button>
      <?php } else { ?>
        <div class="beewaylijsttitel"><h1>Welkom op het docenten dashboard</h1></div>
        <h2>beheer hier dingen (:</h2>

        <div class="beewaylijstopties">
          <button onclick="window.location.href='index.php?page=beewaylijst';" id="beewaylijstopties1">Beeway's</button>
      <?php } ?>
    </div>

    <hr>

      <h2>filters</h2>

      <label for="rol"><b>filter op user</b></label>
      <br>
      <select id="schoolselect" name="school">
        <option value="0" selected="selected">-- sorteer op user --</option>
        <?php
          $sql = 'SELECT userid, firstname, lastname FROM users';
          $sth = $conn->prepare($sql);
          $sth->execute();

          while ($user = $sth->fetch(PDO::FETCH_OBJ)) {
            echo'
            <option value="index.php?page=logslijst&userid='.$user->userid.'">'.$user->firstname." ".$user->lastname.'</option>
            ';
          }
        ?>
      </select>

  <script>
    const selectElement = document.getElementById('schoolselect');

    // Add an event listener for the "change" event
    selectElement.addEventListener('change', (event) => {
      // Get the selected option's value
      const selectedValue = event.target.value;
      // Redirect to the selected URL
      window.location.href = selectedValue;
    });
  </script>

    <hr>

    <br>
    <table class="beewaylijsttable">
      <tr>
        <th><h3>datum en tijd</h3></th>
        <th><h3>user name</h3></th>
        <th><h3>actie</h3></th>
        <th><h3>tabel van actie</h3></th>
        <th><h3>id van actie</h3></th>
      </tr>
      <?php
        if (isset($_GET['offset'])) {
          $offset = $_GET['offset'] * 4;

          $sql = 'SELECT l.*, u.firstname, u.lastname
                  FROM logs as l, users as u
                  WHERE l.userid=u.userid
                  ORDER BY id DESC
                  LIMIT 4 OFFSET '.intval($offset);
          $sth = $conn->prepare($sql);
          $sth->execute();
        } else {
          $sql = 'SELECT l.*, u.firstname, u.lastname
                  FROM logs as l, users as u
                  WHERE l.userid=u.userid
                  ORDER BY id DESC
                  LIMIT 4';
          $sth = $conn->prepare($sql);
          $sth->execute();
        }

        while ($logs = $sth->fetch(PDO::FETCH_OBJ)) {
          if ($logs->action == '0') {$action = 'select';}
          elseif ($logs->action == '1') {$action = 'insert';}
          elseif ($logs->action == '2') {$action = 'update';}
          elseif ($logs->action == '3') {$action = 'delete';}
          elseif ($logs->action == '4') {$action = 'login';}
          elseif ($logs->action == '5') {$action = 'logout';}

          if ($logs->tableid == '1') {$tableid = 'beeway';}
          elseif ($logs->tableid == '2') {$tableid = 'vakken';}
          elseif ($logs->tableid == '3') {$tableid = 'groepen';}
          elseif ($logs->tableid == '4') {$tableid = 'hoofdthemas';}
          elseif ($logs->tableid == '5') {$tableid = 'scholen';}
          elseif ($logs->tableid == '6') {$tableid = 'users';}

          echo'
            <tr>
              <td><b>'.$logs->date.'</b></td>
              <td><b>'.$logs->firstname." ".$logs->lastname.'</b></td>
              <td><b>'.$action.'</b></td>
              <td><b>'.$tableid.'</b></td>
              <td><b>'.$logs->interactionid.'</b></td>
            </tr>
          ';
        }
      ?>
    </table>
    <div class="tablebuttons">
      <?php
        if (isset($_GET['offset'])) {
          $terug = $_GET['offset'] - 1;
          $volgende = $_GET['offset'] + 1;
          if ($_GET['offset'] == '0') {
            echo '
              <a href="index.php?page=logslijst&offset='.$volgende.'" class="addbutton">volgende</a>
            ';
          } else {
            echo '
              <a href="index.php?page=logslijst&offset='.$terug.'" class="addbutton">terug</a>
              <a href="index.php?page=logslijst&offset='.$volgende.'" class="addbutton">volgende</a>
            ';
          }
        } else {
          echo '
            <a href="index.php?page=logslijst&offset=1" class="addbutton">volgende</a>
          ';
        }
      ?>
    </div>
    <hr>
  </div>

  <?php include 'include/error.inc.php'; ?>
<?php } else {
  $_SESSION['error'] = "er ging iets mis. Pech!";
  header("location: index.php?page=login");
} ?>
