# Level 01 - Unrestricted File Upload

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

Saat melakukan upload file ke sebuah website, sangat penting untuk memperhatikan bagaimana proses validasi file ditangani. Apakah website melakukan pengecekan terhadap jenis file, ekstensi, atau konten file yang diupload. Validasi yang tidak tepat dapat menyebabkan kerentanan yang berbahaya.

## Objective

Exploit kerentanan file upload untuk mendapatkan remote code execution dan ambil flag dari server.
