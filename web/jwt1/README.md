# Level 01 - JWT Algorithm Confusion

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:3001

# Hentikan challenge
docker-compose down
```

## Catatan

JSON Web Token (JWT) adalah standar terbuka (RFC 7519) yang mendefinisikan cara kompak dan mandiri untuk transmisi informasi secara aman antara pihak-pihak sebagai objek JSON. JWT sering digunakan untuk autentikasi dan pertukaran informasi dalam aplikasi web modern.

Setiap JWT terdiri dari tiga bagian yang dipisahkan oleh titik (.):
1. **Header** - Berisi tipe token dan algoritma yang digunakan
2. **Payload** - Berisi klaim (claims) atau data yang ingin dikirimkan
3. **Signature** - Digunakan untuk memverifikasi bahwa token tidak diubah

Namun, implementasi JWT yang tidak tepat dapat menyebabkan kerentanan keamanan yang serius. Salah satu kerentanan yang umum adalah **JWT Algorithm Confusion**, di mana aplikasi menerima algoritma yang tidak seharusnya diizinkan, seperti algoritma "none" yang tidak memerlukan signature sama sekali.

## Objective

Exploit kerentanan JWT untuk mendapatkan akses sebagai administrator dan ambil flag dari admin panel.
