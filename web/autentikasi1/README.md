# Level 01 - Insecure Cookie Authentication

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8001

# Hentikan challenge
docker-compose down
```

## Catatan

Saat melakukan login ke sebuah website, sangat penting untuk memperhatikan bagaimana proses autentikasi ditangani. Apakah website menggunakan token melalui cookie, session, atau header. Apa pun mekanisme yang digunakan, token yang diterima setelah login harus selalu diperiksa.

## Objective

Dapatkan akses sebagai administrator dan ambil flag dari dashboard admin.

