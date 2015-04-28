<?php
// filename: updateBuild.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to update a current build
    require 'database.php';
	
    $buildid = null;
    if ( !empty($_GET['buildid'])) {
        $buildid = $_REQUEST['buildid'];
    }
	 
	 if ( null==$buildid ) {
        header("Location: readBuilds.php");
    }	 
	 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	 
	 if ( null==$id ) {
        header("Location: readBuilds.php");
    }
	 
    if ( !empty($_POST)) {
        // keep track validation errors
        $titleError = null;
         
        // keep track post values
        $title = $_POST['title'];
        $description = $_POST['description'];
        $youtube_link = $_POST['youtube_link'];
		  
		  $valid = true;
        if (empty($title)) {
            $titleError = 'Please enter title';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE build_details set title = ?, description = ?, youtube_link = ? WHERE build_TUID = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($title,$description,$youtube_link,$buildid));
            Database::disconnect();
            header("Location: readBuilds.php?id=$id");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM build_details where build_TUID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($buildid));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $title = $data['title'];
        $youtube_link = $data['youtube_link'];
		  $description = $data['description'];
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
             
                    <form class="form-horizontal" action="updateBuild.php?buildid=<?php echo $buildid?>&id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
                        <label class="control-label">Title:</label>
                        <div class="controls">
                            <input name="title" type="text" size="30" placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
                            <?php if (!empty($titleError)): ?>
                                <span class="help-inline"><?php echo $titleError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">YouTube Link:</label>
                        <div class="controls">
                            <input name="youtube_link" type="text" size="60" placeholder="YouTube Link" value="<?php echo !empty($youtube_link)?$youtube_link:'';?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Description:</label>
                        <div class="controls">
                            <input name="description" type="text" size="60" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success" >Update</button>
                          <a class="btn btn-default" href="readBuilds.php?id=<?php echo $id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>