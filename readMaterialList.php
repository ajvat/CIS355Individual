<?php
// filename: readMaterialList.php, Anthony Vatter, cis355, 2015-04-26
// Displays the contents of the Material List table and the correct buttons depending on the log in status
	 session_start();
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
?>
 
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Build List</h3>
            </div>
            <div class="row">
				<?php													
					if ($_SESSION["email"] == "loggedin") {
						echo '<p>';
							echo '<a href="createMaterial.php?id='.$id.'" class="btn btn-success">Add Material to Build</a>';
							echo ' ';
							echo '<a href="logout.php" class="btn btn-success">Logout</a>';
						echo '</p>';
					}
					else {
						echo '<p>';
							echo '<a href="login.php" class="btn btn-success">Login</a>';
						echo '</p>';
					}
				?>                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Block</th>
                          <th>Amount</th>
								  <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       $pdo = Database::connect();
                       $sql = 'SELECT material_list.count, block_type.name, material_list.material_list_TUID, block_type.block_TUID
							          FROM material_list 
										 INNER JOIN block_type 
										 ON material_list.block_TUID = block_type.block_TUID 
										 WHERE build_TUID = ' . $id;
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['name'] . '</td>'; 
                                echo '<td>'. $row['count'] . '</td>';
                                echo '<td width=250>';
												echo ' ';										  
										  if ($_SESSION["email"] == "loggedin") {

												echo '<a class="btn btn-success" href="updateMaterial.php?updateid='.$row['material_list_TUID'].'&id='.$id.'&block_TUID='.$row['block_TUID'].'">Update</a>';
												echo ' ';
												echo '<a class="btn btn-danger" href="deleteMaterial.php?deleteid='.$row['material_list_TUID'].'&id='.$id.'">Delete</a>';
										  }
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>