<?php 

session_start();

include('connection.php');

$query = "SELECT diary FROM users WHERE id = '".$_SESSION['id']."' LIMIT 1";

$result = mysqli_query($link, $query);

$row = mysqli_fetch_array($result);

$diary = $row['diary'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Online Notepad</title>

    <!--jQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script> 

    $.get("/menuBar.html", function(data) {

		$("#menuBar").html(data);

	});

    var page = "pageNotepad";
    </script> 

    <style type="text/css">

    	body {
		
		padding: 0 !important;
	}

	#main {
		background-image: url("note.jpg");
		width: 100%;
		height: 653px;
		background-size: cover;
		background-position: center;
	}

		#logOut {
			margin-top: 10px;
			margin-bottom: 10px;
			position: relative;
			right: 11px;
			
		}

		#diaryText { 
			position: relative;
			left: 5px;
			background-color: #E5E2DB;

		}

		#instruction {
			margin-top: 30px;

		}
    </style>
	
    
	

  </head>
<body>

<div id="menuBar"></div>
<div class="container text-center" id="main"> 
	
		

	<div class="row">

		<div class="col-md-12 text-right">
		
			<a href="signin.php?logout=1" id="logOut" class="btn btn-info">Log Out</a>
		</div>
	</div>


	<div class="row">
		<div class="col-md-8 col-md-offset-2">

		<textarea class="form-control" id="diaryText"><?php 
				if ($diary)
					echo $diary; 
				else
					echo "Type away! Everything you enter here will be saved automatically and will be waiting for you when you come back. Feel free to erase me and start fresh!"
			?>
		</textarea>

		</div>
	</div>


</div>


<script type="text/javascript">

	$("textarea").css("height", $(window).height() - 110);

	$("textarea").keyup( function() {
		$.post("updatediary.php", { diary:$("#diaryText").val() } );
	});

</script>
    
    
</body>
</html>

