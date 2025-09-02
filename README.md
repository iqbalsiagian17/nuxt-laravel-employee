# Employee Management System

Repo ini berisi dua bagian utama:

- **Backend:** Laravel 10 (folder `backend`)  
- **Frontend:** Nuxt 3 (folder `frontend`)  

Aplikasi ini digunakan untuk mengelola data pegawai, master data (agama, jabatan, unit kerja), serta dashboard admin.

---




## Installation Backend

1. Clone the Repository

```bash
git clone https://github.com/iqbalsiagian17/nuxt-laravel-employee.git
cd backend
```


2. Install Dependencies

```bash
composer install
```


3. Copy the .env File Copy the example environment file to create your .env file:

```bash
cp .env.example .env
```


4. Configure Environment Variables Update the following database settings in the .env file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=root
DB_USERNAME=
DB_PASSWORD=db_test_teknis
```


6. Run Migrations and Seeders Migrate the database and seed it with initial data:

```bash
php artisan migrate --seed
```

7. Start the Development Server Launch the Laravel development server:

```bash
php artisan serve
```





## Installation Frontend

1. Clone the Repository

```bash
git clone https://github.com/iqbalsiagian17/nuxt-laravel-employee.git
cd frontend
```


2. Install Dependencies

```bash
npm install
```

3. Start the Development

```bash
npm run dev
```

4. Default Login after seeder

```bash
Email: admin@gmail.com
Password: password
```
Make sure the backend is running and the database has been migrated & seeded so that the admin account is available.







