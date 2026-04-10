# 📦 Laravel Inventory Management System
<img width="1919" height="871" alt="image" src="https://github.com/user-attachments/assets/bfc5443d-b990-4201-a4c1-a2b41ab472d4" />


A complete inventory management system built with Laravel 11, Tailwind CSS, and MySQL.

Dashboard
<img width="1919" height="873" alt="image" src="https://github.com/user-attachments/assets/5af57124-12b7-4e34-91fa-469c1c078f90" />

Products Page
<img width="1919" height="873" alt="image" src="https://github.com/user-attachments/assets/20df7af2-3acc-4333-8d44-d28cfc8a0166" />

Stock In Page
<img width="1919" height="877" alt="image" src="https://github.com/user-attachments/assets/c7adbf38-8bf2-4957-a8e8-8717338fcc15" />

Stock Out Page
<img width="1919" height="880" alt="image" src="https://github.com/user-attachments/assets/5e8c916e-872e-4f8a-b19e-162e508a5f2f" />

Stock History
<img width="1919" height="877" alt="image" src="https://github.com/user-attachments/assets/559faed8-80bc-416b-a615-34965a74de6a" />

Login Page
<img width="1918" height="874" alt="image" src="https://github.com/user-attachments/assets/0f6a47f5-9cd7-4328-8b18-85adbde01d49" />

Profile Page
<img width="1916" height="868" alt="image" src="https://github.com/user-attachments/assets/aa1db645-429a-42d6-b0d9-437f7b59ac9b" />



Features
- 🔐 Authentication (Login/Register)
- 📊 Dashboard with Charts
- 📦 Product Management (CRUD)
- 📥 Stock In with History
- 📤 Stock Out with Validation
- 📜 Stock Movement History
- 👤 Profile Management
- 🔍 Search & Filter
- 📄 Pagination

Tech Stack
- Laravel
- Tailwind CSS
- MySQL
- Flowbite
- Chart.js
- Laravel Breeze

Installation

```bash
git clone https://github.com/username/laravel-inventory-management.git
cd laravel-inventory-management
composer install
cp .env.example .env
php artisan key:generate
# Configure database in .env
php artisan migrate --seed
npm install
npm run build
php artisan serve
