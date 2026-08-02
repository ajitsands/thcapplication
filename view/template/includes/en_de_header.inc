<?PHP

class URLEncription
{
    public $iv_size, $key;

    // MCRYPT_RIJNDAEL_128 + 32-byte key = AES-256-CBC in OpenSSL
    // Block size = 128-bit (16 bytes), Key size = 256-bit (32 bytes)
    private $cipher = 'AES-256-CBC';

    function __construct()
    {
        // Full 32-byte key (64 hex chars) — DO NOT truncate to 16 bytes
        // Original mcrypt used this full key with RIJNDAEL_128 = AES-256
        $this->key    = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        $this->iv_size = openssl_cipher_iv_length($this->cipher); // 16 bytes
    }

    public function URLEncode($plaintext)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_size);
        // Use standard PKCS7 padding (OPENSSL_RAW_DATA only, no ZERO_PADDING)
        // This handles any plaintext length without needing manual padding
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        // Prepend IV (same format as old mcrypt version)
        $ciphertext = $iv . $ciphertext;
        return $this->base64url_encode($ciphertext);
    }

    public function URLDecode($dcode_string)
    {
        if (empty($dcode_string)) return [];
        $ciphertext_dec = $this->base64url_decode($dcode_string);
        if (strlen($ciphertext_dec) <= $this->iv_size) return [];
        $iv_dec         = substr($ciphertext_dec, 0, $this->iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
        // Decrypt with PKCS7 — returns clean string, no need to rtrim null bytes
        $plaintext_dec  = openssl_decrypt($ciphertext_dec, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);
        if ($plaintext_dec === false) return [];
        $parsed = [];
        parse_str($plaintext_dec, $parsed);
        return $parsed;
    }

    public function KEYDecode($dcode_string)
    {
        if (empty($dcode_string)) return '';
        $ciphertext_dec = $this->base64url_decode($dcode_string);
        if (strlen($ciphertext_dec) <= $this->iv_size) return '';
        $iv_dec         = substr($ciphertext_dec, 0, $this->iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
        $plaintext_dec  = openssl_decrypt($ciphertext_dec, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);
        return ($plaintext_dec !== false) ? $plaintext_dec : '';
    }

    public function base64url_encode($data) {
        return str_replace(['+', '/'], ['-', '_'], base64_encode($data));
    }

    public function base64url_decode($data) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

}


?>

