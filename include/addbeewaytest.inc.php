<?php
    // Your database connection code here

    // Check if the form is submitted
    if(isset($_POST['saveData'])) {
        $planningData = $_POST['planning'];
        $observationData = $_POST['observation'];

        // Prepare the insert statement for planning
        $insertPlanningStmt = $conn->prepare("INSERT INTO beewayplanning (planning, planningwhat, planningwho, planningdeadline, planningdone) VALUES (:planning, :planningwhat, :planningwho, :planningdeadline, :planningdone)");

        // Insert the planning data
        foreach($planningData as $data) {
            $planning = isset($data['planning']) ? $data['planning'] : '';
            $planningWhat = isset($data['planningwhat']) ? $data['planningwhat'] : '';
            $planningWho = isset($data['planningwho']) ? $data['planningwho'] : '';
            $planningDeadline = isset($data['planningdeadline']) ? $data['planningdeadline'] : '';
            $planningDone = isset($data['planningdone']) ? '1' : '0';

            $insertPlanningStmt->bindParam(':planning', $planning);
            $insertPlanningStmt->bindParam(':planningwhat', $planningWhat);
            $insertPlanningStmt->bindParam(':planningwho', $planningWho);
            $insertPlanningStmt->bindParam(':planningdeadline', $planningDeadline);
            $insertPlanningStmt->bindParam(':planningdone', $planningDone);

            $insertPlanningStmt->execute();
        }

        // Prepare the insert statement for observation
        $insertObservationStmt = $conn->prepare("INSERT INTO beewayobservation (dataclass, learninggoal, evaluation, workgoal, action) VALUES (:dataclass, :learninggoal, :evaluation, :workgoal, :action)");

        // Insert the observation data
        foreach($observationData as $data) {
            $dataClass = isset($data['dataclass']) ? $data['dataclass'] : '';
            $learningGoal = isset($data['learninggoal']) ? $data['learninggoal'] : '';
            $evaluation = isset($data['evaluation']) ? $data['evaluation'] : '';
            $workGoal = isset($data['workgoal']) ? $data['workgoal'] : '';
            $action = isset($data['action']) ? $data['action'] : '';

            $insertObservationStmt->bindParam(':dataclass', $dataClass);
            $insertObservationStmt->bindParam(':learninggoal', $learningGoal);
            $insertObservationStmt->bindParam(':evaluation', $evaluation);
            $insertObservationStmt->bindParam(':workgoal', $workGoal);
            $insertObservationStmt->bindParam(':action', $action);

            $insertObservationStmt->execute();
        }

        echo "Data has been successfully saved.";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Page</title>
</head>
<body>
    <form method="POST" action="">
        <!-- Table for Planning -->
        <table>
            <tr>
                <th>Planning</th>
                <th>Planning What</th>
                <th>Planning Who</th>
                <th>Planning Deadline</th>
                <th>Planning Done</th>
            </tr>

            <?php for($i = 1; $i <= 8; $i++): ?>
                <tr>
                    <td><input type="text" name="planning[<?php echo $i; ?>][planning]" value=""></td>
                    <td><input type="text" name="planning[<?php echo $i; ?>][planningwhat]" value=""></td>
                    <td><input type="text" name="planning[<?php echo $i; ?>][planningwho]" value=""></td>
                    <td><input type="text" name="planning[<?php echo $i; ?>][planningdeadline]" value=""></td>
                    <td><input type="checkbox" name="planning[<?php echo $i; ?>][planningdone]"></td>
                </tr>
            <?php endfor; ?>
        </table>

        <!-- Table for Observation -->
        <table>
            <tr>
                <th>Data Class</th>
                <th>Learning Goal</th>
                <th>Evaluation</th>
                <th>Work Goal</th>
                <th>Action</th>
            </tr>

            <?php for($i = 1; $i <= 8; $i++): ?>
                <tr>
                    <td><input type="text" name="observation[<?php echo $i; ?>][dataclass]" value=""></td>
                    <td><input type="text" name="observation[<?php echo $i; ?>][learninggoal]" value=""></td>
                    <td><input type="text" name="observation[<?php echo $i; ?>][evaluation]" value=""></td>
                    <td><input type="text" name="observation[<?php echo $i; ?>][workgoal]" value=""></td>
                    <td><input type="text" name="observation[<?php echo $i; ?>][action]" value=""></td>
                </tr>
            <?php endfor; ?>
        </table>

        <!-- Save button to insert the data -->
        <input type="submit" name="saveData" value="Save">
    </form>
</body>
</html>
