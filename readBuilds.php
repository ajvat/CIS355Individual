<?php
// filename: readBuilda.php, Anthony Vatter, cis355, 2015-04-26
// Displays the contents of the Build table and the correct buttons depending on the log in status
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

							echo '<a class="btn btn-success" href="createBuild.php?id='.$id.'">Create</a>';
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
                          <th>Title</th>
                          <th>Description</th>
								  <th>YouTube Link</th>
								  <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM build_details WHERE creator_TUID = ' . $id . ' ORDER BY creator_TUID DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['title'] . '</td>';
                                echo '<td>'. $row['description'] . '</td>';
										  echo '<td><a href="'. $row['youtube_link'] . '">'. $row['youtube_link'] . '</a></td>';
                                echo '<td width=300>';
												echo '<a class="btn btn-default" href="readMaterialList.php?id='.$row['build_TUID'].'">View Materials</a>';
												echo ' ';										  
										  if ($_SESSION["email"] == "loggedin") {

												echo '<a class="btn btn-success" href="updateBuild.php?buildid='.$row['build_TUID'].'&id='.$id.'">Update</a>';
												echo ' ';
												echo '<a class="btn btn-danger" href="deleteBuild.php?deleteid='.$row['build_TUID'].'&id='.$id.'">Delete</a>';
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