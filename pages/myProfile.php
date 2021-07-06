<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_POST["submit"])) {
	if ($_POST["password"] == $_POST["passwordwdh"]) {
		$query = $connection->prepare("UPDATE userdata SET password = :password WHERE username = :username");
		$hashedPassword = passwordHash($_POST["password"]);
		$query->bindParam(":password", $hashedPassword);
		$query->bindParam(":username", $_SESSION["username"]);
		$query->execute();
		
		echo '<script>toastr.success("Das Passwort wurde erfolgreich geändert!", "Erfolgreich!")</script>';
	}
	else
	{
		echo '<script>toastr.error("Die Passwörter stimmen nicht überein!", "Fehler!")</script>';
	}
}
?>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Passwort ändern</h6>
        </div>
        <div class="card-body">
			<div class="form-group">
				<form method="POST">
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Passwort" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="passwordwdh" placeholder="Passwort wdh." required>
					</div>
					<div class="form-group">
					</div>
					<button class="btn btn-success" name="submit">
						Passwort ändern
					</button>
				</form>
			</div>
        </div>
    </div>
</div>