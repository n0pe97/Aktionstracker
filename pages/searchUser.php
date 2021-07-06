<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 4) {
	echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home"> ';
}
?>

<div class="col-xl-12 col-lg-7">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Userdaten bearbeiten</h6>
		</div>
		<div class="card-body">
			<div class="form-group">
				<?php
					if (isset($_POST["changeName"]))
					{
						if (isset($_POST["submit"]))
						{
							$query = $connection->prepare("SELECT * FROM userdata WHERE username = :username");
							$query->bindParam(":username", $_POST["changeName"]);
							$query->execute();
							
							$result = $query->fetch(PDO::FETCH_OBJ);
							
							foreach ($result as $key => $val)
							{
								if ($key != "username" && $_POST[$key] != $val)
								{
									$updateQuery = $connection->prepare("UPDATE userdata SET ".$key."='".$_POST[$key]."' WHERE username = '".$_POST["changeName"]."'");
									$updateQuery->execute();
								}
							}
							
							echo '<script>toastr.success("Daten erfolgreich geändert!", "Erfolgreich!")</script>';
						}
						
						if (isset($_POST["lockUser"]))
						{
							if (isset($_SESSION["rank"]) || $_SESSION["rank"] >= 4)
							{
								$_SESSION["deletedUserName"] = $_POST["changeName"];
							
								$query = $connection->prepare("UPDATE userdata SET isEligible = 0 WHERE username = :username");
								$query->bindParam(":username", $_SESSION["deletedUserName"]);
								$query->execute();
								
								echo '<div class="alert alert-info">User ('.$_SESSION["deletedUserName"].') erfolgreich gesperrt.</div>';
								
								unset($_SESSION["deletedUserName"]);
							}
						}
					}
				?>
				<form method="POST">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Wert</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query1 = $connection->prepare("SELECT * FROM userdata WHERE username = :username");
								$query1->bindParam(":username", $_POST["searchingName"]);
								$query1->execute();
								
								$result1 = $query1->fetch(PDO::FETCH_OBJ);
								
								if (is_array($result1) || is_object($result1))
								{
									foreach ($result1 as $key => $val)
									{
										echo '
											<tr>
												<th>'.$key.'</th>
												<th><input type="text" class="form-control form-control-user" value="'.$val.'" name="'.$key.'" /></th>
											</tr>'
										;
									}
								}
							?>
						</tbody>
					</table>
					<input type="hidden" name="changeName" value="<?php echo $_POST["searchingName"] ?>" />
					<button class="btn btn-primary btn-user btn-block bg-gradient-success" name="submit">Speichern</button></br>
					<button class="btn btn-primary btn-user btn-block bg-gradient-danger" name="lockUser">User sperren</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="col-xl-12 col-lg-7">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Punkte bearbeiten</h6>
		</div>
		<div class="card-body">
			<div class="form-group">
				<?php
					if (isset($_POST["changeName"]))
					{
						if (isset($_POST["submit1"]))
						{
							$query = $connection->prepare("SELECT * FROM statistics WHERE uid = :userId");
							$query->bindValue(":userId", getUserId($_POST["changeName"]));
							$query->execute();
							
							$result = $query->fetch(PDO::FETCH_OBJ);
							
							foreach ($result as $key => $val)
							{
								if ($key != "uid" && $_POST[$key] != $val)
								{
									$updateQuery = $connection->prepare("UPDATE statistics SET ".$key."='".$_POST[$key]."' WHERE uid = '".getUserId($_POST["changeName"])."'");
									$updateQuery->execute();
								}
							}
							
							echo '<script>toastr.success("Daten erfolgreich geändert!", "Erfolgreich!")</script>';
						}
					}
				?>
				<form method="POST">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Wert</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query1 = $connection->prepare("SELECT * FROM statistics WHERE uid = :userId");
								$query1->bindValue(":userId", getUserId($_POST["searchingName"]));
								$query1->execute();
								
								$result1 = $query1->fetch(PDO::FETCH_OBJ);
								
								if (is_array($result1) || is_object($result1))
								{
									foreach ($result1 as $key => $val)
									{
										echo '
											<tr>
												<th>'.$key.'</th>
												<th><input type="text" class="form-control form-control-user" value="'.$val.'" name="'.$key.'" /></th>
											</tr>'
										;
									}
								}
							?>
						</tbody>
					</table>
					<input type="hidden" name="changeName" value="<?php echo $_POST["searchingName"] ?>" />
					<button class="btn btn-primary btn-user btn-block bg-gradient-success" name="submit1">Speichern</button>
				</form>
			</div>
		</div>
	</div>
</div>