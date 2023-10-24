<?php
	session_start();	
// Include config file
	require_once "config.php";
 
// Define variables and initialize with empty values
// Note: You can not update SSN 
$Dname = $Bdate = $Relationship = $Sex = "";
$Dname_err = $Sex_err = $Relationship_err = $Bdate_err = "" ;
// Form default values

if($_GET["Dname"]!= "") {
	$_SESSION["Dname"] = $_GET["Dname"];

    // Prepare a select statement
    $sql1 = "SELECT * FROM DEPENDENT WHERE  Essn = '" . $_SESSION["Ssn"] . "' AND Dependent_name = '" . $_SESSION["Dname"] . "'";  
    $result = mysqli_query($link, $sql1);
    // Attempt to execute the prepared statement
    if($result->num_rows > 0){
        
            $row = $result->fetch_assoc();
            
            $Dname = $row['Dependent_name'];
            $Sex = $row['Sex'];
           
            $Essn = $row['Essn'];
           
            $Bdate = $row['Bdate'];
            $Relationship = $row['Relationship'];
    }
}


 
// Post information about the employee when the form is submitted
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // the id is hidden and can not be changed
    $Essn = $_SESSION["Ssn"];
    //depen name can be changed
    $oldDname = $_SESSION["Dname"];
    // Validate form data this is similar to the create Employee file
    // Validate name
    $Dname = trim($_POST["Dname"]);
		if(empty($Dname)){
			$Dname_err = "Please add Dependent's Name.";
		} 
        
		$Relationship = trim($_POST["Relationship"]);
		if(empty($Relationship)){
			$Relationship_err = "Please add Dependent relationship.";     
		}
	
		$Bdate = trim($_POST["Bdate"]);
		if(empty($Bdate)){
			$Bdate_err = "Please add Birthday follow MM/DD/YYYY.)";     
		}
		$Sex = trim($_POST["Sex"]);
		if(empty($Sex)){
			$Sex_err = "Please add Dependent Sex";        
    }

    // Check input errors before inserting into database
    if(empty($Dname_err) && empty($Relationship_err) && empty($Bdate_err) && empty($Sex_err)){
        // Prepare an update statement
        $sql = "UPDATE DEPENDENT SET Dependent_name = \"" . $_POST["Dname"] . "\", Relationship = '" . $_POST["Relationship"] . "', Sex = \"" . $_POST["Sex"] . "\", Bdate = '" . $_POST["Bdate"] . "' WHERE Essn = " . $_SESSION["Ssn"] . " AND Dependent_name = '" . $_POST["oldname"] . "'";
        $Essn = $_GET["Essn"];
        $result = mysqli_query($link, $sql);
        if ($result) {
            header("location: index.php");
            exit();
                
        } else{
                echo "<center><h2>Error when updating</center></h2>";
                $SQL_err = mysqli_error($link);
                $Dname_err = $SQL_err;
            }       
    }
    
    // Close connection
    mysqli_close($link);




} else 

{
    if($_GET["Dname"]!= "") {
        $_SESSION["Dname"] = $_GET["Dname"];
    
        // Prepare a select statement
        $sql1 = "SELECT * FROM DEPENDENT WHERE  Essn = " . $_SESSION["Ssn"] . " AND Dependent_name = " . $_SESSION["Dname"];    

        $result = mysqli_query($link, $sql1);

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $param_Dependent_name = $Dependent_name;
                $param_Relationship = $Relationship;            
                $param_Sex = $Sex;
                $param_Bdate = $Bdate;
            } 
} else{
    echo "Error in SSN while updating";
}

}
// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($link);


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
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
                        <h2>Update Record for Dependent</h2>
                    </div>
                    <p>Add a dependent for Employee with SSN = <?php echo $_SESSION["Ssn"] ?></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="oldname" value='<?php echo $Dname ?>'>
						<div class="form-group <?php echo (!empty($Dname_err)) ? 'has-error' : ''; ?>">
                            <label>Dependents Name</label>
                            <input type="text" name="Dname" class="form-control" value="<?php echo $Dname; ?>">
                            <span class="help-block"><?php echo $Dname_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Relationship_err)) ? 'has-error' : ''; ?>">
                            <label>Relationship</label>
                            <input type="text" name="Relationship" class="form-control" value="<?php echo $Relationship; ?>">
                            <span class="help-block"><?php echo $Relationship_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Sex_err)) ? 'has-error' : ''; ?>">
                            <label>Sex</label>
                            <input type="text" name="Sex" class="form-control" value="<?php echo $Sex; ?>">
                            <span class="help-block"><?php echo $Sex_err;?></span>
                        </div>
						                  
						<div class="form-group <?php echo (!empty($Birth_err)) ? 'has-error' : ''; ?>">
                            <label>Birth date</label>
                            <input type="date" name="Bdate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            <span class="help-block"><?php echo $Birth_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="ViewDependant.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>