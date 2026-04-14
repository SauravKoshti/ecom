# 🛒 Ecom — Laravel Admin Panel

A modern e-commerce **admin panel** built with **Laravel 12**, featuring a fully custom UI inspired by Material UI and AdminLTE — but completely hand-crafted with Bootstrap 5 and Inter font.

---

## ✨ Features

- 📦 **Product Management** — CRUD with SKU, EAN, product number, compare price, stock, variants (Shopware-style parent/child)
- 🗂️ **Category Management** — Nested categories (parent/child), image upload, status toggle
- 🏷️ **Brand Management** — Logo upload, slug auto-generation, active/inactive
- 🎛️ **Property Management** — Dynamic options (Color with hex picker, Select, Text types)
- 🖼️ **Product Media** — Cover image + media gallery structure
- 📊 **Dashboard** — Stats cards, recent products, top brands
- 🎨 **Custom Design** — Unique sidebar, topbar, cards, badges, forms — no template used
- 📄 **Bootstrap 5 Pagination** — Styled to match the design system
- 🌱 **Database Seeder** — 50 products, 15 brands, 25 categories, 5 properties with real options

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| PHP | 8.2+ |
| Database | MySQL (XAMPP port 3307) |
| Frontend | Bootstrap 5.3, Bootstrap Icons, Inter font |
| ORM | Eloquent |
| Auth | Laravel built-in (session) |
| Storage | Laravel public disk |
| Dev Tools | Tinker, Faker, Laravel Pint |

---

## ⚙️ Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/SauravKoshti/ecom.git
cd ecom
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env` database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306        # use 3307 for XAMPP default
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create database

Open **phpMyAdmin** or run:

```bash
mysql -u root -e "CREATE DATABASE ecom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 6. Run migrations & seed dummy data

```bash
php artisan migrate --seed
```

This seeds:
- `1` admin user → `admin@example.com` / `password`
- `15` brands
- `25` categories (10 parent + 15 child)
- `5` properties with `25` options (Color, Size, Material, Weight, Style)
- `50` products with pivot data

### 7. Storage symlink

```bash
php artisan storage:link
```

### 8. Start the server

```bash
php artisan serve
```

Visit → **http://localhost:8000/admin**

---

## 🔄 Re-seed (wipe & fresh data)

```bash
php artisan migrate:fresh --seed
```

---

## 📁 Project Structure

```
ecom/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php     # Stats & recent data
│   │   │       ├── ProductController.php        # Product CRUD + pivot sync
│   │   │       ├── CategoryController.php       # Category CRUD + image upload
│   │   │       ├── BrandController.php          # Brand CRUD + logo upload
│   │   │       └── PropertyController.php       # Property + dynamic options CRUD
│   │   │
│   │   └── Requests/
│   │       └── Admin/
│   │           ├── StoreProductRequest.php
│   │           ├── UpdateProductRequest.php
│   │           ├── StoreCategoryRequest.php
│   │           ├── UpdateCategoryRequest.php
│   │           ├── StoreBrandRequest.php
│   │           ├── UpdateBrandRequest.php
│   │           ├── StorePropertyRequest.php
│   │           └── UpdatePropertyRequest.php
│   │
│   └── Models/
│       ├── Product.php          # parent_id, variants, media, propertyOptions, categories
│       ├── Category.php         # parent/children self-referential, products pivot
│       ├── Brand.php            # products hasMany
│       ├── Property.php         # options hasMany
│       ├── PropertyOption.php   # property belongsTo, products pivot
│       ├── ProductMedia.php     # product belongsTo, is_cover, position
│       └── User.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table
│   │   ├── create_categories_table          # parent_id self-ref
│   │   ├── create_brands_table
│   │   ├── create_properties_table          # type: select|color|text
│   │   ├── create_property_options_table    # color_hex
│   │   ├── create_products_table            # parent_id, sku, ean, product_number
│   │   ├── create_product_category_table    # pivot
│   │   ├── create_product_variants_table    # parent_id + product_variant_options pivot
│   │   └── create_product_media_table       # position, is_cover
│   │
│   ├── factories/
│   │   ├── ProductFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── BrandFactory.php
│   │   ├── PropertyFactory.php
│   │   └── PropertyOptionFactory.php
│   │
│   └── seeders/
│       └── DatabaseSeeder.php   # 50 products, 15 brands, 25 categories, 5 properties
│
├── resources/
│   └── views/
│       └── admin/
│           ├── layouts/
│           │   └── app.blade.php            # Sidebar + Topbar + custom CSS design system
│           │
│           ├── dashboard.blade.php          # Stats, recent products, top brands
│           │
│           ├── products/
│           │   ├── index.blade.php          # Table with image, stock badge, variants count
│           │   ├── create.blade.php         # POST form wrapper
│           │   ├── edit.blade.php           # PUT form wrapper
│           │   └── _form.blade.php          # 2-col layout: info+pricing | status+brand+categories
│           │
│           ├── categories/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── _form.blade.php
│           │
│           ├── brands/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── _form.blade.php
│           │
│           └── properties/
│               ├── index.blade.php
│               ├── create.blade.php
│               ├── edit.blade.php
│               ├── _form.blade.php          # Dynamic option rows table
│               └── _form_scripts.blade.php  # JS: add/remove rows, color toggle, re-index
│
└── routes/
    └── web.php                  # Admin prefix group with dashboard + 4 resources
```

