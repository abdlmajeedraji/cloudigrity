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
                            progress.innerHTML += '<p>SHA3-512: ' + result1 + '</p>';
                            

                         
                         
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
                readFile(hasher1,file, 0, chunkSize)
            }
        </script>
    </head>
    <body>
            <input type="file" id="files" name="file" onchange="handleFileSelect(this)" />
        </p>
        NOTE: This may not work in Internet Explorer
        <div id="progress"></div>
    </body>
</html>