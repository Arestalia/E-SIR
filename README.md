# 📘 E-SIR

**E-SIR** adalah proyek website untuk memenuhi tugas akhir. Proyek ini dibangun menggunakan Laravel dan beberapa dependency lainnya.

---

## 🚀 Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lokal kamu:

### 1. Clone Repository

```bash
git clone https://github.com/Arestalia/E-SIR.git
cd E-SIR
```

### 2. Setup  Depedencies

Jalankan perintah

``` bash
composer install
```

atau jalankan perintah :

``` bash
composer update
```

install node packages
```bash
npm install
```

jalankan node packages
``` bash
npm run dev
```
### 3. Konfigurasi Environment

Copy file .env dari .env.example

``` bash
cp .env.example .env
```
konfigurasikan .env file 

``` bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example_app
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Key Generate
key generate 
``` bash
php artisan key:generate
```
### 5. Database Migrate
migrate database
``` bash
php artisan migrate
```
### 6. Seed Database

jalankan seeder
``` bash
php artisan db:seed
```
### 7. Jalankan Aplikasi

run aplikasi
``` bash
php artisan serve
```