---

## 🗄️ Database Schema Summary

```
users
categories          (id, name, slug, description, image, parent_id, status)
brands              (id, name, slug, logo, active)
properties          (id, name, type)
property_options    (id, property_id, value, color_hex)
products            (id, parent_id, name, slug, description, price, compare_price,
                     stock, sku, product_number, ean, image, brand_id, active)
product_category    (product_id, category_id)                    ← pivot
product_property_option (product_id, property_option_id)         ← pivot
product_variant_options (product_id, property_option_id)         ← variant pivot
product_media       (id, product_id, path, position, is_cover)
```

### Key Relationships

| Model | Relationships |
|---|---|
| `Product` | `belongsTo` Brand, `belongsToMany` Category, `belongsToMany` PropertyOption, `hasMany` variants (self), `hasMany` ProductMedia |
| `Category` | `belongsTo` parent (self), `hasMany` children (self), `belongsToMany` Product |
| `Brand` | `hasMany` Product |
| `Property` | `hasMany` PropertyOption |
| `PropertyOption` | `belongsTo` Property, `belongsToMany` Product |

---

## 🌐 Admin Routes

| Method | URI | Name | Action |
|---|---|---|---|
| GET | `/admin` | `admin.dashboard` | Dashboard |
| GET | `/admin/products` | `admin.products.index` | List products |
| GET | `/admin/products/create` | `admin.products.create` | Create form |
| POST | `/admin/products` | `admin.products.store` | Store product |
| GET | `/admin/products/{id}/edit` | `admin.products.edit` | Edit form |
| PUT | `/admin/products/{id}` | `admin.products.update` | Update product |
| DELETE | `/admin/products/{id}` | `admin.products.destroy` | Delete product |
| — | — | — | *(same pattern for categories, brands, properties)* |

---

## 🎨 Design System

The UI is fully custom — no AdminLTE, no Volt, no pre-built template.

| Element | Style |
|---|---|
| Font | Inter (Google Fonts) |
| Primary | Indigo `#6366f1` with gradient |
| Sidebar | Deep navy `#0f172a` with radial glow |
| Cards | White, `14px` radius, subtle shadow |
| Badges | Soft pill — green/red/amber on light backgrounds |
| Buttons | Gradient primary with lift hover, ghost secondary/danger |
| Forms | `1.5px` border, indigo focus ring |
| Tables | Uppercase `10.5px` headers, hover rows |
| Pagination | Bootstrap 5 styled with indigo active state |

---

## 👤 Default Login

> ⚠️ No authentication guard is applied yet — admin routes are open. Add `auth` middleware when deploying.

| Field | Value |
|---|---|
| Email | `admin@example.com` |
| Password | `password` |

---

## 📌 Inspired By

- [Shopware](https://github.com/shopware/shopware) — product/variant/property database structure
- Material UI — card elevation and color system
- AdminLTE — sidebar layout concept

---

## 📄 License

MIT
