<!doctype html>
<?php
include("auth.php");
include("conn.php");
$email  = $_SESSION['email'];
$data = $_POST['progress'];


$img_name = $_FILES['file']['name'];
$img_size = $_FILES['file']['size'];
$img_tmp = $_FILES['file']['tmp_name'];

$directory = 'uploads';
$directory1 = $directory . "/" . $email . "/";
if (!is_dir($directory1)) {
    mkdir($directory1);
}
$target_file = $directory1 . $img_name;
move_uploaded_file($img_tmp, $target_file);
$query = "SELECT * FROM users WHERE email='$email' ";
$result = mysqli_query($con, $query) or     printf("Error message: %s\n", $mysqli->error);
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    $user_id = $row['user_id'];
    $sql = "INSERT INTO files (E_fileData ,File_Creator_Id,hash,size,file_name) values ('$target_file' , '$user_id', '$data',500,'$img_name')";

    if ($con->query($sql)) {
        echo "Loading...please wait..";
        $_SESSION['hash'] = $data;
    } else
        echo ("Error description: " . mysqli_error($con));
}

$data = str_replace('1', '', $data);
$data = str_replace('2', '', $data);
$data = str_replace('3', '', $data);
$data = str_replace('4', '', $data);
$data = str_replace('5', '', $data);
$data = str_replace('6', '', $data);
$data = str_replace('7', '', $data);
$data = str_replace('8', '', $data);
$data = str_replace('9', '', $data);
$data = str_replace('0', '', $data);



$query = "SELECT * FROM digitatl_certificate WHERE email='$email ' ";
$result = mysqli_query($con, $query)
    or die("Error description: " . mysqli_error($con));

$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    $pb = $row['public_key'];
    //      $pr =$row['private_key']; 
    $pub = file_get_contents($pb);
    // $pri = file_get_contents($pr);
}

?>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="../cloudigrity/src/sha3.js"></script>
    <style>
        .header {
            padding: 60px;
            text-align: center;
            background: #1abc9c;
            color: white;
            font-size: 30px;
        }

        input[type=text],
        select {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: orange;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: darkorange;
        }

        table {
            border-collapse: collapse;
            width: 50%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #4367c0;
            color: white;
        }

        #btn {
            width: 5%;
            height: 50px;
            font-size: 18px;
        }

        #file {
            background-color: orange;
            border: none;
            color: white;
            padding: 5px 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px 2px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
        }

        #upload {
            background-color: #4367c0;
            border: none;
            color: white;
            padding: 10px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
        }

        .button {
            background-color: #4367c0;
            border: none;
            color: white;
            padding: 10px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
        }

        a {
            text-decoration: none
        }

        .header {
            padding: 5px;
            text-align: center;
            background: #4367c4;
            color: white;
            font-size: 20px;
        }

        .loader {
            display: none;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #3498db;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script type="text/javascript">
        // How many bytes to read per chunk
        var chunkSize = Math.pow(10, 5)

        // Handle various I/O problems
        function errorHandler(evt) {
            switch (evt.target.error.code) {
                case evt.target.error.NOT_FOUND_ERR:
                    alert('File Not Found!')
                    break
                case evt.target.error.NOT_READABLE_ERR:
                    alert('File is not readable')
                    break
                case evt.target.error.ABORT_ERR:
                    break // noop
                default:
                    alert('An error occurred reading this file.')
            }
        }

        // Recurse through async chunk reads
        function readFile(hasher1, file, start, stop) {
            var progress = document.querySelector('#progress')
            // Only read to the end of the file
            stop = (stop <= file.size) ? stop : file.size

            // Prepare to read chunk
            var reader = new FileReader()
            reader.onerror = errorHandler

            // If we use onloadend, we need to check the readyState.
            reader.onloadend = function(evt) {
                if (evt.target.readyState == FileReader.DONE) {
                    hasher1.update(evt.target.result)

                    var percent = Math.round((stop / file.size) * 100)
                    progress.innerHTML = 'Progress: ' + percent + '%'

                    // Recurse or finish
                    if (stop == file.size) {
                        progress.innerHTML = "";
                        result1 = hasher1.getHash('HEX')
                        progress.innerHTML += result1;




                    } else {
                        readFile(hasher1, file, start + chunkSize, stop + chunkSize)
                    }
                }
            }

            // Begin read
            var blob = file.slice(start, stop)
            reader.readAsArrayBuffer(blob)
        }

        function handleFileSelect(input) {
            var progress = document.querySelector('#progress')
            // Reset progress indicator on new file selection.
            progress.innerHTML = 'Progress: 0%';

            // Get file object from the form
            var file = input.files[0];

            var hasher1 = new jsSHA('SHA3-512', 'ARRAYBUFFER')
            // Read file in chunks
            readFile(hasher1, file, 0, chunkSize)
        }
    </script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>JavaScript Encryption - James R. Williams</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            background: #ffffff;
        }

        #public-key-input,
        #private-key-input,
        #aes-key-input,
        #aes-iv-input,
        #message-cypher {
            font-family: monospace;
        }

        #public-key-input,
        #private-key-input {}

        #message-cypher,
        #message-plain {
            height: 200px;
        }

        * {
            -webkit-font-smoothing: antialiased;
        }

        p.nav-link.disabled {
            color: white;
            padding-left: 0;
        }

        .jumbotron {
            margin-bottom: 0;

            color: white;
            padding-bottom: 10px;
        }

        .jumbotron,
        .nav {
            background: #0e141a;
        }

        section {
            padding: 2rem;
        }

        textarea {
            resize: none;
        }

        main {
            background: #e9ecef;
            border-bottom: 1px solid #ddd;
        }

        hr {
            border-color: #e9ecef;
        }

        nav {
            padding: 10px 0 30px;
            border-bottom: 1px solid #ddd;
        }
    </style>

