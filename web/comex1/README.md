# Level 01 - Command Execution

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8007

# Hentikan challenge
docker-compose down
```

## Catatan

Saat mengembangkan aplikasi yang berinteraksi dengan sistem operasi, sangat penting untuk memvalidasi dan membersihkan input pengguna sebelum menggunakannya dalam perintah sistem. Fungsi seperti `system()`, `exec()`, atau `shell_exec()` dapat menjadi sangat berbahaya jika menerima input yang tidak tervalidasi.

Perhatikan bagaimana aplikasi memproses input Anda. Apakah ada cara untuk memanipulasi perintah yang dijalankan? Operator shell seperti `&&`, `||`, `;`, dan `|` dapat digunakan untuk menggabungkan atau merantai perintah.

## Objective

Eksploitasi kerentanan command injection untuk mendapatkan akses ke sistem dan ambil flag dari server.
