<?php 

session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: login.php"); 
    exit; 
}

include 'database.inc';

// Generate random token for the current user
$token = uniqid();

// Insert the hash of the token into the database along with optionally the IP address and current timestamp
// IP could be used if you wanted to enable the IP checking feature with setting wrench.token.ip.check = true
// Timestamp could be used if you wanted token expiration checking by setting wrench.token.expiry.sec to something > 0

$usr = mysql_real_escape_string($_SESSION['username']); 
$ip = $_SERVER['REMOTE_ADDR'];

$sql = "insert into wtb_tokens (username, token, ip, ts) values ('$usr',md5('$token'),'$ip', now())";

$error = false;
if (!mysql_query($sql)) {
    $error = "Error: " . $sql . "<br>" . mysql_error($db);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wrench Authentication Example - Wowzatoolbox.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="images/favicon.ico">
</head>
<body>

    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<img src="images/logo-white.png" alt="logo" style="float:left;margin-top:5px;margin-right:15px;"/>
                <a class="navbar-brand" href="#">Wrench Authentication Example</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="https://wowzatoolbox.com/wrench-reference">Wrench Reference</a>
                    </li>
                    <li>
                        <a href="https://wowzatoolbox.com/measure">Measure</a>
                    </li>
                    <li>
                        <a href="https://wowzatoolbox.com/clamp">Clamp</a>
                    </li>
					<li>
                        <a href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
		
		<div class="row">
		  <div class="col-sm-1"></div>
		  <div class="col-sm-8">
		    <div class="row"><h1>Welcome <?php echo $_SESSION['username']; ?>, ready to stream?</h1></div>
			
			<div class="row">
				<?php if($error) {
				  echo '<p class="alert alert-danger">'.$error.'</p>';
				}
				?>
				<p class="well">
				  When you logged in the following token was generated, which is now added to all video URLs: <code><?php echo $token; ?></code><br/>
				  The md5 hash of this token (<code><?php echo hash('md5', $token); ?></code>) has been saved in the database, 
				  so Wrench can find out who you are when the token is found in the connection URL in Wowza. 
				  Check out <a href="http://wowzatoolbox.com/authentication-mechanism">this article for more details</a>.
				</p>
			</div>
			
			<div class="row">
			
				<div class="panel panel-default">
				<div class="panel-body form-horizontal payment-form">
					<div class="form-group">
						<label for="server" class="col-sm-2 control-label">Wowza Server</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="server" name="server" value="localhost:1935">
						</div>
						<span class="col-sm-4 control-label">E.g. <code>localhost:1935</code>, <code>192.168.1.1:1935</code></span>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Application Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="appname" name="appname" value="wrenchexample1">
						</div>
						<span class="col-sm-4 control-label">E.g. <code>live</code>, <code>vod</code>, <code>wrenchexample1</code></span>
					</div> 
					<div class="form-group">
						<label for="amount" class="col-sm-2 control-label">Stream</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="stream" name="stream" value="mystream">
						</div>
						<span class="col-sm-4 control-label">E.g. <code>mystream</code></span>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">HTTP URL</label>
						<div class="col-sm-7">
							<a href="#" id="httpurl">http://localhost:1935/wrenchexample1/mystream/playlist.m3u8?t=<?php echo $token; ?></a>
						</div>
						<span class="col-sm-3 control-label">For Android and iOS</span>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">RTMP URL for JW Player 5</label>
						<div class="col-sm-6">
							<a href="#" id="rtmpurl5">rtmp://localhost:1935/wrenchexample1/mystream?t=<?php echo $token; ?></a>
						</div>
						<span class="col-sm-4 control-label">Wrench will look for the <code>t</code> GET parameter in the URLs by default.</span>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">RTMP URL for JW Player 6</label>
						<div class="col-sm-8">
							<a href="#" id="rtmpurl6">rtmp://localhost:1935/wrenchexample1/?t=<?php echo $token; ?>/mystream</a>
						</div>
					</div>					
					  
					<div class="form-group">
						<div class="col-sm-8 text-right">
							<button type="button" class="btn btn-default preview-add-button btn-success" id="regenerate">
								<span class="glyphicon glyphicon-refresh"></span> Refresh Links and JW Player
							</button>
						</div>
					</div>
					
				</div>
				
				<div class="row">
				  <div class="col-sm-12">
				    <div id="player-container"></div>
				  </div>
				</div>
			</div>
			
			</div>
			
		  </div>
		  
		  <div class="col-sm-3"></div>
		</div>
	   		
    </div>
    <!-- /.container -->

	<script type="text/javascript">
	  /* Make the token available for the Javascript code as a global variable */
	  var token = '<?php echo $token; ?>';
	</script>
	
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/wrench-example.js"></script>
	<script src="jwplayer/jwplayer.js"></script>
	
	<?php
	
	  /* In this example we are dynamically constructing the JW Player's stream URL from Javascript.
	   an other common approach is to generate the JW Player setup script here from PHP code, where you
	   can easily directly put the token into the script itself:
	   
	   ...
	   jwplayer.setup({
	     ...
		 'file' : 'rtmp://myserver:1935/someapplication/?t=<?php echo $_SESSION['token']; ?>/streamname
	   })
	   ...;
	   */
	?>
	
</body>
</html>