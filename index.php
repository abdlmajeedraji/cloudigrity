<!doctype html>
<html lang="en">
<?php
include("auth.php");
include("conn.php");
$email  = $_SESSION['email'];
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Cloudigrity - Home </title>

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
    <style>
        .avatar {
            vertical-align: middle;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        <style>.btn {
            background-color: DodgerBlue;
            border: none;
            color: white;
            padding: 12px 16px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Darker background on mouse-over */
        .btn:hover {
            background-color: RoyalBlue;
        }
    </style>

    <div class="header">
        <b> Cloudigrity</b> </br> <a style="font-family:serif">Outsource your files to the cloud securly
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

    <a style="color:white">..........................................................................</a>
    <a href="profile.php"><img src="avatar.png" alt="Profile picture" class="avatar">
        </br>
    </a>

    </img>

    <Center>

        Select a file to upload
        <form name="login" id="Signup-form" action="test71.php" method="post" enctype="multipart/form-data">
            <input type="file" id="file" name="file" onchange="handleFileSelect(this)" />
            <textarea hidden type="progress" name="progress" id="progress"></textarea>
            <div class="loader" id="loadingdiv"></div>
            <input type="submit" id="upload" name="submit_btn" value="upload">
        </form>
    </Center>

    <form method="POST" action="">
        <center>
            <input text="books" placeholder="File Name" name="books">
            <input type="submit" value="Search" id="button">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th><strong>
                        <center>No
                    </strong></th>
                <th><strong>
                        <center>File Name
                    </strong></th>
                <th><strong>
                        <center>File Owner
                    </strong></th>
                <th><strong>
                        <center>Date Uploaded
                    </strong></th>
                </th>
                <th><strong>
                        <center>Size
                    </strong></th>
                <th><strong>
                        <center>Download File
                    </strong></th>
                <th><strong>
                        <center>Update File
                    </strong></th>
                <th><strong>
                        <center>Check Integrity
                    </strong></th>
                <th><strong>
                        <center>Delete file
                    </strong></th>
            </tr>

        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "Select * from files ;";
            $result = mysqli_query($con, $sel_query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td align="center">
                        <center>
                            <?php echo $count; ?>
                    </td>
                    <td align="center">
                        <center>
                            <?php echo $row["file_name"];
                            ?>
                    </td>
                    <td align="center">
                        <center>
                            <?php

                            $id = $row["File_Creator_Id"];
                            $querys = "SELECT * FROM users WHERE user_id='$id' ";
                            $results = mysqli_query($con, $querys) or die(mysqli_error());
                            $results = mysqli_query($con, $querys);
                            $rowss = mysqli_num_rows($results);
                            $rows = mysqli_fetch_assoc($results);
                            if ($rowss == 1) {
                                $fname = $rows['fname'];
                                echo $fname;
                            }




                            ?>
                    </td>
                    <td align="center">
                        <center>
                            <?php echo $row["Date_of_Creation"];
                            ?>
                    </td>
                    </td>
                    <td align="center">
                        <center>
                            <?php echo $row["size"];
                            echo "kb";
                            ?>
                    </td>
                    <td align="center">
                        <center> <button class="btn">
                                <a href="download.php?id=<?php echo $row["file_id"]; ?>" onclick="return confirm('Are you sure you want to download this file ?');"> <i class="fa fa-download"></br>
                                        Download</a></i> </button>
                    </td>

                    <td align="center">
                        <center> <button class="btn">
                                <a href="edit.php?id=<?php echo $row["file_id"]; ?>">
                                    <i class="fa fa-upload"> <i class="fas fa-cloud"></i>
                                        </br>Update </i>
                                </a> </button>
                    </td>


                    <td align="center"> <button class="btn"><a href="integrity.php?id=<?php echo $row["file_id"]; ?>">
                                <center> Check Integrity
                            </a>
                        </button>
                        <center> integrity status
                            <?php
                            $y = $row["file_id"];
                            $qy = "SELECT * FROM files WHERE file_id=$y ";
                            $r = mysqli_query($con, $qy);
                            $rws = mysqli_num_rows($r);
                            $rw = mysqli_fetch_assoc($r);
                            if ($rws == 1) {
                                $status = $row['status'];
                                if ($status == 1) {
                                    echo "<img src='images/ok.jpeg' height=20 width=20> </img>";
                                } else
                                    echo "<img src='images/notok.png' height=20 width=20> </img>";
                            }
                            ?>


                        </center>

                    </td>

                    <td align="center">
                        <center>
                            <button class="btn">
                                <a href="delete.php?id=<?php echo $row["file_id"]; ?>" onclick="return confirm('Are you sure you want to delete this file ?');">
                                    <i class="fa fa-trash"> </br>
                                        Delete </i>
                                </a> </button>


                    </td>
                </tr>
            <?php $count++;
            } ?>
        </tbody>
    </table>
    </form>
    </center>
    <br>
    <center>
        <h6><?php $email  = $_SESSION['email'];
            echo  $email; ?>
            <a href="logout.php" class="logout">logout</a>
    </center>

    <footer>
        <center>
            <p> All right reserved-Cloudigrity, Author: Abdulmajeed Raji</p>
            <!-- Add icon library -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <!-- Add font awesome icons -->
            <a href="mailto:rajiabdulmajeed52@gmail.com" class="fa fa-google"></a>
            <a href="https://facebook.com/raji.abdulmajeed" class="fa fa-facebook"></a>
            <a href="https://linkedin.com/in/abdulmajeed-raji-b90b4757" class="fa fa-linkedin"></a>
            <a href="https://twitter.com/abdlmajeed_raji?s=09" class="fa fa-twitter"></a>
            </p>
        </center>
    </footer>
    <style>
        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-google {
            background: #dd4b39;
            color: white;
        }

        .fa-linkedin {
            background: #007bb5;
            color: white;
        }

        footer {
            bottom: 100;
            left: 0;
            position: absolute;
            right: 0;
        }
    </style>



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
    </script>
</body>

</html>