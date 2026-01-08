# DigitalMenu — Reggelberger Hof Deutschnofen

A bespoke, multilingual digital menu website built for the **Reggelberger Hof** hotel in Deutschnofen. The site is still in active use by the client to present their hotel menu in a clean, mobile-friendly format.

## ✨ Highlights
- **Guest-facing menu** with a focused, full-screen layout for tablets and phones.
- **Language switcher (DE/IT)** for German and Italian visitors.
- **Back-office area** to manage menu categories and items.
- **Simple, fast PHP setup** without heavy frameworks.

## 🧩 Tech Stack
- **PHP** for rendering and routing
- **HTML/CSS** for layout and styling
- **JavaScript** for light UI interactions (e.g., language switcher)
- **MySQL** for menu data storage

## 📁 Project Structure
```
.
├── backend/           # Admin area (menu management)
├── entities/          # Database models & configuration
├── frontend/          # Guest-facing menu UI
├── styles/            # Shared styling
├── images/            # Shared assets
├── database.sql       # Database schema & seed
└── index.php          # Public landing page
```

## 🚀 Getting Started (Local)
1. **Clone the repo** and move into the project folder.
2. **Create a MySQL database** and import `database.sql`.
3. **Update credentials** in `entities/variables.ini.php`.
4. **Run a local PHP server** from the repo root:
   ```bash
   php -S localhost:8000
   ```
5. Open **http://localhost:8000** in your browser.

## 🔐 Admin Area
The admin entry point is:
```
/backend/index.php
```
Log in with the credentials configured in `entities/variables.ini.php`.

## 📸 Screens & Assets
Branding and hotel-related imagery are stored under `images/` and `frontend/images/`.

---
Built with care for **Reggelberger Hof Deutschnofen**.
