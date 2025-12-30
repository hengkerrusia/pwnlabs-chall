# Level 02 - JSON Endpoint Information Disclosure

## Cara Menjalankan

```bash
# Jalankan challenge
docker-compose up -d

# Akses aplikasi di browser
http://localhost:5002

# Hentikan challenge
docker-compose down
```

## Catatan

Modern web frameworks seperti Rails, Django, dan Flask sering menyediakan fitur content negotiation yang memungkinkan endpoint yang sama mengembalikan berbagai format response (HTML, JSON, XML, dll). Fitur ini sangat berguna untuk API development, namun dapat menjadi celah keamanan jika tidak ditangani dengan hati-hati.

Developer sering kali fokus pada keamanan tampilan HTML dan lupa bahwa data yang sama dapat diakses melalui format lain. Misalnya, data sensitif yang disembunyikan di HTML view mungkin masih terekspos melalui JSON endpoint yang dibuat secara otomatis oleh framework atau ditambahkan untuk "kemudahan API".

Penting untuk memastikan bahwa filtering dan authorization diterapkan di semua endpoint dan format response, bukan hanya di layer presentasi HTML.

## Objective

Temukan cara untuk mengakses API key yang tersembunyi dan dapatkan flag dari akun administrator.
