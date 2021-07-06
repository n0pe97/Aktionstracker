<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_POST["joinLobby"])) {
    joinLobby(intval($_POST["joinLobby"]), getUserId($_SESSION["username"]));
} else if (isset($_POST["leaveLobby"])) {
    leaveLobby(intval($_POST["leaveLobby"]), getUserId($_SESSION["username"]));
}

$query = $connection->prepare("SELECT * FROM lobbys");
$query->execute();

$count = $query->rowCount();

if ($count == 0) {
	$deleteQuery = $connection->prepare("DELETE FROM lobby_member");
	$deleteQuery->execute();
}
?>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lobby erstellen</h6>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <?php
                    if (isset($_POST["submit"])) {
                        if (isset($_POST["selectedAction"]) && isset($_POST["selectedTime"]) && isset($_POST["lobbyCash"]) && isset($_POST["selectedItem"])) {
							if ($_POST["selectedItem"] == "Waehle ein Item...") {
								createNewLobby(intval($_POST["selectedAction"]), intval($_POST["selectedTime"]), intval($_POST["lobbyCash"]), getUserId($_SESSION["username"]));
							}
							else {
								createNewLobbyWithItem(intval($_POST["selectedAction"]), intval($_POST["selectedTime"]), $_POST["selectedItem"], intval($_POST["lobbyCash"]), getUserId($_SESSION["username"]));
							}
                        }
                    }
                    ?>
                </div>
                <div class="form-group">
                    <select id="selectedAction" name="selectedAction" class="form-control">
                        <?php
                        $query = $connection->prepare("SELECT * FROM actions");
                        $query->execute();

                        while ($result = $query->fetch(PDO::FETCH_OBJ)) {
                            echo '<option value=' . $result->id . '>' . $result->name . ' (' . $result->points . ')</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <select id="selectedTime" name="selectedTime" class="form-control">
                        <option value="5">5 Minuten</option>
                        <option value="10">10 Minuten</option>
                        <option value="15">15 Minuten</option>
                        <option value="20">20 Minuten</option>
                        <option value="25">25 Minuten</option>
                        <option value="30">30 Minuten</option>
                    </select>
                </div>
				<div class="form-group">
					<select id="selectedItem" name="selectedItem" class="form-control">
						<?php
                        $query = $connection->prepare("SELECT * FROM storageItems");
                        $query->execute();

                        while ($result = $query->fetch(PDO::FETCH_OBJ)) {
                            echo '<option value="' . $result->name . '">' . $result->name . '</option>';
                        }
                        ?>
					</select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lobbyCash" id="lobbyCash" placeholder="Beute (Ohne Komma angeben)">
                </div>
                <button class="btn btn-info" name="submit">Lobby erstellen</button>
            </form>
        </div>
    </div>
</div>

<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hilfsassistent "Günther"</h6>
        </div>
        <div class="card-body">
            <label>Aktuelle Lobbys</label>
            <div class="form-group">
                <?php
                showLobbys();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
	$("#selectedItem").on("change", function() {
		if ($(this).val() !== "Waehle ein Item...")
			$("#lobbyCash").attr("placeholder", "Anzahl (Ohne Komma angeben)");
		else
			$("#lobbyCash").attr("placeholder", "Beute (Ohne Komma angeben)");
	});
</script>