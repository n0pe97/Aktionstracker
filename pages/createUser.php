<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 4) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home">';
}
?>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User erstellen</h6>
        </div>
        <div class="card-body">
			<form method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Benutzername" required>
                </div>
				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
				<div class="form-group">
					<button class="btn btn-success" name="submit">Account anlegen</button>
                </div>
			</form>
			<?php
			if (isset($_POST["submit"])) {
				$checkQuery = $connection->prepare("SELECT * FROM userdata WHERE username = :username");
				$checkQuery->bindParam(":username", $_POST["username"]);
				$checkQuery->execute();
				
				$checkCount = $checkQuery->rowCount();
				
				if ($checkCount == 0) {
					$query = $connection->prepare("INSERT INTO userdata (username, password) VALUES (:username, :password)");
					$query->bindValue(":username", $_POST["username"]);
					$query->bindValue(":password", passwordHash($_POST["password"]));
					$query->execute();
					
					$lastId = $connection->lastInsertId();
					
					$query1 = $connection->prepare("INSERT INTO statistics (uid) VALUES (:lastId)");
					$query1->bindValue(":lastId", $lastId);
					$query1->execute();
					
					echo '<script>toastr.success("Account ('.$_POST["username"].') erfolgreich angelegt!", "Erfolgreich!")</script>';
				} else {
					echo '<script>toastr.error("Es existiert bereits ein Account mit diesem Namen!", "Fehler!")</script>';
				}
			}
			?>
        </div>
    </div>
</div>