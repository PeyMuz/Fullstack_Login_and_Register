# Fullstack Login and Register

A simple full-stack authentication system built with **PHP**, **MySQL**, and **vanilla JavaScript**. It features an animated login/register modal, session-based alerts, and a responsive glassmorphism UI.

> Built as a learning project for full-stack web development.

---

## Features

- **User registration** with validation (empty fields, valid email, minimum 8-character password, password confirmation)
- **User login** with secure password verification
- **Password hashing** using `password_hash()` and `password_verify()`
- **SQL injection protection** through prepared statements (`mysqli`)
- **Duplicate email detection**, backed by a `UNIQUE` constraint in the database
- **Session fixation protection** using `session_regenerate_id(true)` on login
- **Flash alerts** (success and error) that slide in and auto-dismiss with a progress bar
- **Form value retention**: name and email are kept after an error (passwords are never stored)
- **Animated modal** that slides between the Login and Register forms
- **Profile avatar and dropdown** showing the first letter of the logged-in user's name
- **Responsive design** for desktop, laptop, tablet, and phone
- **UTF-8 support** (`utf8mb4`) for names with special characters such as `ñ`

---

## Tech Stack

| Layer     | Technology                                  |
|-----------|---------------------------------------------|
| Frontend  | HTML5, CSS3, Vanilla JavaScript             |
| Backend   | PHP (procedural, `mysqli`)                  |
| Database  | MySQL / MariaDB                             |
| Icons     | [Boxicons](https://boxicons.com/)           |
| Font      | [Poppins](https://fonts.google.com/specimen/Poppins) |
| Local env | XAMPP                                       |

---

## Project Structure

```
Fullstack_Login_and_Register/
├── index.php          # Main page (navbar, hero, alerts, login/register modal)
├── auth_process.php   # Handles registration and login logic
├── config.php         # Database connection
├── index.js           # Modal toggling, dropdown, alert animation
├── style.css          # All styling, including responsive rules
└── vi.jpg             # Background image
```

---

## Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or any PHP + MySQL stack)
- A web browser

### Installation

1. **Clone the repository** into your XAMPP `htdocs` folder:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/PeyMuz/Fullstack_Login_and_Register.git
   ```

2. **Start Apache and MySQL** from the XAMPP Control Panel.

3. **Create the database and table.** Open `http://localhost/phpmyadmin`, go to the **SQL** tab, and run:

   ```sql
   CREATE DATABASE IF NOT EXISTS users_db
     CHARACTER SET utf8mb4
     COLLATE utf8mb4_unicode_ci;

   USE users_db;

   CREATE TABLE IF NOT EXISTS users (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     email VARCHAR(255) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

4. **Check the database settings** in `config.php`. The defaults match a fresh XAMPP install:

   ```php
   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'users_db';
   ```

5. **Open the app** in your browser:

   ```
   http://localhost/Fullstack_Login_and_Register/
   ```

---

## How It Works

1. The user clicks **Login** in the navbar, and the modal pops up. The **Register** link slides the form to the registration view.
2. Forms submit via `POST` to `auth_process.php`, which validates the input and talks to the database.
3. The result (success or error) is stored in the session as a flash alert, then the user is redirected back to `index.php`.
4. `index.php` reads the session data once, displays the alert, restores any form values, and clears the session flash data.
5. After a successful login, the navbar shows an avatar with the first letter of the user's name, and the hero text greets them.

---

## Troubleshooting

| Problem | Fix |
|---|---|
| `Unknown database 'users_db'` | Run the SQL script above in phpMyAdmin. |
| `Access denied for user 'root'` | Update `$password` in `config.php` to match your MySQL root password. |
| Can't connect to the database | Make sure MySQL is running in the XAMPP Control Panel. |
| Old styles still showing | Hard refresh with `Ctrl + Shift + R`. |

---

## Roadmap

- [ ] Logout functionality (`logout.php`)
- [ ] "My Account" page
- [ ] Hamburger menu for the navbar on phones
- [ ] Password reset via email
- [ ] CSRF token protection on forms
- [ ] Move database credentials to an environment file

---

## Author

**Kylle**
GitHub: [@PeyMuz](https://github.com/PeyMuz)

---

## License

This project is for learning purposes. Feel free to use and modify it.
