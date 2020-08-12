<?php
session_start();
require "conn.php";
$email  = $_SESSION['email'];
$digitalsignature  = $_SESSION['digitalsignature'];
$data  = $_SESSION['data'];
$_SESSION['data'] = $data;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_cypher = filter_input(INPUT_POST, 'message-cypher');
    //  echo $message_cypher;
}
$query = "SELECT * FROM digitatl_certificate WHERE email='$email ' ";
$result = mysqli_query($con, $query) or die(mysqli_error());
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    // $pb =$row['public_key']; 
    $pr = $row['private_key'];
    //$pub = file_get_contents($pb);
    $pri = file_get_contents($pr);
}
?>

<!doctype html>
<html lang="en">

<head>

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

<body>



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

    <main class="tab-content" id="myTabContent">

        <section hidden class="rsa tab-pane fade show active" id="rsa" role="tabpanel" aria-labelledby="home-tab">



            <div class="keys">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <a hidden class="form-control" name="private-key-input" id="private-key-input">

                                    <?php
                                    echo $pri;
                                    ?>
                                </a>
                                </small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <a hidden class="form-control" name="public-key-input" id="public-key-input">
                                    <?php
                                    //  echo $pub;
                                    ?>
                                </a>
                                <small class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main>

    <section class="workbench" hidden>
        <center>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <form id="mmm" action="verify3.php" method="post">
                                <label for="message-input" hidden>Plaintext</label>
                                <textarea class="form-control" hidden name="message-plain" id="message-plain" cols="30" rows="10">
</textarea>
                                <h5>Server verifying Clients digital signature ... ... .... .. ... loading ... ... ... ...
                                </h5>
                                <h5>Please continue ... ... ... ... ... ... ... .......
                                    .... ....

                                    <input type="submit" id="decrypt" value="continue" class="button">
                        </div>


                        <button hidden id="encrypt" class="btn btn-success">Encrypt</button>
                    </div>
        </center>
        </form>
        <div class="col">
            <div class="form-group">

                <label for="message-result" hidden>Ciphertext</label>
                <textarea hidden class="form-control" name="message-cypher" id="message-cypher" cols="30" rows="10">
                    <?php
                    echo $message_cypher;
                    ?>
                </textarea>

            </div>
            <button hidden id="decrypt" class="btn btn-secondary float-right">Decrypt</button>
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
                        encrypt.setPrivateKey($('#public-key-input').val());

                        $("#message-plain").val("");
                        $("#message-cypher").val(encrypt.encrypt(message));
                        document.getElementById("message-cypher").value;


                    }

                }

            });

            /**
             * Decrypt Handler
             */
            $("#decrypt").on('click', function() {

                var ciphertext = $('#message-cypher').val();
                var currentTab = $(".nav-link.active").attr('aria-controls');

                if (ciphertext) {

                    if (currentTab === 'aes') {

                        var key = JSON.parse($("#aes-key-input").val());
                        counter = JSON.parse($("#aes-counter").val());

                        // When ready to decrypt the hex string, convert it back to bytes
                        var encryptedBytes = aesjs.utils.hex.toBytes(ciphertext);

                        // The counter mode of operation maintains internal state, so to
                        // decrypt a new instance must be instantiated.
                        var aesCtr = new aesjs.ModeOfOperation.ctr(key, new aesjs.Counter(counter));
                        var decryptedBytes = aesCtr.decrypt(encryptedBytes);

                        // Convert our bytes back into text
                        var decryptedText = aesjs.utils.utf8.fromBytes(decryptedBytes);

                        $("#message-cypher").val("");
                        $("#message-plain").val(decryptedText);


                    } else if (currentTab === 'rsa') {

                        // We're decrypting
                        var decrypt = new JSEncrypt();
                        decrypt.setPublicKey($('#private-key-input').val());

                        response = decrypt.decrypt(ciphertext);

                        $("#message-cypher").val("");
                        $("#message-plain").val(response);

                    }

                }

            });


        });
    </script>
</body>

</html>
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

<script>
    $(document).ready(function() {
        $("#decrypt").trigger('click');


    });
</script>