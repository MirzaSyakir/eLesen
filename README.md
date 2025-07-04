# eLesen - Sistem Pengurusan Lesen Perniagaan

Sistem pengurusan lesen perniagaan atas talian untuk Majlis Daerah Pasir Mas.

## Ciri-ciri

- ✅ Pendaftaran akaun pengguna
- ✅ Log masuk/log keluar
- ✅ Dashboard pengguna
- ✅ Pengurusan sesi yang selamat
- ✅ Antara muka yang mesra pengguna

## Keperluan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)
- XAMPP/WAMP/MAMP

## Pemasangan

### 1. Clone atau Download Projek
```bash
git clone [repository-url]
cd eLesen
```

### 2. Setup Database
1. Buka phpMyAdmin atau MySQL client
2. Import fail `database/elesen.sql`
3. Database akan dicipta secara automatik dengan data sampel

### 3. Konfigurasi Database
Edit fail `api/config/database.php` dan ubah maklumat sambungan:
```php
private $host = 'localhost';
private $db_name = 'elesen_db';
private $username = 'root';  // Ubah jika perlu
private $password = '';      // Ubah jika perlu
```

### 4. Akses Sistem
1. Jalankan web server (XAMPP/WAMP/MAMP)
2. Buka browser dan pergi ke `http://localhost/eLesen`
3. Sistem akan mengalihkan anda ke halaman log masuk

## Akaun Sampel

Untuk tujuan ujian, sistem telah disediakan dengan akaun sampel:

### Akaun 1
- **Nombor IC:** 900101015432
- **Kata Laluan:** password
- **Nama:** Ahmad bin Abdullah

### Akaun 2
- **Nombor IC:** 850202025678
- **Kata Laluan:** password
- **Nama:** Siti binti Mohamed

## Struktur Fail

```
eLesen/
├── api/
│   ├── auth/
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── logout.php
│   │   └── validate.php
│   └── config/
│       └── database.php
├── database/
│   └── elesen.sql
├── includes/
│   ├── header.php
│   └── footer.php
├── page/
│   ├── login.php
│   ├── signup.php
│   ├── dashboard.php
│   └── logout.php
├── image/
│   └── Logo-Majlis-Daerah-Pasir-Mas.png
├── index.php
└── README.md
```

## API Endpoints

### Authentication
- `POST /api/auth/login.php` - Log masuk pengguna
- `POST /api/auth/register.php` - Daftar akaun baharu
- `POST /api/auth/logout.php` - Log keluar pengguna
- `GET /api/auth/validate.php` - Sahkan sesi pengguna

## Keselamatan

- Kata laluan di-hash menggunakan `password_hash()`
- Sesi menggunakan token yang selamat
- Input validation untuk semua medan
- Protection terhadap SQL injection
- CORS headers untuk API

## Pembangunan

Untuk menambah ciri baharu:

1. Buat fail PHP baharu di folder yang sesuai
2. Tambah jadual baharu ke database jika perlu
3. Update API endpoints jika diperlukan
4. Test semua fungsi sebelum deploy

## Sokongan

Untuk sebarang pertanyaan atau masalah teknikal, sila hubungi pasukan pembangunan.

---

**Dibangunkan untuk Majlis Daerah Pasir Mas** 