<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/

require("./cfg/mysql.php");

$germanMonths = array(
	"January" => "Januar",
	"February" => "Februar",
	"March" => "März",
	"April" => "April",
	"May" => "Mai",
	"June" => "Juni",
	"July" => "Juli",
	"August" => "August",
	"September" => "September",
	"October" => "Oktober",
	"November" => "November",
	"December" => "Dezember",
);

$rankColor = array(
	0 => "#ad6ce6",
	1 => "#1d87cf",
	2 => "#1a769c",
	3 => "#cac21b",
	4 => "#ff5400",
	5 => "#ff0000"
);

function getRandomQuote() {
	$quotes = array(
		"Frei sein heißt, wählen können, wessen Sklave man sein will.",
		"In der Stadt lebt man zu seiner Unterhaltung, auf dem Lande zur Unterhaltung der anderen.",
		"Lass uns „Halt dein Maul!“ spielen, du darfst anfangen.",
		"Zu stark geschminkt und zu wenig bekleidet ist bei den Frauen immer ein Zeichen der Verzweiflung.",
		"Niemand ist so gut oder so schlecht, wie er während seiner Scheidung gemacht wird.",
		"Liebe auf den ersten Blick: Die am weitesten verbreitete Augenkrankheit.",
		"Kalorien sind kleine Tierchen die über Nacht die Kleidung enger nähen.",
		"Wer im Dunklen sitzt, zündet sich einen Traum an.",
	);
	
	echo $quotes[array_rand($quotes)];
}

function passwordHash($password)
{
    if ($password) {
        return strtoupper(hash("sha512", $password));
    }
}

function getUserId($name)
{
    if ($name) {
        global $connection;

        $query = $connection->prepare("SELECT id FROM userdata WHERE username = :username LIMIT 1");
        $query->bindParam(":username", $name);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->id;
        }
    }
}

function isLocked($id)
{
	if ($id) {
        global $connection;

        $query = $connection->prepare("SELECT isEligible FROM userdata WHERE id = :id LIMIT 1");
        $query->bindParam(":id", $id);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result->isEligible == 1) {
				return false;
			} else
				return true;
        }
    }
}

function getNameFromId($id)
{
    if ($id) {
        global $connection;

        $query = $connection->prepare("SELECT username FROM userdata WHERE id = :id LIMIT 1");
        $query->bindParam(":id", $id);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->username;
        }
    }
}

function getIdFromSearch($name)
{
	if ($name) {
        global $connection;

        $query = $connection->prepare("SELECT id FROM userdata WHERE username LIKE :name LIMIT 1");
        $query->bindValue(":name", "%".$name."%");
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->id;
        }
    }
}

function getRankFromId($id)
{
	if ($id) {
        global $connection;

        $query = $connection->prepare("SELECT rank FROM userdata WHERE id = :id LIMIT 1");
        $query->bindParam(":id", $id);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->rank;
        }
    }
}

function getActionId($name)
{
    if ($name) {
        global $connection;

        $query = $connection->prepare("SELECT id FROM actions WHERE name = :name LIMIT 1");
        $query->bindParam(":name", $name);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->id;
        }
    }
}

function getActionNameFromId($id)
{
    if ($id) {
        global $connection;

        $query = $connection->prepare("SELECT name FROM actions WHERE id = :id LIMIT 1");
        $query->bindParam(":id", $id);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->name;
        }
    }
}

function getActionPoints($id)
{
	if ($id) {
		global $connection;

        $query = $connection->prepare("SELECT points FROM actions WHERE id = :id LIMIT 1");
        $query->bindParam(":id", $id);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->points;
        }
	}
}

function getDatabaseActionName($name)
{
	if ($name) {
		$correctName = str_replace(" ", "_", $name);
		
		return $correctName;
	}
}

function getCorrectActionName($name)
{
	if ($name) {
		if ($name == "points")
			return "Gesamte Punkte";
		
		$correctName = str_replace("_", " ", $name);
		
		return $correctName;
	}
}

