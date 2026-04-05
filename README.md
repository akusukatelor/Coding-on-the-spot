Link drive: https://drive.google.com/drive/folders/1brsP9GWHYCAzcQ-VNsQIjlAkJaNBB3SW?usp=sharing


Dokumentasi Projek SIMAMAT (Sistem Mahasiswa Hemat)
SIMAMAT adalah aplikasi berbasis web yang dirancang untuk membantu mahasiswa dalam mengelola dan memantau aktivitas keuangan akademik maupun pribadi. Aplikasi ini mengutamakan efisiensi pencatatan transaksi dan visualisasi data anggaran secara real-time.

1. Daftar Struktur Folder Penting
Dalam pengembangan aplikasi ini menggunakan Framework Laravel, berikut adalah folder dan file utama yang merepresentasikan logika program:

    simamat/
├── app/
│   ├── Http/Controllers/  <-- Logika Program
│   └── Models/            <-- Struktur Database
├── database/
│   └── migrations/        <-- Skema Tabel
├── resources/
│   └── views/             <-- Tampilan (Blade)
└── routes/                <-- Pengatur URL

    - app/Models/: Berisi file User.php, Transaction.php, dan Category.php. Folder ini berfungsi untuk mengatur skema data dan relasi antar tabel di database.

    - app/Http/Controllers/: Berisi logika utama aplikasi.
        - AuthController.php: Mengatur sistem login dan logout.
        - DashboardController.php: Mengatur tampilan ringkasan data di halaman utama.
        - TransactionController.php: Mengatur alur CRUD transaksi.
        - CategoryController.php: Mengatur manajemen kategori dan target budget.
        - ReportController.php: Mengatur pemrosesan data untuk grafik laporan.
    - database/migrations/: Berisi file rancangan tabel database (Schema) untuk tabel users, categories, dan transactions.

    - database/seeders/: Berisi file UserSeeder.php untuk membuat akun akses awal secara otomatis.

    - resources/views/: Berisi file tampilan (UI) aplikasi dengan format .blade.php.
        - layouts/app.blade.php: Template utama (Sidebar & Header).
        - auth/login.blade.php: Halaman login.
        - dashboard.blade.php, transaksi.blade.php, kategori.blade.php, report.blade.php.
    - routes/web.php: File pengatur jalur (routing) URL aplikasi.
    - public/: Tempat menyimpan aset statis seperti CSS, JavaScript, dan library (Bootstrap, JQuery, Chart.js).

2. Spesifikasi Teknologi 
Projek ini telah memenuhi seluruh komponen penilaian sebagai berikut:
    1. Framework: Menggunakan Laravel 11 sebagai engine utama.

    2. Frontend: Menggunakan Bootstrap 5 untuk desain responsif dan modern.

    3. Interaktivitas: Menggunakan library JQuery untuk menangani event pada halaman.

    4. Pengolahan Data Dinamis: Menggunakan AJAX untuk pengiriman data form (Tambah Transaksi & Kategori) tanpa reload halaman.

    5. Database: Menggunakan Mysql sebagai penyimpanan data.

    6. Format Data: Respon dari server dikirimkan dalam format JSON untuk memastikan komunikasi data yang cepat dan ringan.

    7. Visualisasi: Menggunakan plugin Chart.js untuk menampilkan grafik tren arus kas dan alokasi anggaran.


3. Langkah-Langkah Instalasi
Untuk menjalankan program ini di lingkungan lokal, ikuti prosedur berikut:
    1. Persiapan Folder: Pastikan semua file projek sudah berada di direktori server (XAMPP/htdocs atau folder kerja).

    2. Instalasi Dependensi: Buka terminal pada root folder projek, lalu jalankan:
        composer install

    3. Konfigurasi Environment:
        - Salin file .env.example dan ubah namanya menjadi .env.
        - Sesuaikan bagian DB_DATABASE=simamat, DB_USERNAME, dan DB_PASSWORD sesuai konfigurasi MySQL Anda.
    4. Generate Key:
        php artisan key:generate
    5. Setup Database: Jalankan perintah berikut untuk membuat tabel sekaligus memasukkan data akun admin (Seeder):
        php artisan migrate:fresh --seed
    6. Menjalankan Aplikasi:
        php artisan serve
        Buka browser dan akses http://127.0.0.1:8000.

4. Kredensial Login
Akses sistem telah disediakan melalui Seeder dengan data sebagai berikut:
    - Email: sihemat@gmail.com
    - Password: password123

5. Logika Database dan Relasi
Aplikasi ini menerapkan relasi One-to-Many antara tabel categories dan transactions.

    - Setiap satu Kategori dapat memiliki banyak Transaksi.

    - Pada tabel transactions terdapat kolom category_id yang berfungsi sebagai Foreign Key.

    - Sistem menggunakan fitur onDelete('cascade'), sehingga apabila sebuah kategori dihapus, maka seluruh data transaksi yang terkait dengan kategori tersebut akan dihapus secara otomatis untuk menjaga integritas data.

6. Penjelasan Teknis Implementasi JSON dan AJAX
Sesuai dengan poin penilaian nomor 5 pada rubrik:

    - Pengiriman Data: Saat pengguna menekan tombol "Simpan Transaksi", JQuery menangkap data form dan mengirimkannya melalui $.ajax ke Controller.

    - Validasi & Respon: Controller melakukan validasi data di sisi server. Jika valid, Controller mengirimkan objek JSON berupa {"success": true, "message": "..."}.

    - Eksekusi Client: Browser menerima JSON tersebut, menutup modal secara otomatis, dan memberikan notifikasi keberhasilan kepada pengguna.

    