</head>
<div class="loader"></div>

<body hidden>

    <div class="header">
        Cloudigrity
    </div>
    <a href="https://github.com/atoyebii" class="github-corner" aria-label="View source on GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#04AA75; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true">
            <path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path>
            <path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path>
            <path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path>
        </svg></a>
    <style>
        .github-corner:hover .octo-arm {
            animation: octocat-wave 560ms ease-in-out
        }

        @keyframes octocat-wave {

            0%,
            100% {
                transform: rotate(0)
            }

            20%,
            60% {
                transform: rotate(-25deg)
            }

            40%,
            80% {
                transform: rotate(10deg)
            }
        }

        @media (max-width:500px) {
            .github-corner:hover .octo-arm {
                animation: none
            }

            .github-corner .octo-arm {
                animation: octocat-wave 560ms ease-in-out
            }
        }
    </style>

    <Center>
        Outsource your files to the cloud securly </br>
        select a file to upload

    </Center>

    <br>

    <nav class="nav" hidden>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills" id="myTab" role="tablist" hidden>
                        <li class="nav-item" hidden>
                            <p class="nav-link disabled">Select demo:</p>
                        </li>
                        <li class="nav-item" hidden>
                            <a hidden class="nav-link active" id="rsa-tab" data-toggle="tab" href="#rsa" role="tab" aria-controls="rsa" aria-selected="true">RSA</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="tab-content" id="myTabContent" hidden>

        <section class="rsa tab-pane fade show active" id="rsa" role="tabpanel" aria-labelledby="home-tab">



            <div class="keys">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="private-key-input">Private Key</label>
                                <textarea class="form-control" name="private-key-input" id="private-key-input" cols="30" rows="5" placeholder="-----BEGIN RSA PRIVATE KEY-----">
                                      <?php
                                        //    echo $pri;
                                        ?>
                                    </textarea>
                                </small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="public-key-input">Public Key</label>
                                <textarea class="form-control" name="public-key-input" id="public-key-input" cols="30" rows="5" placeholder="-----BEGIN PUBLIC KEY-----">
                                      <?php
                                        echo $pub;
                                        ?>
                                    </textarea>
                                <small class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main>

    <section class="workbench">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="message-input" hidden>Plaintext</label>
                        <textarea class="form-control" hidden name="message-input" id="message-plain" cols="30" rows="10">
                    <?php
                    echo $data;
                    ?>
                </textarea>

                    </div>
                    <button id="encrypt" class="btn btn-success">Encrypt</button>
                </div>
                <div class="col">
                    <div class="form-group">
                        <form name="submit" id="" action="test72.php" method="post" enctype="multipart/form-data">
                            <label for="message-result" hidden>Ciphertext</label>
                            <textarea class="form-control" hidden name="message-cypher" id="message-cypher" cols="30" rows="10"></textarea>
                    </div>
                    <button id="submit" class="btn btn-secondary float-right">Continue</button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- START Encryption Libs -->
    <script src="vendor/jsencrypt.min.js"></script>
    <script src="vendor/aes-js.js"></script>
    <!-- END Encryption Libs -->

    <script>
        $(document).ready(function() {
            /**
             * Save Field Values to LocalStorage for sessionPersistance;
             * @type {Array}
             */
            let saveFields = ['aes-key-input', 'public-key-input', 'private-key-input', 'aes-counter'];
            for (var i = 0; i < saveFields.length; i++) {
                let $id = "#" + saveFields[i];
                let id = saveFields[i];
                $($id).val(window.localStorage.getItem(id));
                $($id).change(function() {
                    window.localStorage.setItem(id, $(this).val());
                });
            }
            var counter;
            /**
             * Encrypt Handler
             */
            $("#encrypt").on('click', function() {

                var message = $('#message-plain').val();
                var currentTab = $(".nav-link.active").attr('aria-controls');
                var counter = $("#aes-counter").val();
                if (!counter) {
                    counter = Math.floor(Math.random() * 1000000000);
                    $("#aes-counter").val(counter);
                }
                if (message) {
                    if (currentTab === 'aes') {
                        var key = JSON.parse($("#aes-key-input").val());
                        counter = JSON.parse($("#aes-counter").val());
                        // Convert text to bytes
                        var textBytes = aesjs.utils.utf8.toBytes(message);
                        // The counter is optional, and if omitted will begin at 1
                        var aesCtr = new aesjs.ModeOfOperation.ctr(key, new aesjs.Counter(counter));
                        var encryptedBytes = aesCtr.encrypt(textBytes);
                        // To print or store the binary data, you may convert it to hex
                        var encryptedHex = aesjs.utils.hex.fromBytes(encryptedBytes);
                        // When ready to decrypt the hex string, convert it back to bytes
                        $("#message-plain").val("");
                        $("#message-cypher").val(encryptedHex);
                        $("#aes-counter").val(counter);
                    } else if (currentTab === 'rsa') {
                        var encrypt = new JSEncrypt();
                        encrypt.setPublicKey($('#public-key-input').val());
                        $("#message-plain").val("");
                        $("#message-cypher").val(encrypt.encrypt(message));
                    }
                }
            });
        });
        document.getElementById("encrypt").click();
    </script>
    <script>
        $(document).ready(function() {
            $("#encrypt").trigger('click');
            $("#submit").trigger('click');


        });
    </script>

</body>

</html>