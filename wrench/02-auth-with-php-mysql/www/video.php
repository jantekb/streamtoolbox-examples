<?php
declare(strict_types=1);

session_start();

// Redirect if not logged in
if (!($_SESSION['logged'] ?? false)) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/database.inc.php';

$username = $_SESSION['username'];
$ip = $_SERVER['REMOTE_ADDR'];
$token = bin2hex(random_bytes(16)); // More secure than uniqid()
$tokenHash = hash('md5', $token);

$error = null;

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare('INSERT INTO wtb_tokens (username, token, ip, ts) VALUES (:username, :token, :ip, NOW())');
    $stmt->execute([
        'username' => $username,
        'token' => $tokenHash,
        'ip' => $ip
    ]);
} catch (PDOException $e) {
    $error = 'Could not save token: ' . $e->getMessage();
    error_log($error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wrench Authentication Example - Streamtoolbox.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/favicon.ico">
	<script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <img src="images/logo-white.png" alt="logo" style="float:left;margin-top:5px;margin-right:15px;"/>
            <a class="navbar-brand" href="#">Wrench Authentication Example</a>
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
                <?php if ($error): ?>
                    <p class="alert alert-danger"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <p class="well">
                    A token was generated for your session: <code><?= $token ?></code><br/>
                    Its hash (<code><?= $tokenHash ?></code>) was saved in the database.<br/>
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
                            <div class="col-sm-7">
                                <a href="#" id="hlsUrl">http://localhost:1935/wrenchexample/mystream/playlist.m3u8?t=<?= $token ?></a>
                            </div>
                            <span class="col-sm-3 control-label">For direct HLS playback</span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">RTMP URL</label>
                            <div class="col-sm-6">
                                <a href="#" id="rtmpUrl">rtmp://localhost:1935/wrenchexample/mystream?t=<?= $token ?></a>
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
    const token = '<?= $token ?>';
</script>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wrench-example.js"></script>

</body>
</html>