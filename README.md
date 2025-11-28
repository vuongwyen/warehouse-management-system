# WMS | Enterprise Resource Planning

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-v3-F28D1A?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)
![Build](https://img.shields.io/badge/Build-Passing-green?style=for-the-badge)

![WMS Dashboard](docs/images/dashboard-main.png)

> **"An industrial-grade inventory management solution designed for precision, speed, and scalability. Built with the TALL stack."**

---

## 💡 Why WMS?

Managing inventory with spreadsheets or legacy software leads to errors, waste, and lost revenue. **WMS** transforms your supply chain operations by providing a single source of truth. It replaces guesswork with real-time tracking, minimizes waste through intelligent **FEFO (First Expired, First Out)** strategies, and scales effortlessly from a single warehouse to a multi-facility enterprise.

---

## ✨ Key Features

### 📦 Precision Inventory
*   **Granular Location Management:** Move beyond simple stock counts. Track items down to the specific **Zone, Rack, and Bin**.
*   **Batch & Lot Tracking:** Complete traceability for every item, including production batches and expiry dates.
*   **Smart Strategies:** Automated **FEFO** picking logic ensures the oldest stock is used first, significantly reducing spoilage and waste.

### 🚀 Operations & Automation
*   **Barcode Integration:** Built-in tools to generate, print, and scan barcodes for products and locations, streamlining workflows.
*   **Streamlined Flows:**
    *   **Inbound:** Efficient Purchase Order management with direct Putaway to bins.
    *   **Outbound:** Automated Pick List generation for Sales Orders.
*   **Stock Control:** Comprehensive tools for Stock Adjustments, Transfers, and Audits.

### 📊 Intelligence & Reporting
*   **Real-time Analytics:** Live dashboards featuring Inventory Turnover, Stock Valuation, and Low Stock Alerts.
*   **Immutable Audit Trail:** Every movement is recorded in the `inventory_transactions` ledger, ensuring complete accountability.

---

## 🛠 Technology Stack

WMS is built on a modern, robust architecture designed for performance and maintainability:

*   **Backend:** [Laravel 11](https://laravel.com) - The PHP framework for web artisans.
*   **Admin Panel:** [FilamentPHP v3](https://filamentphp.com) - A collection of beautiful, full-stack components.
*   **Frontend:** [Livewire 3](https://livewire.laravel.com) + [Alpine.js](https://alpinejs.dev) - Dynamic interfaces without the complexity of an SPA.
*   **Database:** MySQL 8.0 - Optimized schema for high-volume transactions.
*   **Styling:** [TailwindCSS](https://tailwindcss.com) - Utility-first CSS framework.

---

## 💻 Getting Started

Follow these steps to deploy WMS locally for development or testing.

### Prerequisites
*   PHP 8.2+
*   Composer
*   Node.js & NPM
*   MySQL 8.0+

### Installation

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/your-org/wms.git
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
    *Edit `.env` and configure your database connection details.*

4.  **Database Setup**
    Run the migrations and seed the database with enterprise sample data (Warehouses, Locations, Products, Users):
    ```bash
    php artisan migrate --seed
    ```

5.  **Access the System**
    Start the local development server:
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000/admin` and log in:
    *   **Email:** `admin@wms.com`
    *   **Password:** `password`

---

## 🏗 Database Architecture

WMS uses a relational model optimized for data integrity:

> **Products** are the core entity, linked to specific **Batches** (for expiry/lot tracking).
> **Warehouses** contain a hierarchy of **Locations** (Zones -> Racks -> Bins).
> **Inventory Transactions** act as the central ledger, linking Products, Batches, and Locations to record every single stock movement (In/Out).

---

## 🤝 Contributing

We welcome contributions! Please see our [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to submit pull requests, report issues, and suggest improvements.

## 📄 License

WMS is open-sourced software licensed under the [MIT license](LICENSE).
