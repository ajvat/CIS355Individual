<?php
// filename: createCreator.php, Anthony Vatter, cis355, 2015-04-26
// generates the form and code to create a new creator
    require 'database.php';
 
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
			
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO creator (name,youtube_link,twitter_link,facebook_link) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$youtube_link,$twitter_link,$facebook_link));
            Database::disconnect();
            header("Location: index.php");
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
                        <h3>Create a Creator</h3>
                    </div>
             
                    <form class="form-horizontal" action="createCreator.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name:</label>
                        <div class="controls">
                            <input name="name" type="text" size="30" placeholder="Creator" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Youtube Link:</label>
                        <div class="controls">
                            <input name="youtube_link" type="text" size="60" placeholder="Youtube Link" value="<?php echo !empty($youtube_link)?$youtube_link:'';?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Twitter Link:</label>
                        <div class="controls">
                            <input name="twitter_link" type="text" size="60" placeholder="Twitter Link" value="<?php echo !empty($twitter_link)?$twitter_link:'';?>">
                        </div>
                      </div>
							 <div class="control-group">
                        <label class="control-label">Facebook Link:</label>
                        <div class="controls">
                            <input name="facebook_link" type="text" size="60" placeholder="Facebook Link" value="<?php echo !empty($facebook_link)?$facebook_link:'';?>">
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn btn-default" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>