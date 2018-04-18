<?php
//require("vendor/autoload.php");
require 'vendor/autoload.php';


use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


// Används av loggern
$log = new Logger('Laboration 1');
$log->pushHandler(new StreamHandler('greetings.log', Logger::INFO));

// Skapa en HTTP-client
$client = new \GuzzleHttp\Client();

// Anropa URL: http://unicorns.idioti.se/
$res = $client->request('GET', 'http://unicorns.idioti.se/', ['headers' => ['Accept' => 'application/json']]);

// header("Content-type: application/json; charset=UTF-8");
// Omvandla JSON-svar till datatyper
$data = json_decode($res->getBody(), true);

?>


<!doctype html>
<html>
    <head>
	<link rel="shortcut icon" href="favicon/favicon.ico" />
        <title>Fina hestar</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>Fina hestar</h1>
            <hr>
            <form action="index.php" method="get">
                <div class="form-group">
                    <label for="id">Sök efter ID </label>
                    <input type="text" id="id" name="id" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Sök!" class="btn btn-success">
                    <a href="index.php" class="btn btn-primary">Tillbaka</a>
                </div>
            </form>
            
	    <p>
			<?php 
				 
				$getID = $_GET['id'];
				print "<hr>";
				
				
				// Om användaren ser alla hästar
				if($getID == null){		
					$log->info("Info om alla hestar");
					print "<h3>Här hittar du alla fina hestar.</h3>" .
						"<br>";
								
					for ($i=0; $i < count($data); $i++) {
						print "<p>" . ($data[$i]['id']) . "&nbsp" . $data[$i]['name'];
						print "<a href='index.php?id=".$data[$i]['id'] ."' class='btn btn-info' style='float: right' role='button'> Mer info här! </a>";
						print "</p>";
						print "<hr>";
					  }
				}
				// Om användaren har klickat in på en häst
				else if($getID >= 1){
					$log->info("Info om hesten:" .$data[$getID - 1]['name']);

					$horse = file_get_contents('http://unicorns.idioti.se/' . $_GET['id']);
					print $horse;

				}
				else{
					$log->info("Hesten hittade inte");
					print "<h4> Hesten du letar efter finns inte! </h4>";
				}
				
			?>
	    </p>
        </div>
    </body>
</html>
