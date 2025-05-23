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



![Screenshot_1](https://github.com/user-attachments/assets/077ff9e8-f181-4627-9783-f6bea6c5313b)
![Screenshot_2](https://github.com/user-attachments/assets/4d370f82-acb8-4698-b642-c3a971ff2508)
![Screenshot_4](https://github.com/user-attachments/assets/06855f12-7028-4949-97d8-4828fde663be)
![Screenshot_3](https://github.com/user-attachments/assets/ff4a20b4-af7e-4a89-8e39-1335d9f3fa3d)
![Screenshot_5](https://github.com/user-attachments/assets/c2374b1f-0785-4aaa-8447-685def09b8de)
![Screenshot_6](https://github.com/user-attachments/assets/f0ebc62c-9f42-4d58-9083-bf3c1e39ae56)
![Screenshot_7](https://github.com/user-attachments/assets/66555ef1-bf99-4e58-b13b-6b02c4222024)
![Screenshot_8](https://github.com/user-attachments/assets/b5cf2c05-9771-4740-9a70-3761a8d19050)
![Screenshot_9](https://github.com/user-attachments/assets/118b4aee-97a4-4371-85ef-912450146bbd)
![Screenshot_10](https://github.com/user-attachments/assets/6df800ae-533e-4c05-a67a-1e8d75ac533f)
![Screenshot_11](https://github.com/user-attachments/assets/b550ef55-a0b1-494c-87c9-55c4e613deff)
![Screenshot_12](https://github.com/user-attachments/assets/07b299ce-d3ff-4b55-9361-65d7d86c30ea)
![Screenshot_13](https://github.com/user-attachments/assets/9a91c971-29fc-4a6d-a5ed-0ede83bfa088)
![Screenshot_14](https://github.com/user-attachments/assets/e703796e-7734-4775-8158-41b8b253c4fd)
![Screenshot_15](https://github.com/user-attachments/assets/7aa59783-c02e-40a1-9a2a-273ff55d01b8)
![Screenshot_16](https://github.com/user-attachments/assets/ff6bf044-d8e7-4bc8-8a50-dee7bc52f65e)
![Screenshot_17](https://github.com/user-attachments/assets/e5f81e7f-9f0f-4389-a69a-238234ae8749)
![Screenshot_18](https://github.com/user-attachments/assets/9cad97b4-1004-4d67-98c1-5f3774493536)
![Screenshot_19](https://github.com/user-attachments/assets/2ca79513-0e17-433d-bd4e-d7a0ae9dadab)
