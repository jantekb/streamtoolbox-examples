<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" type="image/png" href="favicon.ico">
	  
    <title>Wrench Authentication Example - Wowzatoolbox.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><strong>Sign in to your video site</strong></h3></div>
			<div class="panel-body">
			   <form role="form" action="verify.php" method="post">
				  <div class="form-group">
					<label for="exampleInputEmail1">Username or Email</label>
					<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="username">
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
				  </div>
				  <button type="submit" name="submit" class="btn btn-sm btn-default">Sign in</button>
				</form>
		  </div>
		</div>
		<div class="row"><p class="alert">Use john / foobar if you have loaded the default setup SQL script</p></div>
	</div>

    </div>
    <!-- /.container -->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>