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
            <h6 class="m-0 font-weight-bold text-primary">User bearbeiten</h6>
        </div>
        <div class="card-body">
			<div class="form-group">
				<form action="index.php?s=searchUser" method="POST">
					<p><input type="text" class="form-control form-control-user" id="searchingName" name="searchingName" placeholder="Spielername" required></p>
					<button class="btn btn-primary btn-user btn-block bg-gradient-success" name="submit">Spieler suchen</button>
				</form>
			</div>
        </div>
    </div>
</div>