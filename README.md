# MediTrack460

MediTrack460 is a Laravel 12-based Dispensary Management System designed to streamline the patient care process — from registration to doctor consultation, prescription generation, medicine distribution, and stock management. Built with simplicity, security, and usability in mind, MediTrack460 serves as a reliable solution for organizations like government institutions and clinics 😊.

> screenshots at the end of the README
---

## 🚀 Features

### 👩‍💼 Receptionist
- Register new patients.
- Assign tokens and select available doctors.
- Automatically forward patient data to the selected doctor.

### 🩺 Doctor
- View patient's previous medical history and test records.
- Prescribe medicines and tests from a predefined system list.
- Forward prescription data to the pharmacist panel.

### 💊 Pharmacist
- View current prescriptions assigned.
- Dispense medicines and automatically update pharmacy stock.
- Send stock requests to storekeeper based on demand.

### 📦 Storekeeper
- Input new stock as needed.
- Review and approve pharmacist stock requests.

### 📊 Admin Panel
- Manage users, roles, medicines, tests, reports, and analytics.
- Audit logs and prescription/test history.
- Dashboard overview of patient activity and stock levels.

---

## 🧰 Tech Stack

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Blade + Bootstrap 5
- Database: MySQL

---

## 🗂 Project Setup

```bash
git clone https://github.com/mabdusshakur/meditrack460.git
cd meditrack460

composer install
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed

# Serve the app
php artisan serve
````

Default credentials for testing:
- check the seeder files in `database/seeders` for default users