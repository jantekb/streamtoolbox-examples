<?php
declare(strict_types=1);

session_start();

// Redirect if not logged in
if (!($_SESSION['logged'] ?? false)) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

$username = $_SESSION['username'];

// This should match the wrench.token.jwt.secret configuration value in the Application.xml in Wowza
$secretKey = '4VgghzRXEjjqBKKYa4ASMQAy7WPDapJp';

$payload = [
    'sub' => $username,  // Subject claim is the username
    'iat' => time(),     // Issued at
    'exp' => time() + (60 * 60 * 24), // Expires in 24 hours
    'iss' => 'wrench-example' // Issuer
];

$token = JWT::encode($payload, $secretKey, 'HS256');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wrench JWT Authentication Example - Streamtoolbox.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/favicon.ico">
	<script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <img src="images/logo-white.png" alt="logo" style="float:left;margin-top:5px;margin-right:15px;"/>
            <a class="navbar-brand" href="#">Wrench JWT Authentication Example</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="https://streamtoolbox.com/wrench-reference">Wrench Reference</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div class="row">
                <h1>Welcome <?= htmlspecialchars($username) ?>, ready to stream?</h1>
            </div>

            <div class="row">
                <p class="well wrapped">
                    A JWT token was generated for your session: <code><?= htmlspecialchars($token) ?></code><br/>
                    The token contains your username as the 'sub' claim and is signed with HS256.<br/>
                    <a href="https://streamtoolbox.com/authentication-mechanism">Learn how Wrench uses it</a>.
                </p>
            </div>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Wowza Server</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="server" value="localhost:1935">
                            </div>
                            <span class="col-sm-4 control-label">e.g. <code>localhost:1935</code></span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Application Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="appname" value="wrenchexample1">
                            </div>
                            <span class="col-sm-4 control-label">e.g. <code>live</code>, <code>vod</code></span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stream</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="stream" value="mystream">
                            </div>
                            <span class="col-sm-4 control-label">e.g. <code>mystream</code></span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">HLS URL</label>
                            <div class="col-sm-7 wrapped">
                                <a href="#" id="hlsUrl">http://localhost:1935/wrenchexample/mystream/playlist.m3u8?t=<?= urlencode($token) ?></a>
                            </div>
                            <span class="col-sm-3 control-label">For direct HLS playback</span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">RTMP URL</label>
                            <div class="col-sm-6 wrapped">
                                <a href="#" id="rtmpUrl">rtmp://localhost:1935/wrenchexample/mystream?t=<?= urlencode($token) ?></a>
                            </div>
                            <span class="col-sm-4 control-label">Uses <code>t</code> GET param, you can test it with ffmpeg or VLC</span>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 text-right">
                                <button type="button" class="btn btn-success" id="regenerate">
                                    <span class="glyphicon glyphicon-refresh"></span> Refresh Token and Play
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
								<video id="video" style="width: 100%; object-fit: contain;"></video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

<script>
    const token = '<?= addslashes($token) ?>';
</script>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wrench-example.js"></script>

</body>
</html>