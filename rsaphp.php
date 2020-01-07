
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
$hashValue = hash('sha3-512', $str);
$hashValue = preg_replace('/[0-9]/','',$hashValue);
/////////////////////////////RSA 
$public_key = file_get_contents('public.pem');
$private_key = file_get_contents('private.pem');


openssl_public_encrypt($hashValue, $encrypted, $public_key)."\n";
$public_key=":::";
echo "Encrypted:$encrypted\n";
$b64_enc = base64_encode($encrypted);
$b64_dec = base64_decode($b64_enc);
print openssl_private_decrypt($b64_dec, $decrypted, $private_key)."\n";
echo "<br>Decrypted text : $decrypted\n";

///////////////////////check hash
if (hash('sha3-512',$str) === 'fe2ab1ac3816dc426167e5794b88e1c829281bc895212df4df037b08633e0a0e38047d713f65ebc54fca91503f3ed56535f13ba774ae46036284f9463d105599') {
    echo "<br> Would you like a green or red apple?";
}

?>
