#!/usr/bin/env python3
import base64

# Secret key for XOR encryption (must match the key in config.php)
XOR_KEY = b'S3cur3Auth_K3y_2024!@#'

def xor_encrypt(data, key):
    """XOR encrypt a string with a key"""
    output = bytearray()
    key_length = len(key)
    data_bytes = data.encode('utf-8') if isinstance(data, str) else data
    
    for i, byte in enumerate(data_bytes):
        output.append(byte ^ key[i % key_length])
    
    return bytes(output)

def encode_flag(flag):
    """Encode flag using multi-layer obfuscation"""
    # Layer 1: XOR encryption
    xored = xor_encrypt(flag, XOR_KEY)
    
    # Layer 2: Base64 encode
    base64_once = base64.b64encode(xored)
    
    # Layer 3: Base64 encode again
    base64_twice = base64.b64encode(base64_once)
    
    return base64_twice.decode('utf-8')

def decode_flag(encoded):
    """Decode flag (for verification)"""
    # Reverse layer 3: Base64 decode
    base64_once = base64.b64decode(encoded)
    
    # Reverse layer 2: Base64 decode
    xored = base64.b64decode(base64_once)
    
    # Reverse layer 1: XOR decrypt (XOR is symmetric)
    flag = xor_encrypt(xored, XOR_KEY)
    
    return flag.decode('utf-8')

# Main execution
if __name__ == '__main__':
    flag = "PwnLabs{c00k13_4uth_1s_n0t_s3cur3_4t_4ll}"
    
    print("=" * 50)
    print("         Flag Encoder Utility (XOR + Base64)    ")
    print("=" * 50)
    print()
    
    # Encode the flag
    encoded = encode_flag(flag)
    
    # Verify by decoding
    decoded = decode_flag(encoded)
    
    print(f"Original Flag:  {flag}")
    print(f"Encoded Flag:   {encoded}")
    print()
    
    # Verification
    if decoded == flag:
        print("✅ Verification: SUCCESS (encoding/decoding works correctly)")
    else:
        print("❌ Verification: FAILED")
        print(f"Decoded result: {decoded}")
    
    print()
    print("=" * 50)
    print("Copy the encoded flag above and paste it into")
    print("docker-compose.yml as the FLAG_OBFUSCATED value.")
    print("=" * 50)
