# Level 03 - Missing Exit After Redirect

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8003

# Hentikan challenge
docker-compose down
```

## Catatan

Dalam pengembangan web dengan PHP, fungsi `header()` digunakan untuk mengirim HTTP header, termasuk redirect. Namun, penting untuk dipahami bahwa `header()` **tidak menghentikan eksekusi script**. Setelah memanggil `header("Location: ...")`, kode PHP akan tetap berjalan kecuali ada perintah `exit` atau `die()`.

Kesalahan umum yang sering terjadi adalah developer berasumsi bahwa redirect akan otomatis menghentikan eksekusi, padahal halaman tetap diproses dan dikirim ke browser. Hal ini dapat menyebabkan celah keamanan serius, terutama pada halaman yang seharusnya dilindungi dengan autentikasi.

## Objective

Dapatkan akses sebagai administrator dan ambil flag dari dashboard admin.
