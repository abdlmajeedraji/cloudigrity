
<?php
$name ="Ali";
$id =123;
$Q = array(
    $name,
    $id,
    "StackOverflow") ;
$str = implode(" ",$Q); // convert string
//$str = 'apple';
//echo hash('sha3-512', 'apple');
 $hashValue = hash('sha3-512',"ali");
 echo $hashValue; echo"<br>";
/////////////////////////////RSA 
$public_key = file_get_contents('public.pem');
$private_key = file_get_contents('private.pem');
//
/*
$enc = base64_encode($hashValue);
echo "<br>Encoded:$enc\n";
$dec = base64_decode($enc); */
$json_data = '{
    "card_number": "1111-1111-1111-1111",
    "csv": "222",
    "exp_month": "03",
    "exp_year": "2016"
}';

$iv = openssl_random_pseudo_bytes(32);

openssl_seal($hashValue, $encrypted, $ekeys, array($public_key ), "AES256", $iv);
//echo
//echo "Encrypted:$encrypted\n";
$b64_enc = base64_encode($encrypted);
//echo "<br>Encoded:$b64_enc\n";
$b64_dec = base64_decode($b64_enc);
$pkeyid = openssl_get_privatekey($private_key);
//echo $pkeyid;
openssl_open($encrypted, $decrypted, $iv, $private_key);
//echo $decrypted;
/*if (openssl_open($encrypted, $decrypted, $iv, $pkeyid)) {
    echo "<br>Decrypted text : $dencrypted";
} else {
    echo "failed to open data";
}
*/

///////////////////////check hash
if (hash('sha3-512',$str) === 'fe2ab1ac3816dc426167e5794b88e1c829281bc895212df4df037b08633e0a0e38047d713f65ebc54fca91503f3ed56535f13ba774ae46036284f9463d105599') {
    //echo "<br> Would you like a green or red apple?";
}

?>
