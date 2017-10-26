<html>
<body>

<?php 

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script type='text/javascript'>console.log( 'Debug Objects: " . $output . "' );</script>";
}

$db_host = "localhost";
$user = 'bnelson';
// $password = 'password';
$db_name = 'mydb';
try
{
  $db = new PDO('pgsql:host='.$db_host.';dbname='.$db_name, $user);
  
  $cit = 'Phoenix';
  $pre = 0;

  $query = $db->prepare('SELECT * FROM weather WHERE prcp > :rainz');
  $query->bindValue(':rainz', $pre, PDO::PARAM_STR);
  $query->execute();

  $rows = $query->fetchAll(PDO::FETCH_ASSOC);

  foreach($rows as $r) {
  	echo 'City: '.$r['city'].'<br />';
  }




}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}

foreach ($db->query('SELECT now()') as $row)
{
 print "<p>$row[0]</p>\n\n";
}

$query = "SELECT * FROM weather;";

		debug_to_console($query);

		foreach ($db->query("SELECT * FROM weather;") as $row) {
			echo 'citY: ' . $row['city'];
			echo ' temp_LO: ' . $row['temp_lo'];
		}

		debug_to_console($result);

		$results = pg_num_rows($result);

?>	

<!-- <?php

// default Heroku Postgres configuration URL
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
 // example localhost configuration URL with postgres username and a database called cs313db
 $dbUrl = "postgres://postgres:password@localhost:5432/mydb";
}

$dbopts = parse_url($dbUrl);

print "<p>$dbUrl</p>\n\n";

$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPassword = $dbopts["pass"];
$dbName = ltrim($dbopts["path"],'/');

print "<p>pgsql:host=$dbHost;port=$dbPort;dbname=$dbName</p>\n\n";

try {
 $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $ex) {
 print "<p>error: $ex->getMessage() </p>\n\n";
 die();
}

foreach ($db->query('SELECT now()') as $row)
{
 print "<p>$row[0]</p>\n\n";
}

?> -->

</body>
</html>