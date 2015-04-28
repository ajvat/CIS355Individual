<?php
// filename: createMaterial.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to create a new material
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	 
	 if ( null==$id ) {
        header("Location: readMaterialList.php?id=$id");
    }
    if ( !empty($_POST)) {
        // keep track validation errors
        $countError = null;
         
        // keep track post values
        $count = $_POST['count'];
        $block_TUID = $_POST['block_TUID'];
		  
		  $valid = true;
        if (empty($count)) {
            $countError = 'Please enter count';
            $valid = false;
        }
			
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO material_list (count,build_TUID,block_TUID) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($count,$id,$block_TUID));
            Database::disconnect();
            header("Location: readMaterialList.php?id=$id");
        }
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
                        <h3>Create a Build</h3>
                    </div>
             
                    <form class="form-horizontal" action="createMaterial.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($countError)?'error':'';?>">
                        <label class="control-label">Item Count:</label>
                        <div class="controls">
                            <input name="count" type="text" size="8" placeholder="Item Count" value="<?php echo !empty($count)?$count:'';?>">
                            <?php if (!empty($countError)): ?>
                                <span class="help-inline"><?php echo $countError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Block Type:</label>
                        <div class="controls">
								<select name="block_TUID" id="block_TUID">
								<?php 
								$pdo = Database::connect();
								$query = "SELECT block_TUID, name FROM block_type";						
								foreach ($pdo->query($query) as $row) {
									$name=$row["name"];
									$block_TUID=$row["block_TUID"];
										echo "<option value=".$block_TUID."> " . $name . " </option>";
								} ?>
								</select>
                      </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success" >Create</button>
                          <a class="btn btn-default" href="readMaterialList.php?id=<?php echo $id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>