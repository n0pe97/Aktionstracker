<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 4) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home">';
}
?>

<div class="col-xl-12 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
        </div>
        <div class="card-body">			
			<?php
				$query = $connection->prepare("SELECT SUM(Pacific_Bank) AS pacifik, SUM(Fleeca_Bank) AS fleeca, SUM(Ammunation_Raub) AS ammu, SUM(Waffentruck) AS wt, SUM(Asservatentruck) AS at, SUM(Drogentruck) AS dt, SUM(FIB_Raub) AS fib, SUM(Gangshop_auffuellen) AS gang_fill, SUM(Gangshop_attacken) AS gang_attack, SUM(Gangshop_deffen) AS gang_deff, SUM(Gangwar_attacken) AS gw_attack, SUM(Gangwar_deffen) AS gw_deff, SUM(Abgestuerzter_Heli) AS heli, SUM(Humane_Labs_Raub) AS humane FROM statistics");
				$query->execute();
				
				$count = $query->rowCount();
				
				if ($count > 0) { ?>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Aktion</th>
								<th>Anzahl (Gesamt)</th>
							</tr>
						</thead>
						<?php
						$result = $query->fetch(PDO::FETCH_OBJ);
							echo '
								<tr>
									<td>Pacific Bank</td>
									<td>'.$result->pacifik.'</td>
								</tr>
								<tr>
									<td>Fleeca Bank</td>
									<td>'.$result->fleeca.'</td>
								</tr>
								<tr>
									<td>Ammunation Raub</td>
									<td>'.$result->ammu.'</td>
								</tr>
								<tr>
									<td>Waffentruck</td>
									<td>'.$result->wt.'</td>
								</tr>
								<tr>
									<td>Asservatentruck</td>
									<td>'.$result->at.'</td>
								</tr>
								<tr>
									<td>Drogentruck</td>
									<td>'.$result->dt.'</td>
								</tr>
								<tr>
									<td>FIB Raub</td>
									<td>'.$result->fib.'</td>
								</tr>
								<tr>
									<td>Gangshop auffüllen</td>
									<td>'.$result->gang_fill.'</td>
								</tr>
								<tr>
									<td>Gangshop attacken</td>
									<td>'.$result->gang_attack.'</td>
								</tr>
								<tr>
									<td>Gangshop deffen</td>
									<td>'.$result->gang_deff.'</td>
								</tr>
								<tr>
									<td>Gangwar attacken</td>
									<td>'.$result->gw_attack.'</td>
								</tr>
								<tr>
									<td>Gangwar deffen</td>
									<td>'.$result->gw_deff.'</td>
								</tr>
								<tr>
									<td>Abgestuerzter Heli</td>
									<td>'.$result->heli.'</td>
								</tr>
								<tr>
									<td>Humane Labs Raub</td>
									<td>'.$result->humane.'</td>
								</tr>
							';
						?>
					</table> <?php
				}
			?>
        </div>
    </div>
</div>