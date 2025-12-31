# Level 01 - Directory Traversal

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8080

# Hentikan challenge
docker-compose down
```

## Catatan

Saat mengembangkan aplikasi yang menyajikan file kepada pengguna, sangat penting untuk memvalidasi path file yang diminta. Jika aplikasi langsung menggabungkan input pengguna dengan path direktori tanpa validasi, penyerang dapat menggunakan karakter khusus seperti `../` untuk keluar dari direktori yang diizinkan dan mengakses file sensitif di sistem.

Perhatikan bagaimana aplikasi memuat dan menyajikan file. Apakah ada parameter yang menerima nama file? Bagaimana aplikasi memproses parameter tersebut? Operator traversal seperti `../` dapat digunakan untuk navigasi ke direktori parent dan mengakses file di luar direktori yang seharusnya.

## Objective

Eksploitasi kerentanan directory traversal untuk mengakses file sensitif sistem dan ambil flag dari server.

