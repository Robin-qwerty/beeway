<?php
  if (isset($_SESSION['userid']) && isset($_SESSION['userrole']) && ($_SESSION['userrole'] == 'admin' || $_SESSION['userrole'] == 'docent')) {
    if (isset($_GET['beewayid']) && $_GET['beewayid'] > 0) {
      $loggedInUserID = $_SESSION['userid'];
      $beewayID = $_GET['beewayid'];

      // Check if the lock is already set
      $stmt = $conn->prepare("SELECT `lock` FROM beeway WHERE beewayid = :beewayid");
      $stmt->bindValue(':beewayid', $beewayID, PDO::PARAM_INT);
      $stmt->execute();
      $beewayLock = $stmt->fetchColumn();

      // Check if the lock is already set
      if ($beewayLock != 0 && $beewayLock != $_SESSION['userid']) {
        $_SESSION['error'] = "Deze beeway wordt momenteel bewerkt door iemand anders. Probeer het later opnieuw.";
        header("Location: index.php?page=beewaylijst");
        exit;
      }

      // Set the lock to the user ID
      $stmt = $conn->prepare("UPDATE beeway SET `lock` = :userid WHERE beewayid = :beewayid");
      $stmt->bindValue(':userid', $loggedInUserID, PDO::PARAM_INT);
      $stmt->bindValue(':beewayid', $beewayID, PDO::PARAM_INT);
      $stmt->execute();

      $_SESSION['beewaylock'] = true;

      // At the end of the script or when leaving the page, set the lock back to 0
      // register_shutdown_function(function() use ($conn, $beewayID) {
      //   $stmt = $conn->prepare("UPDATE beeway SET `lock` = 0 WHERE beewayid = :beewayid");
      //   $stmt->bindValue(':beewayid', $beewayID, PDO::PARAM_INT);
      //   $stmt->execute();
      // });

      $sql = 'SELECT schoolid
             FROM users
             WHERE schoolid<>0
             AND archive=0
             AND userid=:userid';
      $sth = $conn->prepare($sql);
      $sth->bindValue(':userid', $_SESSION['userid']);
      $sth->execute();

      $result = $sth->fetch(); // Fetch the result from the executed query
      $schoolid = $result['schoolid']; // Access the schoolid value from the result array

      $sql = 'SELECT * FROM beeway
              WHERE beewayid=:beewayid';
      $sth = $conn->prepare($sql);
      $sth->bindParam(':beewayid', $_GET['beewayid']);
      $sth->execute();

      if ($beeway = $sth->fetch(PDO::FETCH_OBJ)) {
        if ($beeway->archive == 1) {
          $_SESSION['error'] = "Je kan deze beeway niet bewerken omdat ie verwijdert is. Pech!";
          header("Location: index.php?page=beewaylijst");
          exit;
        }

        echo'
        <div class="beewayedit">
          <form id="form0" action="php/editbeeway.php?beewayid='.$_GET['beewayid'].'" method="post">
            <div><input type="text" placeholder="BeewayNaam" name="beewaynaam" value="'.$beeway->beewayname.'" required></div>
            <div><button id="opslaan" class="addbutton" type="submit" style="font-size: 16px;">Opslaan</button></div>
            <div><a '; ?> onclick='return confirm("Weet je zekker dat je deze beeway wilt verwijderen!?")' <?php echo ' href="php/deletebeeway.php?beewayid='.$_GET['beewayid'].'" class="deletebutton" style="font-size: 16px;">Verwijderen</a></div>
            <div>
        ';

        $sql1 = 'SELECT firstname, lastname FROM users WHERE userid = :userid1
                UNION ALL
                SELECT firstname, lastname FROM users WHERE userid = :userid2';
        $sth1 = $conn->prepare($sql1);
        $sth1->bindParam(':userid1', $beeway->createdby);
        $sth1->bindParam(':userid2', $beeway->updatedby);
        $sth1->execute();

        $y = 1;

        while ($editedby = $sth1->fetch(PDO::FETCH_OBJ)) {
          if ($y == 1) {
            echo'<p>Aangemaakt door: <b>'.$editedby->firstname.' '.$editedby->lastname.'</b></p>';
          } else {
            echo'<p>Als laast bewerkt door: <b>'.$editedby->firstname.' '.$editedby->lastname.'</b></p>';
          }

          $y++;
        }
      }
      echo '</div>
      <div>
        <label for="status" style="font-size:20px;"><b>beeway Markeren als afgerond</b></label>
        <input id="my-checkbox" type="checkbox" name="status" value="1">
      </div>
    </div>

    <hr>';
    // Controleren of het BeeWay ID in de URL is opgegeven
    if(isset($_GET['beewayid'])) {
        $beewayId = $_GET['beewayid'];

        // Query uitvoeren om de planninggegevens op te halen
        $planningSql = "SELECT * FROM beewayplanning WHERE beewayid = :beewayid LIMIT 8";
        $planningStmt = $conn->prepare($planningSql);
        $planningStmt->bindParam(':beewayid', $beewayId);
        $planningStmt->execute();
        $planningResult = $planningStmt->fetchAll(PDO::FETCH_ASSOC);

        // Query uitvoeren om de observatiegegevens op te halen
        $observationSql = "SELECT * FROM beewayobservation WHERE beewayid = :beewayid";
        $observationStmt = $conn->prepare($observationSql);
        $observationStmt->bindParam(':beewayid', $beewayId);
        $observationStmt->execute();
        $observationResult = $observationStmt->fetchAll(PDO::FETCH_ASSOC);

        // Controleren of er resultaten zijn voor de planning
        if (!empty($planningResult)) {
          ?>
          <div class="helebeeway">
            <div id="grid-line">
              <div class="cell BEEWAY">
                <h1>[naam]</h1>
                <h2>Iedere dag ’n beetje beter</h2>
                <div id="groepen">
                  <label>Groepen</label>
                  <select name="groepen" required>
                    <option value="">-- selecteer een groep --</option>
                    <?php
                      if ($_SESSION['userrole'] == 'admin') {
                        $sql = 'SELECT g.groups, g.groupid
                                FROM groups AS g
                                WHERE g.archive=0
                                AND g.schoolid=:schoolid';
                        $sth = $conn->prepare($sql);
                        $sth->bindValue(':schoolid', $schoolid);
                        $sth->execute();
                      } else {
                        $sql = 'SELECT DISTINCT g.groups, g.groupid
                                FROM groups AS g
                                INNER JOIN linkgroups AS lg ON g.groupid = lg.groupid
                                WHERE g.archive = 0
                                AND g.schoolid = :schoolid
                                AND lg.userid = :userid';
                        $sth = $conn->prepare($sql);
                        $sth->bindValue(':schoolid', $schoolid);
                        $sth->bindValue(':userid', $_SESSION['userid']);
                        $sth->execute();
                      }

                      while ($group = $sth->fetch(PDO::FETCH_OBJ)) {
                        $selected = isset($beeway->groupid) && $beeway->groupid == $group->groupid ? 'selected="selected"' : '';
                        echo '<option value="'.$group->groupid.'" '.$selected.'>'.$group->groups.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>

              <!-- <div class="cell HOOFDTHEMA">
                <h2 id="orange">HOOFDTHEMA</h2>
                <input type="radio" name="hoofdthemaid" value="1" <?php echo isset($beeway->themeperiodid) && $beeway->themeperiodid == 1 ? 'checked' : ''; ?> required>
                <label for="html">P1: EDI</label>
                <br>
                <input type="radio" name="hoofdthemaid" value="2" <?php echo isset($beeway->themeperiodid) && $beeway->themeperiodid == 2 ? 'checked' : ''; ?>>
                <label for="html">P2: BEGELEIDENDE INOEFENING</label>
                <br>
                <input type="radio" name="hoofdthemaid" value="3" <?php echo isset($beeway->themeperiodid) && $beeway->themeperiodid == 3 ? 'checked' : ''; ?>>
                <label for="html">P3: LEZEN</label>
                <br>
                <input type="radio" name="hoofdthemaid" value="4" <?php echo isset($beeway->themeperiodid) && $beeway->themeperiodid == 4 ? 'checked' : ''; ?>>
                <label for="html">P4: DIFFERENTIATIE EDI</label>
                <br>
                <input type="radio" name="hoofdthemaid" value="5" <?php echo isset($beeway->themeperiodid) && $beeway->themeperiodid == 5 ? 'checked' : ''; ?>>
                <label for="html">P5: DOELENPLANNER</label>
                <br>
              </div> -->
              <div class="cell HOOFDTHEMA">
                <h2 id="orange">HOOFDTHEMA</h2>
            <?php
              $sql = 'SELECT namethemep1, namethemep2, namethemep3, namethemep4, namethemep5
                      FROM maintheme
                      WHERE archive = 0
                      AND schoolid = :schoolid
                      AND themeid = :themeid';
              $sth = $conn->prepare($sql);
              $sth->bindValue(':schoolid', $schoolid);
              $sth->bindValue(':themeid', $beeway->mainthemeid);
              $sth->execute();

              if ($sth->rowCount() > 0) {
                while ($maintheme = $sth->fetch(PDO::FETCH_OBJ)) {
                  echo '
                    <input type="radio" name="themeperiodid" value="1" '.(isset($beeway->themeperiodid) && $beeway->themeperiodid == 1 ? 'checked' : '').' required>
                    <label for="html">P1: '.$maintheme->namethemep1.'</label>
                    <br>
                    <input type="radio" name="themeperiodid" value="2" '.(isset($beeway->themeperiodid) && $beeway->themeperiodid == 2 ? 'checked' : '').'>
                    <label for="html">P2: '.$maintheme->namethemep2.'</label>
                    <br>
                    <input type="radio" name="themeperiodid" value="3" '.(isset($beeway->themeperiodid) && $beeway->themeperiodid == 3 ? 'checked' : '').'>
                    <label for="html">P3: '.$maintheme->namethemep3.'</label>
                    <br>
                    <input type="radio" name="themeperiodid" value="4" '.(isset($beeway->themeperiodid) && $beeway->themeperiodid == 4 ? 'checked' : '').'>
                    <label for="html">P4: '.$maintheme->namethemep4.'</label>
                    <br>
                    <input type="radio" name="themeperiodid" value="5" '.(isset($beeway->themeperiodid) && $beeway->themeperiodid == 5 ? 'checked' : '').'>
                    <label for="html">P5: '.$maintheme->namethemep5.'</label>
                    <br>
                  ';
                }
              } else {
                echo "<p>No main theme options available.</p>";
              }
            ?>
          </div>


              <div class="cell CONCREETDOEL">
                <h2 id="orange">CONCREET DOEL</h2>
                <textarea type="text" name="concreetdoel" id="doel" maxlength="2500"><?php echo isset($beeway->concretegoal) ? $beeway->concretegoal : ''; ?></textarea>
              </div>

              <div class="cell beoordeling">
                <div class="beoordeling-item beoordeling-item1"><iconify-icon icon="fa:smile-o" style='font-size:62px'></iconify-icon></div>
                <div class="beoordeling-item beoordeling-item2">
                  <input type="number" name="begoed" id="beoordeling1" onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;" <?php echo isset($beeway->begood) ? 'value="'.$beeway->begood.'"' : ''; ?> ></input>
                </div>
                <div class="beoordeling-item beoordeling-item3"><iconify-icon icon="fa:meh-o" style='font-size:62px'></iconify-icon></div>
                <div class="beoordeling-item beoordeling-item4">
                  <input type="number" name="bevoldoende" id="beoordeling2" onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;" <?php echo isset($beeway->beenough) ? 'value="'.$beeway->beenough.'"' : ''; ?> ></input>
                </div>
                <div class="beoordeling-item beoordeling-item5"><iconify-icon icon="fa:frown-o" style='font-size:62px'></iconify-icon></div>
                <div class="beoordeling-item beoordeling-item6">
                  <input type="number" name="beonvoldoende" id="beoordeling3" onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;" <?php echo isset($beeway->benotgood) ? 'value="'.$beeway->benotgood.'"' : ''; ?> ></input>
                </div>
              </div>


              <div class="cell vakgebied">
                <h2 id="orange">VAKGEBIED</h2>
                <select name="vakgebiedid" id="vakgebied" required>
                  <option value="">-- selecteer een vakgebied --</option>
                  <?php
                    $sql = 'SELECT disciplinename, disciplineid
                            FROM disciplines
                            WHERE archive=0
                            AND schoolid=:schoolid';
                    $sth = $conn->prepare($sql);
                    $sth->bindValue(':schoolid', $schoolid);
                    $sth->execute();

                    while ($disciplines = $sth->fetch(PDO::FETCH_OBJ)) {
                      $selected = isset($beeway->disciplineid) && $beeway->disciplineid == $disciplines->disciplineid ? 'selected="selected"' : '';
                      echo '<option value="'.$disciplines->disciplineid.'" '.$selected.'>'.$disciplines->disciplinename.'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
          <?php
            // Een formulier genereren met de planninggegevens
            echo '<table style="width:80%;">
                    <tr style="background-color:#feae00;">
                      <th>Planning</th>
                      <th>Wat</th>
                      <th>Wie</th>
                      <th>Deadline</th>
                      <th style="width:60px;">&#x2714;</th>
                    </tr>';

            // Gegevens weergeven in de tabel voor de planning
            $desiredRowCount = 8;
            for ($i = 1; $i <= $desiredRowCount; $i++) {
                $row = isset($planningResult[$i - 1]) ? $planningResult[$i - 1] : array('planningid' => '', 'planning' => '', 'planningwhat' => '', 'planningwho' => '', 'planningdeadline' => '', 'planningdone' => '');
                echo "<tr>
                        <td><textarea class='editable-input textareaobservatie' name='planning[" . $row['planningid'] . "][planning]' rows='3' maxlength='155'>" . $row['planning'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='planning[" . $row['planningid'] . "][planningwhat]' rows='3' maxlength='155'>" . $row['planningwhat'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='planning[" . $row['planningid'] . "][planningwho]' rows='3' maxlength='155'>" . $row['planningwho'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='planning[" . $row['planningid'] . "][planningdeadline]' rows='3' maxlength='155'>" . $row['planningdeadline'] . "</textarea></td>
                        <td style='background-color:white;border-style:solid;border-width: 0.8px;padding: 1rem;'><input class='editable-input' type='checkbox' name='planning[" . $row['planningid'] . "][planningdone]' value='1' " . ($row['planningdone'] == '1' ? 'checked' : '') . "></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            $_SESSION['error'] = "Geen planninggegevens gevonden. Pech!";
            echo "<br> Geen planninggegevens gevonden.";
        }

        // Controleren of er resultaten zijn voor de observatie
        if (!empty($observationResult)) {
            // Een formulier genereren met de observatiegegevens
            echo '<table style="width:80%;">
                    <tr style="background-color:#feae00;">
                      <th>Dataclass</th>
                      <th>Leerdoel</th>
                      <th>Evaluatie</th>
                      <th>Werkdoel</th>
                      <th>Actie</th>
                    </tr>';

            // Gegevens weergeven in de tabel voor de observatie
            $desiredRowCount = 5;
            for ($i = 1; $i <= $desiredRowCount; $i++) {
                $row = isset($observationResult[$i - 1]) ? $observationResult[$i - 1] : array('observationid' => '', 'dataclass' => '', 'learninggoal' => '', 'evaluation' => '', 'workgoal' => '', 'action' => '');
                echo "<tr>
                        <td><textarea class='editable-input textareaobservatie' name='observation[" . $row['observationid'] . "][dataclass]' rows='3' maxlength='155'>" . $row['dataclass'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='observation[" . $row['observationid'] . "][learninggoal]' rows='3' maxlength='155'>" . $row['learninggoal'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='observation[" . $row['observationid'] . "][evaluation]' rows='3' maxlength='155'>" . $row['evaluation'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='observation[" . $row['observationid'] . "][workgoal]' rows='3' maxlength='155'>" . $row['workgoal'] . "</textarea></td>
                        <td><textarea class='editable-input textareaobservatie' name='observation[" . $row['observationid'] . "][action]' rows='3' maxlength='155'>" . $row['action'] . "</textarea></td>
                      </tr>";
            }
            echo "</table>";
        } else {
          $_SESSION['error'] = "Geen observatiegegevens gevonden. Pech!";
          echo "<br> Geen observatiegegevens gevonden.";
        }

        // De knop weergeven voor het bijwerken van zowel planning als observatie
        // echo "<input type='submit' name='updateData' value='Update Planning en Observatie'>";
        echo "</form>";
        echo "</div>";

    }

    } else {
      $_SESSION['error'] = 'Failed to get beeway';
      header('Location: index.php?page=beewaylijst');
      exit;
    }
  } else {
    $_SESSION['error'] = "er ging iets mis. Pech!";
    header("Location: index.php?page=dashboard");
    exit;
  }

  require_once 'include/info.inc.php';
  require_once 'include/error.inc.php';
?>

<script src="script/beeway.js"></script>
