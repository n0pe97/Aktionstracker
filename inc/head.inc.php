<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

if (isset($_SESSION["username"])) {
    $query = $connection->prepare("SELECT password, rank, isEligible FROM userdata WHERE username = :username");
    $query->bindParam(":username", $_SESSION["username"]);
    $query->execute();

    $count = $query->rowCount();

    if ($count > 0) {
        $result = $query->fetch(PDO::FETCH_OBJ);

		if ($result->isEligible == 1) {
			$_SESSION["rank"] = $result->rank;
		} else {
			unset($_SESSION["username"]);
		}
    } else {
        unset($_SESSION["rank"]);
    }
}