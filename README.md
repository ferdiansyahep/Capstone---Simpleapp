# SISTEM UJIAN APPS

## Deskripsi
Tujuan dari proyek ini adalah untuk mengembangkan sebuah sistem manajemen ujian berbasis web yang memudahkan proses administrasi dan pelaksanaan ujian di lingkungan sekolah. Sistem ini dirancang untuk membantu siswa, guru, dan admin dalam mengelola berbagai aspek terkait ujian dengan lebih efisien dan terorganisir.

## Menjalankan Secara Lokal

1. Buka direktori proyek

    ```bash
    cd project-name
    ```

2. Salin file `.env.example` ke `.env` dan edit kredensial database di sana

    ```bash
    cp .env.example .env
    ```

3. Instal dependensi menggunakan Composer

    ```bash
    composer install
    ```

4. Generate kunci aplikasi

    ```bash
    php artisan key:generate
    ```

5. Jalankan migrasi database dan seed data awal

    ```bash
    php artisan migrate:fresh --seed
    ```

#### Login

##### Admin

-   email: admin@example.com
-   password: 123

##### Admin Ujian

- email: ujian@gmail.com
- password: 123
