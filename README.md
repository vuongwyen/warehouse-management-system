<div align="center">

# Nexus WMS | Enterprise Resource Planning

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3-F28D1A?style=for-the-badge&logo=laravel&logoColor=white)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)
[![Build Status](https://img.shields.io/badge/Build-Passing-green?style=for-the-badge)]()

<img width="100%" alt="WMS Dashboard Main" src="https://github.com/user-attachments/assets/02f2b566-ca06-4523-b290-a628d93cd1b6" />

<br>

> **"An industrial-grade inventory management solution designed for precision, speed, and scalability. Built with the modern TALL Stack."**

</div>

---

## 💡 Why Choose Nexus WMS?

Managing inventory with spreadsheets or legacy software often leads to errors, waste, and lost revenue. **Nexus WMS** transforms your supply chain operations by providing a **Single Source of Truth**.

The system replaces guesswork with **real-time tracking**, minimizes waste through intelligent **FEFO (First Expired, First Out)** strategies, and scales effortlessly from a single warehouse to a multi-facility enterprise network.

---

## 📸 System Screenshots

| **Dashboard Overview** | **Low Stock Alert** |
|:------------------:|:----------------:|
| <img width="1900" height="1079" alt="image" src="https://github.com/user-attachments/assets/7f904e6a-813f-4b05-8436-f76b311b9a34" /> | <img width="1900" height="1079" alt="image" src="https://github.com/user-attachments/assets/aceaddf1-d84b-4021-97b7-d3d97305e6b0" />|

| **Product Management** | **Order Management** |
|:--------------:|:---------------:|
| <img src="https://github.com/user-attachments/assets/b1446863-8424-4fec-9c71-4c069d588bee" width="100%" /> | <img src="https://github.com/user-attachments/assets/811df683-0306-463f-9d81-66f5ba097f13" width="100%" /> |

<details>
<summary>👀 <b>View More Screenshots</b></summary>

| **Customer Management** | **Supplier Management** |
|:----------------:|:--------------:|
| <img src="https://github.com/user-attachments/assets/666faf71-f8b9-4b32-8089-255ba58513b6" width="100%" /> | <img src="https://github.com/user-attachments/assets/9d7e3939-f5f7-4bf6-bccc-e07e5464167a" width="100%" /> |

| **Warehouse Management** |
|:---------------:|
| <img src="https://github.com/user-attachments/assets/652267d2-b5af-4bc9-9709-5479604a303d" width="100%" /> |

</details>

---

## ✨ Key Features

### 📦 1. Precision Inventory
- **Granular Location Management:** Track items down to the specific physical layer: **Warehouse -> Zone -> Rack -> Bin**.
- **Batch & Lot Tracking:** Complete traceability for every item, including production batches and expiry dates.
- **Smart Strategies:** Automated **FEFO** (First Expired, First Out) logic suggests the optimal batches for picking to minimize spoilage.

### 🚀 2. Operations & Automation
- **Barcode Integration:** Built-in tools to generate, print, and scan barcodes for Products and Locations.
- **Streamlined Workflows:**
    - **Inbound:** Efficient Purchase Order management with direct Putaway to Bins.
    - **Outbound:** Automated Pick List generation for Sales Orders.
- **Stock Control:** Comprehensive tools for Stock Adjustments, Transfers, and Audits.

### 📊 3. Intelligence & Reporting
- **Real-time Analytics:** Live dashboards featuring Inventory Turnover Ratio, Stock Valuation, and Replenishment Alerts.
- **Immutable Audit Trail:** Every single movement is recorded in the `inventory_transactions` ledger, ensuring absolute accountability.

---

## 🛠 Tech Stack

Built on a modern, robust architecture designed for high performance:

- **Backend:** [Laravel 11](https://laravel.com) - The PHP framework for web artisans.
- **Admin Panel:** [FilamentPHP v3](https://filamentphp.com) - Beautiful, full-stack admin components.
- **Frontend:** [Livewire 3](https://livewire.laravel.com) + [Alpine.js](https://alpinejs.dev) - Dynamic interfaces without SPA complexity.
- **Database:** MySQL 8.0 - Optimized schema for high-volume transactions.
- **Styling:** [TailwindCSS](https://tailwindcss.com) - Utility-first CSS framework.

---

## 💻 Getting Started

Follow these steps to deploy the project locally:

### Prerequisites
* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL 8.0+

### Installation Steps

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/vuongwyen/wms.git](https://github.com/vuongwyen/wms.git)
    cd wms
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Open `.env` and configure your database connection details.*

4.  **Database Setup**
    Run the following command to migrate and seed the database with enterprise sample data (Warehouses, Locations, Products, Users):
    ```bash
    php artisan migrate --seed
    ```

5.  **Access the System**
    Start the local development server:
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000/admin` and log in:
    * **Email:** `admin@gmail.com`
    * **Password:** `123456789`

---

## 🗺️ Roadmap

- [x] **v2.0: Enterprise Core** (Location Hierarchy, Barcode, FEFO)
- [ ] **API Integration:** REST API for external systems (ERP/eCommerce).
- [ ] **Mobile App:** Companion app for scanning operations.
- [ ] **Advanced Reporting:** Exportable PDF/Excel reports for monthly audits.
- [ ] **Supplier Portal:** Allow suppliers to view and update order statuses.

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to submit pull requests and report issues.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
