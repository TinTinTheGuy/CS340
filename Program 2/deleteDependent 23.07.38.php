<?php
	session_start();
	if($_GET["Dname"]!= "") {
		$_SESSION["Dname"] = $_GET["Dname"];
	
	}
    require_once "config.php";
	// Delete an Employee's record after confirmation
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_SESSION["Ssn"]) && !empty($_SESSION["Ssn"])){ 
			$Essn = $_SESSION['Ssn'];
			$Dname = $_SESSION["Dname"];
			// Prepare a delete statement
			$sql = "DELETE FROM DEPENDENT WHERE Essn = ? AND Dependent_name = ?";
   
			if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
				
			// Set parameters
				$param_Essn = $_SESSION['Ssn'];
				$param_Dname = $_SESSION["Dname"];
				mysqli_stmt_bind_param($stmt, "is", $param_Essn, $param_Dname);
 
			
       
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Records deleted successfully. Redirect to landing page
					header("location: ViewDependant.php");
					exit();
				} else{
					echo $stmt;
					echo "Error deleting the employee";
					$SQL_err = mysqli_error($link);
					$Dname_err = $SQL_err;
				}
			}
		}
		// Close statement
		mysqli_stmt_close($stmt);
    
		// Close connection
		mysqli_close($link);
	} else{
		// Check existence of id parameter
		if(empty(trim($_GET["Dname"]))){
			// URL doesn't contain id parameter. Redirect to error page
			header("location: error.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Delete Dependent of </h2> 
						<h4>Employee SSN = <?php echo($_SESSION["Ssn"]); ?> </h4>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="Ssn" value="<?php echo ($_SESSION["Ssn"]); ?>"/>
                            <p>Are you sure you want to delete the record for <?php echo ($_SESSION["Dname"]); ?>?</p><br>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>