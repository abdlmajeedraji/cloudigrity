
<?php
session_start();
require"conn.php";
$email  = $_SESSION['email'] ;
$query = "SELECT * FROM digitatl_certificate WHERE email='$email ' ";
$result = mysqli_query($con,$query) or die(mysqli_error());
                $result=mysqli_query($con,$query);
                $rows = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                if($rows==1){
                    $pb =$row['public_key']; 
              //      $pr =$row['private_key']; 
                    $pub = file_get_contents($pb);
                  //  $pri = file_get_contents($pr);
                    }
?>


<!DOCTYPE html>
<html>
	<head>
		<title>File Test</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script type="text/javascript" src="../cloudigrity/src/sha3.js"></script>
        <script type="text/javascript" >
            // How many bytes to read per chunk
            var chunkSize = Math.pow(10, 5)

            // Handle various I/O problems
            function errorHandler(evt) {
                switch(evt.target.error.code) {
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
                var progress = document.querySelector('#message-plain')
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
                                                 
                          } 
                          else {
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
                readFile(hasher1,file, 0, chunkSize)
            }
        </script>
    </head>
    <body>
            <input type="file" id="files" name="file" onchange="handleFileSelect(this)" />
            <div id ="progress"></div>
        </p>
        
        
<main class="tab-content" id="myTabContent" hidden>
	<section class="rsa tab-pane fade show active" id="rsa" role="tabpanel" aria-labelledby="home-tab">
		<div class="keys">
			<div class="container" >
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<a class="form-control" name="private-key-input" id="private-key-input"hidden >
                                      <?php 
                                  //    echo $pri;
                                ?>
                                    </a>
								</small>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<a class="form-control" name="public-key-input" id="public-key-input" >
                                      <?php 
                                      echo $pub;
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

<section class="workbench"  >

	<div class="container" >  
		<div class="row">
<center>
    <div class="col"> 
				<div class="form-group"> 
        <form  id="nnnn" action="verify2.php" method="post">

					<label for="message-result"  hidden>Ciphertext</label>
					<textarea  hidden class="form-control" name="message-cypher" id="message-cypher" cols="30"
                    rows="10"></textarea>
                    <h5>Application Communicating with server,Do you accept access your key details securely ? 
  </h5>    <h5>Waiting for client response ... ... ... ... ... ... ... .......
 ....  .... 
 <input type="submit" id="encrypt" value="Agree and continue" class="button"></input>
         </form > 
				</div>
				<button   hidden id="decrypt" class="btn btn-secondary float-right">Decrypt</button>
			</div>
  </center>
			<div class="col"> 
				<div class="form-group">
					<label for="message-input" hidden >Plaintext</label>
					<textarea  hidden class="form-control" name="message-input" id="message-plain" cols="30" rows="10">
                            
          </textarea>

				</div>
			</div> 
		
		</div>
	</div> 
  
</section>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- START Encryption Libs -->
<script src="vendor/jsencrypt.min.js"></script>
<script src="vendor/aes-js.js"></script>
<!-- END Encryption Libs -->
<script>
    $(document).ready(function () {
        /**
         * Save Field Values to LocalStorage for sessionPersistance;
         * @type {Array}
         */
        let saveFields = ['aes-key-input', 'public-key-input', 'private-key-input', 'aes-counter'];
        for (var i = 0; i < saveFields.length; i ++) {
            let $id = "#" + saveFields[i];
            let id = saveFields[i];
            $($id).val(window.localStorage.getItem(id));
            $($id).change(function () {
                window.localStorage.setItem(id, $(this).val());
            });
        }
        var counter;
        /**
         * Encrypt Handler
         */
        $("#encrypt").on('click', function () {
            var message = $('#message-plain').val();
            var currentTab = $(".nav-link.active").attr('aria-controls');
            var counter = $("#aes-counter").val();
            if (! counter) {
                counter = Math.floor(Math.random() * 1000000000);
                $("#aes-counter").val(counter);
            }
            if (message) {
               if (currentTab === 'rsa') {
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
        $("#decrypt").on('click', function () {
            var ciphertext = $('#message-cypher').val();
            var currentTab = $(".nav-link.active").attr('aria-controls');
            if (ciphertext) {
               if (currentTab === 'rsa') {
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