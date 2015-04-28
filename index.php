<!DOCTYPE html>
<! filename: index.php, Anthony Vatter, cis355, 2015-04-26 >
<! Displays the contents of the creator table and the correct buttons depending on the log in status >
<html lang="en">


<head>
    <meta charset="utf-8">
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Creator List</h3>
            </div>
            <div class="row">
				<?php								
				 	session_start();					
					if ($_SESSION["email"] == "loggedin") {
						echo '<p>';
							echo '<a href="createCreator.php" class="btn btn-success">Create</a>';
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
                          <th>Name</th>
                          <th>YouTube Link</th>
                          <th>Twitter Link</th>
                          <th>Facebook Link</th>
								  <th># of Builds</th>
								  <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
							  $pdo2 = Database::connect();
                       $sql = 'SELECT * FROM creator ORDER BY name ASC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['name'] . '</td>';
                                echo '<td><a href="'. $row['youtube_link'] . '">'. $row['youtube_link'] . '</a></td>';
                                echo '<td><a href="'. $row['twitter_link'] . '">'. $row['twitter_link'] . '</a></td>';
										  echo '<td><a href="'. $row['facebook_link'] . '">'. $row['facebook_link'] . '</a></td>';
										  $query = 'SELECT COUNT(*) FROM build_details WHERE creator_TUID = '. $row['creator_TUID'];
										  $count = 0;
										  foreach ($pdo2->query($query) as $stuff) {
											  $count = $stuff[0];
										  }
										  echo '<td>' . $count . '</td>';
                                echo '<td width=300>';
												echo '<a class="btn btn-default" href="readBuilds.php?id='.$row['creator_TUID'].'">View Builds</a>';
												echo ' ';										  
										  if ($_SESSION["email"] == "loggedin") {

												echo '<a class="btn btn-success" href="updateCreator.php?id='.$row['creator_TUID'].'">Update</a>';
												echo ' ';
												echo '<a class="btn btn-danger" href="deleteCreator.php?id='.$row['creator_TUID'].'">Delete</a>';
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