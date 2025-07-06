<h1 align="center">
 Norship
</h1>

<p align="center">
 Norship adalah platform e-commerce multi-vendor terpadu yang menghubungkan para penjual dengan pembeli di era digital. Kami menyediakan infrastruktur yang andal dan skalabel agar para merchant dapat memulai dan menumbuhkan bisnis online mereka, sambil memberikan konsumen pengalaman belanja yang lancar, aman, dan dengan pilihan produk terlengkap.
</p>

<p align="center">
    <a href="#">
      <img src="https://img.shields.io/badge/status-prototipe-yellow" alt="Status Proyek">
    </a>
    <a href="#">
      <img src="https://img.shields.io/badge/license-MIT-blue" alt="Lisensi">
    </a>
</p>

---

## ✨ Tampilan Web

<p align="center">
  Belum diimplementasikan
</p>

---

## 📝 Status Prototipe

Repositori ini berisi prototipe untuk proyek final. Belum semua fitur telah diimplementasikan sepenuhnya. Fokus kami untuk fase ini adalah menghadirkan fungsionalitas inti yang solid.

**Fitur yang Sudah Diimplementasikan:**

Backend side (API):
- [x] Authentication (Login & Register)
- [x] Cart
- [x] User Profile
- [x] Store
- [x] Product Management
- [x] Product in categories
- [ ] Payment Gateway
- [ ] Order

Database Schema details: https://dbdiagram.io/d/norship_multi_store-68628055f413ba3508870c3e

---

## 🌟 Fitur Aplikasi

Fitur yang kami rencanakan untuk Norship:

### Fokus Fitur: Membangun Ekosistem Marketplace Multi-Toko
Platform kami adalah sebuah marketplace terpadu yang memberdayakan ribuan penjual untuk mengelola toko mereka secara mandiri, sambil memberikan pembeli pengalaman berbelanja yang mulus dari berbagai toko melalui fitur pencarian terpusat, keranjang belanja universal, dan satu kali checkout yang aman.

---

## 🛠️ Tech Stack
- **Frontend**: `[React, Next.js, TypeScript]`
- **Backend**: `[Laravel]`
- **Database**: `[MySql]`
- **Lainnya**: `[TailwindCSS]`

---

## 🚀 Cara Menjalankan Proyek Secara Lokal

### Pre-requisite
- Node.js (v18++)
- npm
- php
- composer
- Git

### Backend (PHP Laravel)

1.  **Clone repositori ini:**
    ```bash
    git clone https://github.com/GerinNugroho/Norship.git
    cd Norship 
    ```

2.  **Install dependency via Composer:**
    ```bash
    composer install
    ```

3.  **Salin file environment:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi database di file `.env` kamu.**

6.  **Jalankan migrasi database:**
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan server lokal:**
    ```bash
    php artisan serve
    ```
    Backend akan berjalan di `http://localhost:8000`.


Postman collection untuk testing API:
https://drive.google.com/drive/folders/16fRpoak-5YlfbqymIm2lKmGtuX_V3k2O?usp=drive_link

---

### Frontend (Next.js)
 Belum diimplementasikan
 
 Preview: https://github.com/jpangestu/norship-fe

---

## 👨‍💻 Tim Kami
- Gerin Nugroho
- Tandang Pangestu
---