function checkLogin($username, $password)
{
    if ($username && $password) {
        global $connection;

        $query = $connection->prepare("SELECT username, password, rank, isEligible FROM userdata where username = :username");
        $query->bindParam(":username", $username);
        $query->execute();
        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
			
			if ($result->isEligible == 1) {
				if (passwordHash($password) == $result->password) {
					$_SESSION["username"] = $result->username;
					$_SESSION["rank"] = $result->rank;
					$_SESSION["isEligible"] = $result->isEligible;

					echo('<div class="alert alert-success alert-dismissible"><h6 class="alert-heading">Erfolgreich!</h6>Du wirst in kürze weitergeleitet!</div>');

					header("refresh:3;url=index.php?s=home");
				} else {
					echo('<div class="alert alert-danger alert-dismissible"><h6 class="alert-heading">Fehler!</h6>Das Passwort stimmt nicht!</div>');
				}
			} else {
				echo('<div class="alert alert-danger alert-dismissible"><h6 class="alert-heading">Fehler!</h6>Dieser Account existiert, ist aber für den Login nicht berechtigt.</div>');
			}
        } else {
            echo('<div class="alert alert-danger alert-dismissible"><h6 class="alert-heading">Fehler!</h6>Dieser Account ist nicht bekannt!</div>');
        }
    }
}

function getLobbyMembers($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT * FROM lobby_member WHERE lobby = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();
        while ($result = $query->fetch(PDO::FETCH_OBJ)) {
            $query1 = $connection->prepare("INSERT INTO finished_actions (action, lobby, date, creator, lobbyItem, lobbyCash, member) VALUES ('" . getLobbyAction($result->lobby) . "', '" . $result->lobby . "', '" . getLobbyDate($result->lobby) . "', '" . getLobbyCreator($result->lobby) . "', '".getLobbyItem($result->lobby)."', '" . getLobbyCash($result->lobby) . "', '" . $result->member . "')");
            $query1->execute();
        }
    }
}

function addMemberToAction($lobbyId, $userId)
{
    if ($lobbyId && $userId) {
        global $connection;

        $query = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $checkQuery = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId AND member = :memberId");
            $checkQuery->bindParam(":lobbyId", $lobbyId);
            $checkQuery->bindParam(":memberId", $userId);
            $checkQuery->execute();

            $checkCount = $checkQuery->rowCount();

            if ($checkCount == 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);

                if ($result) {
                    $query1 = $connection->prepare("INSERT INTO finished_actions (action, lobby, date, creator, member) VALUES ('" . $result->action . "', '" . $result->lobby . "', '" . $result->date . "', '" . $result->creator . "', '" . $userId . "')");
                    $query1->execute();

                    echo '<script>toastr.success("User erfolgreich hinzugefügt!", "Erfolgreich!")</script>';
                }
            }
        }
    }
}

function removeMemberFromAction($lobbyId, $userId)
{
    if ($lobbyId && $userId) {
        global $connection;

        $query = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId AND member = :memberId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->bindParam(":memberId", $userId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $deleteQuery = $connection->prepare("DELETE FROM finished_actions WHERE lobby = :lobbyId AND member = :memberId");
            $deleteQuery->bindParam(":lobbyId", $lobbyId);
            $deleteQuery->bindParam(":memberId", $userId);
            $deleteQuery->execute();

            echo '<script>toastr.success("User erfolgreich entfernt!", "Erfolgreich!")</script>';
        }
    }
}

function getLobbyAction($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT action FROM lobbys WHERE id = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->action;
        }
    }
}

function getLobbyCash($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT cash FROM lobbys WHERE id = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->cash;
        }
    }
}

function getLobbyItem($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT item FROM lobbys WHERE id = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->item;
        }
    }
}

function getLobbyDate($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT date FROM lobbys WHERE id = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->date;
        }
    }
}

function getLobbyCreator($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT creator FROM lobbys WHERE id = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result->creator;
        }
    }
}

