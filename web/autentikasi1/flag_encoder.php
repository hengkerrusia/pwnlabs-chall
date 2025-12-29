#!/usr/bin/env php
<?php
/**
 * Flag Encoder Utility
 * 
 * This script encodes flags using multi-layer obfuscation:
 * 1. XOR encryption with a secret key
 * 2. Base64 encode the XOR result
 * 3. Base64 encode again for additional obfuscation
 * 
 * Usage: php flag_encoder.php "FLAG{your_flag_here}"
 */

// Secret key for XOR encryption (must match the key in config.php)
define('XOR_KEY', 'S3cur3Auth_K3y_2024!@#');

/**
 * XOR encrypt a string with a key
 */
function xor_encrypt($data, $key) {
    $output = '';
    $keyLength = strlen($key);
    $dataLength = strlen($data);
    
    for ($i = 0; $i < $dataLength; $i++) {
        $output .= $data[$i] ^ $key[$i % $keyLength];
    }
    
    return $output;
}

/**
 * Encode flag using multi-layer obfuscation
 */
function encode_flag($flag) {
    // Layer 1: XOR encryption
    $xored = xor_encrypt($flag, XOR_KEY);
    
    // Layer 2: Base64 encode
    $base64_once = base64_encode($xored);
    
    // Layer 3: Base64 encode again
    $base64_twice = base64_encode($base64_once);
    
    return $base64_twice;
}

/**
 * Decode flag (for verification)
 */
function decode_flag($encoded) {
    // Reverse layer 3: Base64 decode
    $base64_once = base64_decode($encoded);
    
    // Reverse layer 2: Base64 decode
    $xored = base64_decode($base64_once);
    
    // Reverse layer 1: XOR decrypt (XOR is symmetric)
    $flag = xor_encrypt($xored, XOR_KEY);
    
    return $flag;
}

// Main execution
if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

echo "=================================================\n";
echo "         Flag Encoder Utility (XOR + Base64)    \n";
echo "=================================================\n\n";

// Get flag from command line argument or prompt
if (isset($argv[1])) {
    $flag = $argv[1];
} else {
    echo "Enter the flag to encode: ";
    $flag = trim(fgets(STDIN));
}

if (empty($flag)) {
    die("Error: Flag cannot be empty.\n");
}

// Encode the flag
$encoded = encode_flag($flag);

// Verify by decoding
$decoded = decode_flag($encoded);

echo "Original Flag:  $flag\n";
echo "Encoded Flag:   $encoded\n\n";

// Verification
if ($decoded === $flag) {
    echo "✅ Verification: SUCCESS (encoding/decoding works correctly)\n\n";
} else {
    echo "❌ Verification: FAILED\n";
    echo "Decoded result: $decoded\n\n";
}

echo "=================================================\n";
echo "Copy the encoded flag above and paste it into\n";
echo "docker-compose.yml as the FLAG_OBFUSCATED value.\n";
echo "=================================================\n";
