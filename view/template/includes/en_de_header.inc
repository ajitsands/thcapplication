<?PHP

class URLEncription
{
    public $iv_size, $key;
    
    // AES-128-CBC cipher (same as MCRYPT_RIJNDAEL_128 + MCRYPT_MODE_CBC)
    private $cipher = 'AES-128-CBC';

    function __construct()
    {
        // Use first 16 bytes of the key for AES-128 (128-bit = 16 bytes)
        $rawKey = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        $this->key = substr($rawKey, 0, 16);
        $this->iv_size = openssl_cipher_iv_length($this->cipher); // 16 bytes for AES-CBC
    }
    

    public function URLEncode($plaintext)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_size);
        // PKCS7 padding is handled by openssl; use false to match mcrypt zero-padding behaviour
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        // Prepend IV (same format as mcrypt version)
        $ciphertext = $iv . $ciphertext;
        return $this->base64url_encode($ciphertext);
    }

    public function URLDecode($dcode_string)
    {
        $ciphertext_dec = $this->base64url_decode($dcode_string);
        $iv_dec = substr($ciphertext_dec, 0, $this->iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
        $plaintext_dec = openssl_decrypt($ciphertext_dec, $this->cipher, $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv_dec);
        parse_str(rtrim($plaintext_dec, "\0"), $parsed);
        return $parsed;
    }

    public function KEYDecode($dcode_string)
    {
        $ciphertext_dec = $this->base64url_decode($dcode_string);
        $iv_dec = substr($ciphertext_dec, 0, $this->iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
        $plaintext_dec = openssl_decrypt($ciphertext_dec, $this->cipher, $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv_dec);
        return rtrim($plaintext_dec, "\0");
    }
    
    public function base64url_encode($data) {
        $data = str_replace(array('+', '/'), array('-', '_'), base64_encode($data));
        return $data;
    }
    
    public function base64url_decode($data) {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
    }
    
}


?>