function showLobbys()
{
    global $connection;

    $query = $connection->prepare("SELECT * FROM lobbys");
    $query->execute();

    $count = $query->rowCount();

    if ($count > 0) {
        while ($result = $query->fetch(PDO::FETCH_OBJ)) {
            $checkQuery = $connection->prepare("SELECT * FROM lobbys WHERE '" . date("Y-m-d H:i:s", strtotime($result->date . " +" . $result->duration . " minutes")) . "' > NOW() AND id = :id");
            $checkQuery->bindParam(":id", $result->id);
            $checkQuery->execute();

            $checkCount = $checkQuery->rowCount();

            if ($checkCount > 0) {
                while ($result = $checkQuery->fetch(PDO::FETCH_OBJ)) {
                    $memberQuery = $connection->prepare("SELECT * FROM lobby_member WHERE lobby = :id");
                    $memberQuery->bindParam(":id", $result->id);
                    $memberQuery->execute();

                    $count = $memberQuery->rowCount();

                    if ($count > 0) {
						if ($result->item == "NONE") {
							$correctPrice = '$' . number_format($result->cash, 0, ".", ".");
						} else {
							$correctPrice = "$result->cash x $result->item";
						}
						
                        echo '
							<div class="alert alert-info alert-dismissible">
								<h6 class="alert-heading font-weight-bold">Lobby (' . getActionNameFromId($result->action) . ') Erstellt von ' . getNameFromId($result->creator) . ' ' . date_format(date_create($result->date), "d.m.Y | H:i") . ' - ' . date("H:i", strtotime($result->date . " +" . $result->duration . " minutes")) . ' Uhr | Erbeutet: '.$correctPrice.'</h6>
								Teilnehmer: <br>
						';
                        while ($memberResult = $memberQuery->fetch(PDO::FETCH_OBJ)) {
                            echo '
								' . getNameFromId($memberResult->member) . '<br>
							';
                        }
                        echo '
							<form method="POST">
								<br><button class="btn btn-primary" value=' . $result->id . ' name="joinLobby">Lobby beitreten</button>
								<button class="btn btn-danger" value=' . $result->id . ' name="leaveLobby">Lobby verlassen</button><br>
							</form>
						</div>
						';
                    }
                }
            } else {
                deleteLobby($result->id);
            }
        }
    }
}

