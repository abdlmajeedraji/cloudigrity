<html lang="es">
<head>
  <meta charset="utf-8">
  <title>CryptoJS Example</title>
  <meta name="description" content="CryptoJs Example">
  <meta name="author" content="Gabriel Porras">
  <!--
  https://cdnjs.com/libraries/crypto-js 
  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
  <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
</body>
  <strong><label>Original String:</label></strong>
  <span id="demo0"></span>
  <br>
  <br>
  <strong><label>Encrypted:</label></strong>
  <span id="demo1"></span>

  <br>
  <br>
  <strong><label>Decrypted:</label></strong>
  <span id="demo2"></span>
  <br> 
  <br>
  <strong><label>String after Decryption:</label></strong>
  <span id="demo3"></span>
  <br />
  <br />
  <strong style="color: red;">CryptoJS is no longer maintained. Take a look of another JS Crypto Libraries in my <a href="https://github.com/gabrielizalo/JavaScript-Crypto-Libraries" target="_blank">GibHub List</a></strong>.
</html>
<Script>
// INIT
var x = Math.floor(Math.random() * 9000000) ;
//alert(x);
var myString   = "https://www.titanesmedellin.com/";
var password ="Generated password"

//var x =  Math.random();
var encrypted = CryptoJS.AES.encrypt(myString,password);
var decrypted = CryptoJS.AES.decrypt(encrypted,password).toString(CryptoJS.enc.Utf8);


//var encrypted = CryptoJS.AES.encrypt("stringForEncryption", "123");
// PROCESS
alert(encrypted);
alert(decrypted);

//var encrypted = CryptoJS.AES .encrypt(myString, Password);
//var decrypted = CryptoJS.AES.decrypt(encrypted, Password);
document.getElementById("demo0").innerHTML = myString;
document.getElementById("demo1").innerHTML = encrypted;
document.getElementById("demo2").innerHTML = decrypted;
document.getElementById("demo3").innerHTML = decrypted.toString(CryptoJS.enc.Utf8);

</script>
