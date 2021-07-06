<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 4) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home">';
}
?>

<div class="col-xl-7 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Beteiligungsliste</h6>
        </div>
        <div class="card-body">
            <form method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Spielername" required>
                </div>
				<div class="form-group">
					<button class="btn btn-primary" name="submit">Suchen</button>
				</div>
				<?php
					if (isset($_POST["submit"])) {
						if (isset($_POST["username"])) {
							$query = $connection->prepare("SELECT * FROM statistics WHERE uid = :userId");
							$getCorrectId = getIdFromSearch($_POST["username"]);
							$query->bindParam(":userId", $getCorrectId);
							$query->execute();
							
							$count = $query->rowCount();
							
							if ($count > 0) { ?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Aktion</th>
											<th>Punkte/Anzahl</th>
										</tr>
									</thead>
									<?php
									while ($result = $query->fetch(PDO::FETCH_OBJ)) {
										foreach ($result as $key => $value) {
											if ($key != "uid") {
												echo '
													<tr>
														<th>'.getCorrectActionName($key).'</th>
														<td>'.$value.'</td>
													</tr>
												';
											} else {
												echo '
													<tr>
														<th>Name</th>
														<td>'.getNameFromId($value).'</td>
													</tr>
												';
											}
										}
									} ?>
								</table> <?php
							}
						}
					}
				?>
			</form>
        </div>
    </div>
</div><br>

<div class="col-xl-7 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Punkteliste</h6>
        </div>
        <div class="card-body">
			<?php
				$query = $connection->prepare("SELECT uid, points FROM statistics ORDER BY points DESC");
				$query->execute();
				
				$count = $query->rowCount();
				
				if ($count > 0) { ?>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Punkte</th>
							</tr>
						</thead>
						<?php
						while ($result = $query->fetch(PDO::FETCH_OBJ)) {
							if (!isLocked($result->uid)) {
								if ($result->uid != 1) {
									echo '
										<tr>
											<td style="color: '.$rankColor[getRankFromId($result->uid)].'">'.getNameFromId($result->uid).'</td>
											<td>'.$result->points.'</td>
										</tr>
									';
								}
							}
						} ?>
					</table> <?php
				}
			?>
        </div>
    </div>
</div>