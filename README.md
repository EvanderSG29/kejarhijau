# KejarHijau

Proyek KejarHijau adalah aplikasi berbasis Laravel dengan antarmuka yang menggunakan Tailwind CSS. Dokumentasi ini memberikan panduan lengkap bagi tim dan kontributor untuk melakukan instalasi, konfigurasi, dan pengembangan proyek di lingkungan lokal yang aman lintas platform (Windows, macOS, Linux).

---

## Prasyarat Sistem

Sebelum memulai, pastikan perangkat lunak berikut telah terinstal di komputer Anda:
- **PHP** (Versi 8.1 atau lebih baru)
- **Composer** (Manajer dependensi PHP)
- **Node.js & npm** (Untuk kompilasi aset *frontend*)
- **Database** (MySQL, PostgreSQL, atau SQLite)
- **Git** (Untuk manajemen versi)

---

## Langkah-Langkah Instalasi (Cross-Platform)

Panduan berikut memastikan semua developer memulai dari titik yang sama. Dapat dilakukan melalui terminal (Linux/macOS) maupun PowerShell/CMD (Windows).

1. **Clone Repositori**
   ```bash
   git clone <URL_REPOSITORI>
   cd kejarhijau
   ```

2. **Instal Dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend (NPM)**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment (File `.env`)**
   Anda perlu menggandakan file konfigurasi `.env.example` menjadi `.env`.
   - **Windows (Command Prompt / PowerShell):**
     ```powershell
     copy .env.example .env
     ```
   - **Linux / macOS:**
     ```bash
     cp .env.example .env
     ```

5. **Buat Application Key**
   ```bash
   php artisan key:generate
   ```

---

## Konfigurasi Database & Data Seeder

Untuk memastikan *workflow* aplikasi berjalan dengan lancar saat dites di komputer baru, kita mengandalkan *Database Seeder* untuk menyiapkan data awal. 

1. **Konfigurasi .env**
   Buka file `.env` dan sesuaikan blok konfigurasi database dengan lingkungan lokal DBMS Anda. Contoh untuk MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kejarhijau_db
   DB_USERNAME=root
   DB_PASSWORD=password_anda
   ```
   *(Catatan: Anda harus membuat database kosong di sistem Anda dengan nama `kejarhijau_db` terlebih dahulu).*

2. **Migrasi dan Eksekusi Seeder**
   Jalankan perintah berikut untuk membangun struktur tabel sekaligus mengisi data awal. **Langkah ini sangat penting** agar aplikasi dan seluruh alur kerjanya bisa langsung digunakan (misalnya: data *role* admin, kategori bawaan, dsb):
   ```bash
   php artisan migrate --seed
   ```

---

## Menjalankan Aplikasi

Aplikasi membutuhkan dua buah server agar berjalan sempurna: satu untuk logika *backend* dan satu lagi untuk me-*render* aset *frontend* (Tailwind).

Silakan buka **dua terminal yang berbeda** dan jalankan perintah ini secara bersamaan:

- **Terminal 1 (Backend - Laravel):**
  ```bash
  php artisan serve
  ```
  *(Aplikasi Anda dapat diakses di `http://localhost:8000`)*

- **Terminal 2 (Frontend - Vite/Tailwind):**
  ```bash
  npm run dev
  ```
  *(Perintah ini bertugas untuk memantau perubahan file dan menerapkan *update* Tailwind CSS secara *real-time*).*

---

## Panduan & Saran Penggunaan Tailwind CSS

Antarmuka (UI) dari aplikasi ini masih terus ditingkatkan dan disempurnakan. Agar pengembangan *frontend* tetap rapi dan terukur, perhatikan panduan berikut:

1. **Gunakan Laravel Blade Components**: Hindari mengulang-ulang susunan *utility class* yang panjang (seperti desain tombol, kartu, atau *input form*). Ekstraklah elemen tersebut menjadi *Blade Component* (`resources/views/components/`) sehingga mudah digunakan kembali.
2. **Mobile-First Approach**: Karena Tailwind menggunakan pendekatan *mobile-first*, desainlah UI untuk layar kecil terlebih dahulu. Gunakan *breakpoint* seperti `sm:`, `md:`, dan `lg:` untuk mengatur tata letak pada layar komputer dan tablet.
3. **Fleksibilitas Layout**: Gunakan `flex` dan `grid` untuk membangun *layout* yang kompleks namun mudah dikelola.
4. **Warna & Konfigurasi**: Manfaatkan palet warna standar Tailwind. Jika butuh warna *custom* khusus perusahaan/branding, daftarkan di dalam file `tailwind.config.js` alih-alih menggunakan *arbitrary class* (contoh: gunakan `bg-hijau-utama` daripada `bg-[#2a9d8f]`).
5. **Kebersihan Kode**: Hindari penulisan *class* yang kontradiktif di satu elemen (misalnya `p-4 p-8`).

---

## Aturan Penulisan Git Commit

Untuk menjaga agar rekam jejak repositori tetap rapi dan profesional, kita menggunakan **Conventional Commits**. **Istilah (*Type*) wajib menggunakan Bahasa Inggris** untuk standarisasi alat pelacakan, sedangkan **deskripsi ditulis menggunakan Bahasa Indonesia yang formal dan jelas**.

### Format Dasar:
```text
<type>(<scope>): <pesan atau ringkasan perubahan>

<penjelasan opsional yang lebih detail (jika ada)>
```

### Daftar Istilah (Type) yang Diwajibkan:
- **`feat`**: Menambahkan fitur baru ke dalam aplikasi (misalnya: membuat halaman dasbor pengguna).
- **`fix`**: Memperbaiki masalah atau *bug* pada kode (misalnya: memperbaiki validasi formulir registrasi).
- **`docs`**: Perubahan yang hanya menyangkut dokumentasi (seperti: mengubah file `README.md`).
- **`style`**: Perbaikan gaya penulisan kode yang tidak memengaruhi logika aplikasi (seperti: menghapus spasi kosong, merapikan lekukan baris/*indentation*).
- **`refactor`**: Mengubah struktur kode tanpa menambah fitur baru atau memperbaiki *bug* (seperti: menyederhanakan sebuah fungsi, memecah kode ke komponen).
- **`perf`**: Perubahan yang berfokus pada peningkatan performa aplikasi (seperti: optimalisasi kueri *database*).
- **`test`**: Menambahkan atau mengubah pengujian (*unit* atau *feature tests*).
- **`build`**: Perubahan yang berkaitan dengan dependensi proyek atau proses *build* (seperti: menambahkan *package* Composer atau modul NPM).
- **`chore`**: Tugas teknis rutin yang tidak terkait langsung dengan kode yang dirilis (seperti: penyesuaian alat bantu pengembangan atau CI/CD).

### Contoh Penggunaan yang Benar:

**Penambahan Fitur Baru:**
```text
feat(auth): menambahkan fitur pendaftaran akun pengguna

- Membuat form registrasi di halaman depan
- Mengimplementasikan validasi input sisi server
- Menyimpan password dengan enkripsi bcrypt
```

**Perbaikan Bug:**
```text
fix(ui): memperbaiki tata letak tombol submit pada tampilan ponsel
```

**Refactor (Penataan Ulang Kode):**
```text
refactor(dashboard): mengekstrak kartu statistik ke dalam Blade Component tersendiri
```