# Level 02 - Case-Insensitive Authentication Bypass

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8002

# Hentikan challenge
docker-compose down
```

## Catatan

Dalam pengembangan aplikasi web, penting untuk memahami bagaimana database dan bahasa pemrograman menangani perbandingan string. Perbedaan antara case-sensitive dan case-insensitive comparison dapat menyebabkan celah keamanan yang serius, terutama dalam sistem autentikasi.

Perhatikan bagaimana validasi dilakukan di berbagai layer aplikasi - apakah konsisten antara validasi input, query database, dan pengecekan authorization?

## Objective

Dapatkan akses sebagai administrator dan ambil flag dari dashboard admin.

