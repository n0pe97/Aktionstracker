<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["rank"]) && $_SESSION["rank"] < 3) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php?s=home">';
}
?>

<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lobby freigeben</h6>
        </div>
        <div class="card-body">
            <label>Freizugebende Lobbys</label>
            <?php
            receiveFinishedActions();
            ?>
        </div>
    </div>
</div>