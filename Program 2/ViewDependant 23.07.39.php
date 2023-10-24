<?php
	session_start();
    // Include config file
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Dependent</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
	   <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">View Dependent</h2>
						<a href="addNewDependent.php" class="btn btn-success pull-right">Add New Dependent</a>
                    </div>
<?php
    // Include config file
    //require_once "config.php";
// Check existence of id parameter before processing further
if(isset($_GET["Ssn"]) && !empty(trim($_GET["Ssn"]))){
	$_SESSION["Ssn"] = $_GET["Ssn"];
}

if(isset($_SESSION["Ssn"]) ){
	
    // Prepare a select statement
    $sql = "SELECT Dependent_name, Relationship, Sex, Bdate FROM DEPENDENT WHERE Essn = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_Ssn);      
        // Set parameters
       $param_Ssn = ($_SESSION["Ssn"]); 

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
			echo"<h4> Dependent list for ".$Lname." &nbsp SSN = ".$param_Ssn."</h4><p>";
			if(mysqli_num_rows($result) > 0){
				echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th width = 30%>Dependent Name</th>";
                            echo "<th width = 20%>Relationshop</th>";
                            echo "<th width = 20%>Sex</th>";
                            echo "<th width = 20%>BirthDate</th>";
                            echo "<th width = 20%>Action</th>";                  
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";							
				// output data of each row
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['Dependent_name'] . "</td>";
                        echo "<td>" . $row['Relationship'] . "</td>";
                        echo "<td>" . $row['Sex'] . "</td>";
                        echo "<td>" . $row['Bdate'] . "</td>";
                        echo "<td>";
                        echo "<a href='updateDependent.php?Dname=".$row["Dependent_name"]."' title='Update Information' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        echo "<a href='deleteDependent.php?Dname=".$row["Dependent_name"]."' title='Delete Information' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        echo "</td>";
    // DANG LAM TOI DAY DE INPUTT TABLE
                        echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";				
				mysqli_free_result($result);
			} else {
				echo "No dependent were found. ";
			}
				mysqli_free_result($result);
        } else{
			// URL doesn't contain valid id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }     
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>					                 
					
	<p><a href="index.php" class="btn btn-primary">Back</a></p>
    </div>
   </div>        
  </div>
</div>
</body>
</html>