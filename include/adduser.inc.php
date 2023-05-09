<?php if (isset($_SESSION['userid']) && isset($_SESSION['userrol']) && $_SESSION['userrol'] == 'superuser') { // check if user is logedin ?>
  <script src="script/admin_gebruikertoevoegen.js"></script>
  <form class="form addedit" method="POST" action="php/adduser.php">
    <!-- <div class="admin_adduser form"> -->
      <div id="logintittle"><h1>admin - gebruiker toevoegen <iconify-icon icon="akar-icons:person"></iconify-icon></h1></div>
      <hr>
      <div id="LP">
        <label for="name"><b>voornaam</b></label>
        <br>
        <input type="text" placeholder="Enter voornaam" name="firstname" required>
        <br>
        <label for="lastname"><b>achternaam</b></label>
        <br>
        <input type="text" placeholder="Enter achternaam" name="lastname" required>
        <br>
        <label for="rol"><b>rol</b></label>
        <br>
        <select id="rolselect" name="role">
          <option value="1">docent</option>
          <option value="2">admin</option>
        </select>

        <div class="klassenselect" id="klassenselect">
          <br>
          <label for="lastname"><b>groepen</b></label>
          <br>

          <div class="multiselect">
            <div class="selectBox" onclick="showCheckboxes()">
              <select>
                <option style="text-align:center;">-- Selecteer groepen die bij de docent horen --</option>
              </select>
              <div class="overSelect"></div>
            </div>
            <div id="checkboxes">
              <?php
                $sql = 'SELECT groups, groupid
                        FROM groups
                        WHERE archive<>"1"';
                $sth = $conn->prepare($sql);
                $sth->execute();

                while ($groups = $sth->fetch(PDO::FETCH_OBJ)) {
                  echo'
                    <label for="groepen">
                      <input type="checkbox" name="groepen[]" value="'.$groups->groupid.'"/>groepen '.$groups->groups.'</label>
                  ';
                }
              ?>
            </div>
          </div>
        </div>

      </div>
      <div id="RP">

        <label for="rol"><b>school</b></label>
        <br>
        <select id="schoolselect" name="school">
          <option value="0" selected="selected">-- selecteer de bijbehorende school --</option>
          <?php
            $sql = 'SELECT schoolname
                    FROM schools
                    WHERE schoolid<>"0"
                    AND archive<>"1"';
            $sth = $conn->prepare($sql);
            $sth->execute();

            while ($schools = $sth->fetch(PDO::FETCH_OBJ)) {
              echo'
              <option value="1">'.$schools->schoolname.'</option>
              ';
            }
          ?>
        </select>

        <hr>

        <br>
        <label for="email"><b>Email</b></label>
        <br>
        <input type="email" placeholder="Enter Email" name="email" required>
        <br>
        <label for="psw"><b>Password</b></label>
        <br>
        <input type="password" placeholder="Enter Password" name="password" id="password" style="margin-bottom:0;" required>
        <p id="password-validation"></p>

      </div>

      <button type="submit" id="adduserbtn" class="registerbtn" disabled>aanmaken</button>

      <script>
        var passwordField = document.getElementById("password");
        var validationField = document.getElementById("password-validation");
        var submitButton = document.getElementById("adduserbtn");

        // Add a listener to the password field for when the user types
        passwordField.addEventListener("keyup", function() {
          // Get the value of the password field
          var password = passwordField.value;

          // Check if the password meets the requirements
          var hasUpperCase = /[A-Z]/.test(password);
          var hasLowerCase = /[a-z]/.test(password);
          var hasMinLength = password.length >= 6;

          // Update the validation message based on the requirements
          if (hasUpperCase && hasLowerCase && hasMinLength) {
            validationField.innerHTML = "";
            submitButton.disabled = false;
          } else {
            validationField.innerHTML = "Het wachtwoord moet minimaal één hoofdletter en één kleine letter bevatten en minimaal 6 tekens lang zijn.";
            submitButton.disabled = true;
          }
        });
      </script>

    <!-- </div> -->
  </form>

  <?php include 'include/error.inc.php'; ?>

<?php
  } else {
    $_SESSION['error'] = "er ging iets mis. Pech!";
    header("location: index.php?page=dashboard");
  }
?>
