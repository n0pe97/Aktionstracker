<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/
?>
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">Deine Statistik</h5>
        </div>
        <div class="card-body">
            <?php
			$query = $connection->prepare("SELECT * FROM statistics WHERE uid = :userId");
			$getCorrectId = getIdFromSearch($_SESSION["username"]);
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
			?>
        </div>
    </div>
</div>