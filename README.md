# 📦 Laravel Inventory Management System

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/9afbd902-a23d-4f7f-a8ec-17848be38812" />

A complete inventory management system built with Laravel 11, Tailwind CSS, and MySQL.


Dashboard
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/97ee0a24-bafa-4e8e-bd90-b7f9add279a3" />

Products Page
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/05cdd8da-5922-432f-ae09-4c40f9453fe1" />

Stock In Page
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/ff0013eb-0c56-4cb9-9d84-6d4a0d91cd39" />

Stock Out Page
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1467fc4f-ad80-4bb3-bcff-8f01ef61f2b0" />

Stock History
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/82c0a9c2-0109-498e-afad-934e86a4fe5c" />

Login Page
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/8aa4219c-9d95-4012-b7b3-9e1688efdf93" />

Profile Page
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/88521fb9-ff95-41e1-a9b7-3db8ae567ab0" />


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
