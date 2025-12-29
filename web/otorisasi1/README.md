# Level 01 - Insecure Direct Object Reference (IDOR)

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8004

# Hentikan challenge
docker-compose down
```

## Catatan

Dalam pengembangan aplikasi web, penting untuk membedakan antara **autentikasi** dan **otorisasi**. Autentikasi memverifikasi identitas pengguna ("Siapa kamu?"), sedangkan otorisasi menentukan apakah pengguna memiliki hak akses ke resource tertentu ("Apakah kamu boleh mengakses ini?").

Kesalahan umum yang sering terjadi adalah developer hanya memeriksa apakah pengguna sudah login (autentikasi), tetapi tidak memverifikasi apakah pengguna tersebut berhak mengakses resource yang diminta (otorisasi). Hal ini dapat menyebabkan celah keamanan IDOR (Insecure Direct Object Reference), di mana pengguna dapat mengakses data milik pengguna lain hanya dengan mengubah parameter ID di URL.

## Objective

Dapatkan akses ke informasi milik administrator dan ambil flag dari data tersebut.