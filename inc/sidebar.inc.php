<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="?s=home" class="brand-link">
        <img src="<?php echo $config["logo"]; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $config["name"]; ?></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $config["logo"]; ?>"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="?s=myProfile"
                   class="d-block"><?php if (isset($_SESSION["username"]) && isset($_SESSION["rank"])) {
                        echo $_SESSION["username"] . " (Rang " . $_SESSION["rank"] . ")";
                    } ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Startseite</li>
                <li class="nav-item">
                    <a href="?s=home" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                </li>

                <li class="nav-header">Aktionstracker</li>
                <li class="nav-item">
                    <a href="?s=showPoints" class="nav-link">
                        <i class="nav-icon fas fa-info"></i>
                        <p>Punktesystem</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?s=addAction" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Lobbysystem</p>
                    </a>
                </li>
                </li>

                <?php
                if (isset($_SESSION["rank"]) && $_SESSION["rank"] >= $config["lobbyPermission"]) {
                    echo '
						<li class="nav-header">Freigabe</li>
							<li class="nav-item">
								<a href="?s=approveAction" class="nav-link">
									<i class="nav-icon fas fa-users-cog"></i>
									<p>Aktionen freigeben</p>
								</a>
							</li>
						</li>
					';
                }
                ?>

                <?php
                if (isset($_SESSION["rank"]) && $_SESSION["rank"] >= $config["leaderarea"]) {
                    echo '
						<li class="nav-header">Leaderarea</li>
							<li class="nav-item">
								<a href="?s=userStats" class="nav-link">
									<i class="nav-icon fas fa-user-tag"></i>
									<p>Beteiligungsliste</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="?s=stats" class="nav-link">
									<i class="nav-icon fas fa-chart-line"></i>
									<p>Statistik</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="?s=storage" class="nav-link">
									<i class="nav-icon fas fa-archive"></i>
									<p>Lager</p>
								</a>
							</li>
						</li>

						<li class="nav-header">User Verwaltung</li>
							<li class="nav-item">
								<a href="?s=createUser" class="nav-link">
									<i class="nav-icon fas fa-user-plus"></i>
									<p>User erstellen</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="?s=manageUser" class="nav-link">
									<i class="nav-icon fas fa-user-cog"></i>
									<p>User bearbeiten</p>
								</a>
							</li>
						</li>
					';
                }
                ?>
            </ul>
        </nav>
    </div>
</aside>