<?php
// filename: updateCreator.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to update a current creator     
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
	 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $youtube_link = $_POST['youtube_link'];
        $twitter_link = $_POST['twitter_link'];
        $facebook_link = $_POST['facebook_link'];
		  
		  $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter name';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE creator set name = ?, youtube_link = ?, twitter_link = ?, facebook_link = ? WHERE creator_TUID = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$youtube_link,$twitter_link,$facebook_link,$id));
            Database::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM creator where creator_TUID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $youtube_link = $data['youtube_link'];
        $twitter_link = $data['twitter_link'];
		  $facebook_link = $data['facebook_link'];
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
                        <h3>Update a Creator</h3>
                    </div>
             
                    <form class="form-horizontal" action="updateCreator.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text" size="30" placeholder="Creator" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Youtube Link</label>
                        <div class="controls">
                            <input name="youtube_link" type="text" size="60" placeholder="Youtube Link" value="<?php echo !empty($youtube_link)?$youtube_link:'';?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Twitter Link</label>
                        <div class="controls">
                            <input name="twitter_link" type="text" size="60" placeholder="Twitter Link" value="<?php echo !empty($twitter_link)?$twitter_link:'';?>">
                        </div>
                      </div>
							 <div class="control-group">
                        <label class="control-label">Facebook Link</label>
                        <div class="controls">
                            <input name="facebook_link" type="text" size="60" placeholder="Facebook Link" value="<?php echo !empty($facebook_link)?$facebook_link:'';?>">
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn btn-default" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>