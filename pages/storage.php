<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 4) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home">';
}

if (isset($_POST["submit"])) {
	if (isset($_POST["selectedAction"]) && $_POST["selectedAction"] != "Wähle eine Option...") {
		addStorageItem($_POST["selectedItem"], $_POST["itemCount"], $_POST["itemCash"], $_POST["selectedAction"]);
	}
}

if (isset($_POST["deleteBuy"])) {
	$query = $connection->prepare("DELETE FROM buys WHERE id = :id");
	$query->bindParam(":id", $_POST["deleteBuy"]);
	$query->execute();
	
	echo '<script>toastr.success("Logeintrag ('.$_POST["deleteBuy"].') erfolgreich gelöscht!", "Erfolgreich!")</script>';
}

if (isset($_POST["deleteSell"])) {
	$query = $connection->prepare("DELETE FROM sells WHERE id = :id");
	$query->bindParam(":id", $_POST["deleteSell"]);
	$query->execute();
	
	echo '<script>toastr.success("Logeintrag ('.$_POST["deleteSell"].') erfolgreich gelöscht!", "Erfolgreich!")</script>';
}
?>

<div class="col-xl-7 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lager</h6>
        </div>
        <div class="card-body">
			<form method="POST">
				<div class="form-group">
					<select id="selectedItem" name="selectedItem" class="form-control">
					<?php
						$query = $connection->prepare("SELECT * FROM storageItems");
						$query->execute();
						
						while ($result = $query->fetch(PDO::FETCH_OBJ))
						{
							echo '<option value="'.$result->name.'">'.$result->name.'</option>';
						}
					?>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control form-control-user" name="itemCount" placeholder="Anzahl Item" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control form-control-user" name="itemCash" placeholder="Gesamtwert Vio-V $" required>
				</div>
				<div class="form-group">
					<select id="selectedAction" name="selectedAction" class="form-control" required>
						<option>Wähle eine Option...</option>
						<option value="buys">gekauft</option>
						<option value="sells">verkauft</option>
					</select>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" name="submit">Absenden</button>
				</div>
			</form>
        </div>
    </div>
</div>

<div class="col-xl-5 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kassensturz</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-12 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <?php
                            $query = $connection->prepare("SELECT SUM(`cash`) as `sells` FROM `sells`");
                            $query->execute();

                            while ($result = $query->fetch(PDO::FETCH_OBJ)) {
                                $sells = $result->sells;
                                echo '<h3>'.number_format($result->sells, 0, ".", ".").'$</h3>';
                            }
                        ?>
                        <p>Einnahmen</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>

                <div class="small-box bg-danger">
                    <div class="inner">
                        <?php
                        $query = $connection->prepare("SELECT SUM(`cash`) as `buys` FROM `buys`");
                        $query->execute();

                        while ($result = $query->fetch(PDO::FETCH_OBJ)) {
                            $buys = $result->buys;
                            echo '<h3>'.number_format($result->buys, 0, ".", ".").'$</h3>';
                        }
                        ?>
                        <p>Augaben</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo number_format($sells - $buys, 0, ".", ".")."$"; ?></h3>

                        <p>Gewinn</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lager Logs (gekauft)</h6>
        </div>
        <div class="card-body">
			<form method="POST">
				<div class="form-group">
					<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Logeintrag</th>
							<th>Aktion</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = $connection->prepare("SELECT * FROM buys");
							$query->execute();
							
							while ($result = $query->fetch(PDO::FETCH_OBJ)) {
								echo '
									<tr>
										<td>'.getNameFromId($result->user).' hat am '.date("d.m.Y", strtotime($result->date)).' um '.date("H:i", strtotime($result->date)).' Uhr '.$result->amount.' x '.$result->item.' ('.number_format($result->cash, 0, ".", ".").') gekauft.</td>
										<td><button class="btn btn-danger" name="deleteBuy" value='.$result->id.'>Löschen</button></td>
									</tr>
								';
							}
						?>
					</tbody>
					</table>
				</div>
			</form>
        </div>
    </div>
</div>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lager Logs (verkauft)</h6>
        </div>
        <div class="card-body">
			<form method="POST">
				<div class="form-group">
					<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Logeintrag</th>
							<th>Aktion</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = $connection->prepare("SELECT * FROM sells");
							$query->execute();
							
							while ($result = $query->fetch(PDO::FETCH_OBJ)) {
								echo '
									<tr>
										<td>'.getNameFromId($result->user).' hat am '.date("d.m.Y", strtotime($result->date)).' um '.date("H:i", strtotime($result->date)).' Uhr '.$result->amount.' x '.$result->item.' ('.number_format($result->cash, 0, ".", ".").') verkauft.</td>
										<td><button class="btn btn-danger" name="deleteSell" value='.$result->id.'>Löschen</button></td>
									</tr>
								';
							}
						?>
					</tbody>
					</table>
				</div>
			</form>
        </div>
    </div>
</div>