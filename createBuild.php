<?php
// filename: createbuild.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to create a new build
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	 
	 if ( null==$id ) {
        header("Location: readBuilds.php?id=$id");
    }
    if ( !empty($_POST)) {
        // keep track validation errors
        $titleError = null;
         
        // keep track post values
        $title = $_POST['title'];
        $youtube_link = $_POST['youtube_link'];
        $description = $_POST['description'];
		  
		  $valid = true;
        if (empty($title)) {
            $titleError = 'Please enter title';
            $valid = false;
        }
			
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO build_details (title,description,creator_TUID,youtube_link) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($title,$description,$id,$youtube_link));
            Database::disconnect();
            header("Location: readBuilds.php?id=$id");
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
             
                    <form class="form-horizontal" action="createBuild.php?id=<?php echo $id?>" method="post">
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
                          <button type="submit" class="btn btn-success" >Create</button>
                          <a class="btn btn-default" href="readBuilds.php?id=<?php echo $id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>