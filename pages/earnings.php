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
            <h6 class="m-0 font-weight-bold text-primary">Verdienste</h6>
        </div>
        <div class="card-body">
			<form method="POST">
				<div class="form-group">
					<select name="selectedTime" class="form-control" onchange="this.form.submit()">
						<option>Wähle einen Zeitraum...</option>
						<option value="1">Januar</option>
						<option value="2">Februar</option>
						<option value="3">März</option>
						<option value="4">April</option>
						<option value="5">Mai</option>
						<option value="6">Juni</option>
						<option value="7">Juli</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Dezember</option>
					</select>
				</div>
				
				<?php
					if (isset($_POST["selectedTime"]) && $_POST["selectedTime"] != "Wähle einen Zeitraum...") {
						$currentMonth = $_POST["selectedTime"];
						$monthName = $germanMonths[date("F", strtotime(date("d-$currentMonth-Y")))];
					} else {
						$currentMonth = date("m");
						$monthName = $germanMonths[date("F")];
					}
					
					$query = $connection->prepare("SELECT SUM(cash) as cash FROM income WHERE MONTH(date) = $currentMonth AND DAY(date) < 14");
					$query->execute();
					
					$result = $query->fetch(PDO::FETCH_OBJ);
					
					$query1 = $connection->prepare("SELECT SUM(cash) as cash FROM sells WHERE MONTH(date) = $currentMonth AND DAY(date) < 14");
					$query1->execute();
					
					$result1 = $query1->fetch(PDO::FETCH_OBJ);
					
					$query2 = $connection->prepare("SELECT SUM(cash) as cash FROM buys WHERE MONTH(date) = $currentMonth AND DAY(date) < 14");
					$query2->execute();
					
					$result2 = $query2->fetch(PDO::FETCH_OBJ);
					
					$alltimeCash = floor($result->cash + $result1->cash - $result2->cash);
					
					echo '
						<div class="form-group">
							<div class="small-box bg-success">
								<div class="inner">
									<h3>$'.number_format($alltimeCash, 0, ".", ".").'</h3>

									<p>Verdienste gesamt ('.$monthName.')</p>
								</div>
								<div class="icon">
									<i class="fas fa-money-bill-wave"></i>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="small-box bg-info">
								<div class="inner">
									<h3>$'.number_format($result1->cash, 0, ".", ".").'</h3>

									<p>Einnahmen ('.$monthName.')</</p>
								</div>
								<div class="icon">
									<i class="fas fa-arrow-up"></i>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="small-box bg-warning">
								<div class="inner">
									<h3>$'.number_format($result2->cash, 0, ".", ".").'</h3>

									<p>Ausgaben ('.$monthName.')</</p>
								</div>
								<div class="icon">
									<i class="fas fa-arrow-down"></i>
								</div>
							</div>
						</div>
					';
				?>
			</form>
        </div>
    </div>
</div>