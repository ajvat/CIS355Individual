<?php
// filename: deleteMaterial.php, Anthony Vatter, cis355, 2015-04-26
// Prompts the user whether or not they want to delete the selected record and does so accordingly
    require 'database.php';
	 
    if ( !empty($_GET['deleteid'])) {
        $deleteid = $_REQUEST['deleteid'];
    }
     
	 if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
      
    if ( !empty($_POST)) {
        // keep track post values
        $deleteid = $_POST['deleteid'];
		  $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM material_list WHERE material_list_TUID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($deleteid));
        Database::disconnect();
        header("Location: readMaterialList.php?id=$id");
         
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
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete a Build</h3>
                    </div>
                     
                    <form class="form-horizontal" action="deleteMaterial.php" method="post">
                      <input type="hidden" name="deleteid" value="<?php echo $deleteid;?>"/>
							 <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn btn-default" href="readMaterialList.php?id=<?php echo $id?>">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>