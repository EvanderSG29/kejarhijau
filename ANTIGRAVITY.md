# Antigravity (AI Assistant) Guide for KejarHijau

File ini merupakan panduan dan konteks khusus untuk saya (Antigravity) dalam membantu Anda mengembangkan proyek **KejarHijau**. File ini membantu saya mengingat preferensi pengembangan dan aturan yang spesifik pada proyek ini.

## Peran Saya
- Membantu Anda menulis kode, memperbaiki *bug*, dan merancang arsitektur aplikasi (Laravel + Tailwind CSS).
- Menjaga konsistensi gaya penulisan kode dan antarmuka pengguna (UI).
- Membantu mengeksekusi dan mengotomatisasi perintah melalui terminal dengan persetujuan Anda.

## Panduan Pengembangan KejarHijau

1. **Frontend (UI/UX) - Tailwind CSS**: 
   - Gunakan pendekatan *utility-first* dengan memperhatikan struktur yang bersih.
   - Apabila terdapat *class* yang terlalu panjang dan sering diulang (seperti tombol, form, kartu), sarankan untuk mengekstraknya menjadi **Laravel Blade Components**.
   - Utamakan desain *Mobile-First* (`sm:`, `md:`, `lg:` dsb) dan pastikan aplikasi responsif.
   
2. **Backend (Laravel)**:
   - Manfaatkan fitur bawaan Laravel semaksimal mungkin (Eloquent ORM, Form Requests, Policies/Gates untuk otorisasi).
   - Jaga keamanan aplikasi: lakukan sanitasi *input* (selalu gunakan parameterisasi di Eloquent/Query Builder) dan cegah potensi kerentanan seperti CSRF, XSS, dan SQL Injection.

3. **Database & Workflow**:
   - Selalu catat perubahan skema menggunakan **Migrations**.
   - Gunakan **Factories** dan **Seeders** untuk menyiapkan data awal (*default data*) atau data tes, sehingga tim pengembang lain dapat menjalankan alur kerja aplikasi dengan lancar sejak instalasi pertama.

4. **Aturan Git Commit**:
   - Selalu ikuti **Conventional Commits** (*feat*, *fix*, *chore*, dll) dengan deskripsi menggunakan Bahasa Indonesia yang formal dan jelas, sesuai dengan aturan di `README.md`.

*Catatan: Saya akan selalu merujuk pada `README.md` untuk mengetahui alur instalasi agar saya dapat mereplikasi dan memperbaiki lingkungan saat ini apabila dibutuhkan.*
