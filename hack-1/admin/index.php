<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function logInput($message)
{

    $data = array(
        'message' => $_SERVER['REMOTE_ADDR'].'> `'.$message."`"
    );

    $payload = json_encode($data);

    $ch = curl_init('https://fleep.io/hook/Do5Akx_9QYyRGlUCQhOYDw');
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
    );

    curl_exec($ch);

    curl_close($ch);
}

?>
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Secure area</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">
        body {
            margin-top: 200px;
            display: none;
        }

        footer {
            margin-top: 100px;
        }

        main {
            margin: 50px 0;
        }

        header {
            margin-bottom: 100px;
            border-bottom: 2px solid black;
        }

        pre {
            border: 1px solid green;
        }
    </style>
</head>

<body id="content" class="text-center">

<div class="container">

    <div class="row">
        <div class="col-8 offset-2">
            <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
                <header class="masthead">
                    <div class="inner">
                        <h3 class="masthead-brand">Secure admin area</h3>

                        <p>Exchange messages between community members</p>
                    </div>
                </header>

                <?php if (!isset($_POST['file'])): ?>
                    <h3>List of available messages</h3>

                    <pre><?php


                        foreach (scandir('/var/www/hack-1/admin/messages') as $file) {
                            echo $file . "\n";
                        }

                        ?></pre>
                <?php else: ?>
                    <h3>Message contents</h3>
                    <pre>
            <?php

            logInput($_POST['file']);
            $file = trim($_POST['file'], './');
            $exec = 'cat "/var/www/hack-1/admin/messages/' . $file . '"';

            $out = shell_exec($exec);
            if ($out === null) {
                echo 'Input error, system crash - error with ' . $exec ;
            } else {
                echo $out;
            }
            ?>
        </pre>
                <?php endif ?>
                <main role="main" class="inner cover">

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="file">Message file to read</label>
                            <input type="text" class="form-control" name="file" id="file" placeholder="README.txt">

                        </div>
                        <button type="submit" class="btn btn-primary">Read file contents</button>
                    </form>


                </main>


                <footer>
                    <p>3b7a203==</p>
                </footer>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script type="text/javascript">

    if (document.cookie.indexOf('loggedIn2') == -1) {
        var password = prompt("Access to admin area is restricted to H4xorShadow members only - please enter your password!", "");

        if (password != "123456") {
            window.location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        } else {
            document.getElementById("content").style.display = "block";
            document.cookie = "loggedIn2=true";
        }
    } else {
        document.getElementById("content").style.display = "block";
    }
</script>
</body>
</html>
