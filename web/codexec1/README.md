# Level 01 - Code Execution

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:8085

# Hentikan challenge
docker-compose down
```

## Catatan

Dalam pengembangan aplikasi web, input dari pengguna harus selalu diperlakukan sebagai tidak terpercaya. Fungsi-fungsi berbahaya seperti `eval()`, `exec()`, atau `system()` sebaiknya dihindari, terutama jika menerima data dari pengguna tanpa validasi yang ketat.

Perhatikan bagaimana aplikasi memproses input Anda. Apakah ada tanda-tanda bahwa input tersebut diproses secara dinamis? Error message yang muncul terkadang dapat memberikan petunjuk tentang teknologi dan fungsi yang digunakan.

## Objective

Eksploitasi kerentanan untuk menjalankan perintah sistem dan dapatkan flag dari server.