function createNewLobby($actionId, $duration, $lobbyCash, $creator)
{
    if ($actionId && $duration && $lobbyCash && $creator) {
        global $connection;

        $query = $connection->prepare("SELECT creator FROM lobbys WHERE creator = :creator LIMIT 1");
        $query->bindParam(":creator", $creator);
        $query->execute();

        $count = $query->rowCount();

        if ($count == 0) {
            $query = $connection->prepare("INSERT INTO lobbys (action, creator, cash, duration) VALUES ($actionId, $creator, $lobbyCash, $duration)");

            if ($query->execute()) {
                $query = $connection->prepare("INSERT INTO lobby_member (lobby, member) VALUES (:lobbyId, :creatorId)");
                $lastId = $connection->lastInsertId();
                $query->bindParam(":lobbyId", $lastId);
                $query->bindParam(":creatorId", $creator);
                $query->execute();

                echo '<div class="alert alert-info alert-dismissible"><h6 class="alert-heading">Erfolgreich!</h6>Lobby erfolgreich erstellt!</div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible"><h6 class="alert-heading">Fehler!</h6>Du kannst nur eine Lobby erstellen!</div>';
        }
    }
}

function createNewLobbyWithItem($actionId, $duration, $lobbyItem, $itemAmount, $creator)
{
	if ($actionId && $duration && $lobbyItem && $itemAmount && $creator) {
        global $connection;

        $query = $connection->prepare("SELECT creator FROM lobbys WHERE creator = :creator LIMIT 1");
        $query->bindParam(":creator", $creator);
        $query->execute();

        $count = $query->rowCount();

        if ($count == 0) {
            $query = $connection->prepare("INSERT INTO lobbys (action, creator, item, cash, duration) VALUES ($actionId, $creator, '".$lobbyItem."', $itemAmount, $duration)");

            if ($query->execute()) {
                $query = $connection->prepare("INSERT INTO lobby_member (lobby, member) VALUES (:lobbyId, :creatorId)");
                $lastId = $connection->lastInsertId();
                $query->bindParam(":lobbyId", $lastId);
                $query->bindParam(":creatorId", $creator);
                $query->execute();

                echo '<div class="alert alert-info alert-dismissible"><h6 class="alert-heading">Erfolgreich!</h6>Lobby erfolgreich erstellt!</div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible"><h6 class="alert-heading">Fehler!</h6>Du kannst nur eine Lobby erstellen!</div>';
        }
    }
}

function joinLobby($lobbyId, $joiner)
{
    if ($lobbyId && $joiner) {
        global $connection;

        $query = $connection->prepare("SELECT member FROM lobby_member WHERE member = :joiner AND lobby = :lobbyId LIMIT 1");
        $query->bindParam(":joiner", $joiner);
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

        $count = $query->rowCount();

        if ($count == 0) {
            $query = $connection->prepare("INSERT INTO lobby_member (lobby, member) VALUES ($lobbyId, $joiner)");
			$query->execute();
        }
    }
}

function leaveLobby($lobbyId, $leaver)
{
    if ($lobbyId && $leaver) {
        global $connection;

        $query = $connection->prepare("DELETE FROM lobby_member WHERE member = :leaver AND lobby = :lobbyId");
        $query->bindParam(":leaver", $leaver);
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();
    }
}

function deleteLobby($lobbyId)
{
    if ($lobbyId) {
        global $connection;

        getLobbyMembers($lobbyId);

        $query = $connection->prepare("DELETE FROM lobbys WHERE id = :id");
        $query->bindParam(":id", $lobbyId);
        $query->execute();

        $query = $connection->prepare("DELETE FROM lobby_member WHERE lobby = :id");
        $query->bindParam(":id", $lobbyId);
        $query->execute();
    }
}

function receiveFinishedActions()
{
    global $connection;
	
	if (isset($_POST["changeCash"])) {
        changeLobbyCash(intval($_POST["changeCash"]), intval($_POST["newLobbyCash"]));
    }

    if (isset($_POST["addUser"])) {
        foreach ($_POST["selectedUser"] as $addedUser) {
            addMemberToAction(intval($_POST["addUser"]), getUserId($addedUser));
        }
    }

    if (isset($_POST["removeUser"])) {
        foreach ($_POST["selectedUser"] as $addedUser) {
            removeMemberFromAction(intval($_POST["removeUser"]), getUserId($addedUser));
        }
    }

    if (isset($_POST["approveLobby"])) {
        approveLobby(intval($_POST["approveLobby"]));
    }

    if (isset($_POST["declineLobby"])) {
        declineLobby($_POST["declineLobby"], false);
    }

    $query = $connection->prepare("SELECT * FROM finished_actions GROUP BY lobby HAVING count(*) > 0");
    $query->execute();

    while ($result = $query->fetch(PDO::FETCH_OBJ)) {
        $checkQuery = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId");
        $checkQuery->bindParam(":lobbyId", $result->lobby);
        $checkQuery->execute();
		
		if ($result->lobbyItem == "NONE") {
			$correctPrice = '$' . number_format($result->lobbyCash, 0, ".", ".");
		} else {
			$correctPrice = "$result->lobbyCash x $result->lobbyItem";
		}
		
        echo '
		<div class="alert alert-primary alert-dismissible">
			<h6 class="alert-heading font-weight-normal text-dark">Lobby ' . $result->lobby . ' (Aktion: ' . getActionNameFromId($result->action) . ' | Datum: ' . date("d.m.Y - H:i", strtotime($result->date)) . ' | Erstellt von: ' . getNameFromId($result->creator) . ' | Erbeutet: ' . $correctPrice . ')</h6>
		';

        while ($checkResult = $checkQuery->fetch(PDO::FETCH_OBJ)) {
            echo '
				' . getNameFromId($checkResult->member) . '<br>
			';
        }

        echo '
			<form method="POST">
				<br><select id="selectedUser[]" name="selectedUser[]" class="form-control" multiple>';
        $query1 = $connection->prepare("SELECT username FROM userdata WHERE isEligible = '1'");
        $query1->execute();

        while ($userResult = $query1->fetch(PDO::FETCH_OBJ)) {
            echo '<option>' . $userResult->username . '</option>';
        }
        echo '
				</select>
				<br><input type="text" class="form-control" name="newLobbyCash" placeholder='.number_format($result->lobbyCash, 0, ".", ".").'>
				<br><button class="btn btn-info" value=' . $result->lobby . ' name="addUser">User hinzufügen</button>
				<button class="btn btn-info" value=' . $result->lobby . ' name="removeUser">User entfernen</button>
				<button class="btn btn-info" value=' . $result->lobby . ' name="changeCash">Beute ändern</button><br>
				<br><button class="btn btn-success" value=' . $result->lobby . ' name="approveLobby">Lobby freigeben</button>
				<button class="btn btn-danger" value=' . $result->lobby . ' name="declineLobby">Lobby löschen</button><br>
			</form>
		</div>
		';
    }
}

function getLobbyIncome($lobbyId)
{
	if ($lobbyId) {
        global $connection;

        $query = $connection->prepare("SELECT lobbyCash FROM finished_actions WHERE lobby = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

		$count = $query->rowCount();
		
		if ($count > 0) {
			while($result = $query->fetch(PDO::FETCH_OBJ)) {
				if ($result->lobbyCash != 0) {
					return $result->lobbyCash;
				}
			}
		}
    }
}

function declineLobby($lobbyId, $state)
{
    if ($lobbyId) {
        global $connection;
		
		$incomeQuery = $connection->prepare("INSERT INTO income (lobby, cash, date) VALUES ($lobbyId, '".getLobbyIncome($lobbyId)."', NOW())");
		$incomeQuery->execute();

        $query = $connection->prepare("DELETE FROM finished_actions WHERE lobby = :lobbyId");
        $query->bindParam(":lobbyId", $lobbyId);
        $query->execute();

		if (!$state)
			echo '<script>toastr.success("Die Lobby (' . $lobbyId . ') wurde erfolgreich gelöscht!", "Erfolgreich!")</script>';
    }
}

function approveLobby($lobbyId)
{
	if ($lobbyId) {
		global $connection;
		
		$query = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId");
		$query->bindParam(":lobbyId", $lobbyId);
		$query->execute();
		
		$count = $query->rowCount();
		
		if ($count > 0) {
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$statsQuery = $connection->prepare("UPDATE statistics SET points = points + '".intval(getActionPoints($result->action))."', ".getDatabaseActionName(getActionNameFromId($result->action))." = ".getDatabaseActionName(getActionNameFromId($result->action))." + 1 WHERE uid = '".$result->member."'");
				$statsQuery->execute();
				
				if ($result->lobbyItem != "NONE") {
					$storageQuery = $connection->prepare("INSERT INTO buys (user, item, amount, cash, date) VALUES ('0', '".$result->lobbyItem."', '".$result->lobbyCash."', '0', NOW())");
					$storageQuery->execute();
				}
				
				declineLobby($result->lobby, true);
			}
			
			echo '<script>toastr.success("Die Lobby wurde erfolgreich freigegeben!", "Erfolgreich!")</script>';
		}
	}
}

function changeLobbyCash($lobbyId, $cash)
{
	if ($lobbyId) {
		global $connection;
		
		$query = $connection->prepare("SELECT * FROM finished_actions WHERE lobby = :lobbyId");
		$query->bindParam(":lobbyId", $lobbyId);
		$query->execute();
		
		$count = $query->rowCount();
		
		if ($count > 0) {
			while ($result = $query->fetch(PDO::FETCH_OBJ)) {
				$statsQuery = $connection->prepare("UPDATE finished_actions SET lobbyCash = :newLobbyCash WHERE creator = '".$result->creator."'");
				$statsQuery->bindParam(":newLobbyCash", $cash);
				$statsQuery->execute();
			}
			
			echo '<script>toastr.success("Die Beute wurde erfolgreich angepasst!", "Erfolgreich!")</script>';
		}
	}
}

function addStorageItem($item, $itemCount, $itemCash, $action)
{
	if ($item && $itemCash && $itemCash && $action) {
		if (isset($_SESSION["username"])) {
			global $connection;
			
			$query = $connection->prepare("INSERT INTO $action (user, item, amount, cash, date) VALUES (:user, :item, :amount, :cash, '".date("Y-m-d H:i:s")."')");
			$query->bindValue(":user", getUserId($_SESSION["username"]));
			$query->bindParam(":item", $item);
			$query->bindParam(":amount", $itemCount);
			$query->bindParam(":cash", $itemCash);
			$query->execute();
			
			echo '<script>toastr.success("Es hat alles geklappt!", "Erfolgreich!")</script>';
		}
	}
}