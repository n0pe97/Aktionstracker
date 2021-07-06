<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/
?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Punktesystem</h3>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Aktion</th>
                    <th>Punkte</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = $connection->prepare("SELECT * FROM actions ORDER BY points DESC");
                $query->execute();

                $count = $query->rowCount();

                if ($count > 0) {
                    while ($result = $query->fetch(PDO::FETCH_OBJ)) {
                        echo '
						<tr>
							<td>' . $result->name . '</td>
							<td>' . $result->points . '</td>
						</tr>
					';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>