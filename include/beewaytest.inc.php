<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }
</style>
<h1>Planning en Observatie</h1>

<?php
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
            // Een formulier genereren met de planninggegevens
            echo "<form method='POST' action=''>";
            echo "<table>
                    <tr>
                        <th>Planning</th>
                        <th>Planning Wat</th>
                        <th>Planning Wie</th>
                        <th>Planning Deadline</th>
                        <th>Planning Klaar</th>
                    </tr>";

            // Gegevens weergeven in de tabel voor de planning
            $desiredRowCount = 8;
            for ($i = 1; $i <= $desiredRowCount; $i++) {
                $row = isset($planningResult[$i - 1]) ? $planningResult[$i - 1] : array('planningid' => '', 'planning' => '', 'planningwhat' => '', 'planningwho' => '', 'planningdeadline' => '', 'planningdone' => '');
                echo "<tr>
                        <td><input class='editable-input' type='text' name='planning[" . $row['planningid'] . "][planning]' value='" . $row['planning'] . "'></td>
                        <td><input class='editable-input' type='text' name='planning[" . $row['planningid'] . "][planningwhat]' value='" . $row['planningwhat'] . "'></td>
                        <td><input class='editable-input' type='text' name='planning[" . $row['planningid'] . "][planningwho]' value='" . $row['planningwho'] . "'></td>
                        <td><input class='editable-input' type='text' name='planning[" . $row['planningid'] . "][planningdeadline]' value='" . $row['planningdeadline'] . "'></td>
                        <td><input class='editable-input' type='checkbox' name='planning[" . $row['planningid'] . "][planningdone]' value='1' " . ($row['planningdone'] == '1' ? 'checked' : '') . "></td>
                    </tr>";
            }

            echo "</table>";
            echo "<br>";
        } else {
            echo "Geen planninggegevens gevonden.";
        }

        // Controleren of er resultaten zijn voor de observatie
        if (!empty($observationResult)) {
            // Een formulier genereren met de observatiegegevens
            echo "<table>
                    <tr>
                        <th>Dataclass</th>
                        <th>Leerdoel</th>
                        <th>Evaluatie</th>
                        <th>Werkdoel</th>
                        <th>Actie</th>
                    </tr>";

            // Gegevens weergeven in de tabel voor de observatie
            $desiredRowCount = 8;
            for ($i = 1; $i <= $desiredRowCount; $i++) {
                $row = isset($observationResult[$i - 1]) ? $observationResult[$i - 1] : array('observationid' => '', 'dataclass' => '', 'learninggoal' => '', 'evaluation' => '', 'workgoal' => '', 'action' => '');
                echo "<tr>
                        <td><input class='editable-input' type='text' name='observation[" . $row['observationid'] . "][dataclass]' value='" . $row['dataclass'] . "'></td>
                        <td><input class='editable-input' type='text' name='observation[" . $row['observationid'] . "][learninggoal]' value='" . $row['learninggoal'] . "'></td>
                        <td><input class='editable-input' type='text' name='observation[" . $row['observationid'] . "][evaluation]' value='" . $row['evaluation'] . "'></td>
                        <td><input class='editable-input' type='text' name='observation[" . $row['observationid'] . "][workgoal]' value='" . $row['workgoal'] . "'></td>
                        <td><input class='editable-input' type='text' name='observation[" . $row['observationid'] . "][action]' value='" . $row['action'] . "'></td>
                    </tr>";
            }

            echo "</table>";
            echo "<br>";
        } else {
            echo "Geen observatiegegevens gevonden.";
        }

        // De knop weergeven voor het bijwerken van zowel planning als observatie
        echo "<input type='submit' name='updateData' value='Update Planning en Observatie'>";
        echo "</form>";
    }
?>

<?php
    // Controleren of het formulier voor het bijwerken van planning en observatie is verzonden
    if(isset($_POST['updateData'])) {
        $planningData = $_POST['planning'];
        $observationData = $_POST['observation'];

        // Voorbereiden van de update query voor planning
        $updatePlanningStmt = $conn->prepare("UPDATE beewayplanning SET planning = :planning, planningwhat = :planningwhat, planningwho = :planningwho, planningdeadline = :planningdeadline, planningdone = :planningdone WHERE planningid = :planningid");

        // Bijwerken van de planninggegevens
        foreach($planningData as $planningId => $data) {
            $planning = isset($data['planning']) ? $data['planning'] : '';
            $planningWhat = isset($data['planningwhat']) ? $data['planningwhat'] : '';
            $planningWho = isset($data['planningwho']) ? $data['planningwho'] : '';
            $planningDeadline = isset($data['planningdeadline']) ? $data['planningdeadline'] : '';
            $planningDone = isset($data['planningdone']) ? '1' : '0';

            $updatePlanningStmt->bindParam(':planningid', $planningId);
            $updatePlanningStmt->bindParam(':planning', $planning);
            $updatePlanningStmt->bindParam(':planningwhat', $planningWhat);
            $updatePlanningStmt->bindParam(':planningwho', $planningWho);
            $updatePlanningStmt->bindParam(':planningdeadline', $planningDeadline);
            $updatePlanningStmt->bindParam(':planningdone', $planningDone);

            $updatePlanningStmt->execute();
        }

        // Voorbereiden van de update query voor observatie
        $updateObservationStmt = $conn->prepare("UPDATE beewayobservation SET dataclass = :dataclass, learninggoal = :learninggoal, evaluation = :evaluation, workgoal = :workgoal, action = :action WHERE observationid = :observationid");

        // Bijwerken van de observatiegegevens
        foreach($observationData as $observationId => $data) {
            $dataClass = isset($data['dataclass']) ? $data['dataclass'] : '';
            $learningGoal = isset($data['learninggoal']) ? $data['learninggoal'] : '';
            $evaluation = isset($data['evaluation']) ? $data['evaluation'] : '';
            $workGoal = isset($data['workgoal']) ? $data['workgoal'] : '';
            $action = isset($data['action']) ? $data['action'] : '';

            $updateObservationStmt->bindParam(':observationid', $observationId);
            $updateObservationStmt->bindParam(':dataclass', $dataClass);
            $updateObservationStmt->bindParam(':learninggoal', $learningGoal);
            $updateObservationStmt->bindParam(':evaluation', $evaluation);
            $updateObservationStmt->bindParam(':workgoal', $workGoal);
            $updateObservationStmt->bindParam(':action', $action);

            $updateObservationStmt->execute();
        }

        echo "Planning en observatiegegevens zijn succesvol bijgewerkt.";
    }
?>
