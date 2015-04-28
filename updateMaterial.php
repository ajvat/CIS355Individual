<?php
// filename: updateMaterial.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to update a current material
    require 'database.php';
	
    $updateid = null;
    if ( !empty($_GET['updateid'])) {
        $updateid = $_REQUEST['updateid'];
    }
	 
	 if ( null==$updateid ) {
        header("Location: readMaterialList.php");
    }	 
	 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	 
	 if ( null==$id ) {
        header("Location: readMaterialList.php");
    }
	 
	 $block_TUID = null;
    if ( !empty($_GET['block_TUID'])) {
        $block_TUID = $_REQUEST['block_TUID'];
    }
	 
	 if ( null==$block_TUID ) {
        header("Location: readMaterialList.php");
    }
	 
    if ( !empty($_POST)) {
        // keep track validation errors
        $countError = null;
         
        // keep track post values
        $count = $_POST['count'];
        $new_block_TUID = $_POST['new_block_TUID'];
		  
		  $valid = true;
        if (empty($count)) {
            $countError = 'Please enter count';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE material_list set count = ?, block_TUID = ? WHERE material_list_TUID = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($count,$new_block_TUID,$updateid));
            Database::disconnect();
            header("Location: readMaterialList.php?id=$id");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM material_list where material_list_TUID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($updateid));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $count = $data['count'];
        $block_TUID = $data['block_TUID'];
        Database::disconnect();
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
                        <h3>Update a Build</h3>
                    </div>
             
                    <form class="form-horizontal" action="updateMaterial.php?updateid=<?php echo $updateid?>&id=<?php echo $id?>&block_TUID=<?php echo $block_TUID?>" method="post">
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
								<select name="new_block_TUID" id="new_block_TUID">
								<?php 
								$pdo = Database::connect();
								$query = "SELECT block_TUID, name FROM block_type";						
								foreach ($pdo->query($query) as $row) {
									$name=$row["name"];
									$new_block_TUID=$row["block_TUID"];
										echo "<option value=".$new_block_TUID."> " . $name . " </option>";
										if ($block_TUID == $new_block_TUID){
										echo "<option selected value=".$new_block_TUID."> " . $name . " </option>";
										}
								} ?>
								</select>
                      </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success" >Update</button>
                          <a class="btn btn-default" href="readMaterialList.php?id=<?php echo $id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>