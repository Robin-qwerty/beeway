<?php
  $sql = "SELECT * FROM disciplines WHERE disciplineid = :disciplineid";
  $sth = $conn->prepare($sql);
  $sth->bindParam(':disciplineid', $_GET['disciplineid']);
  $sth->execute();

  if ($discipline = $sth->fetch(PDO::FETCH_OBJ)) {
  echo '
    <div class="addeditdiscipline">
      <form class="form" action="php/adddiscipline.php" method="POST">
        <div id="name"><h1>vakken toevoegen</h1>
        <p>Voeg een nieuwe vak toe aan het systeem</p></div>
        <hr style="margin: 20px 0;">

        <label for="vak"><b>vak</b></label>
        <br>
            <input id="textaddedit" type="text" placeholder="vak" name="disciplinename" value="'.$discipline->disciplinename.'" required>
            <hr style="margin: 20px 0;">
            <button type="submit" class="adddisciplinerbtn" style="font-size:20px;font-weight: bold;">vak opslaan</button>
                      <a id="disciplinedelete"style="font-size:20px;font-weight: bold; float:right;"'; ?> onclick='return confirm("Weet je zekker dat je deze vak wilt verwijderen!?")' <?php echo ' href="php/deletediscipline.php?disciplineid='.$discipline->disciplineid.'" class="deletebutton" >vak verwijderen</a>
          </form>
        </div>
    ';
  }
?>
