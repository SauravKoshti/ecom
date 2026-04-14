# E-commerce API Documentation

This document provides detailed information about the API endpoints for the Laravel e-commerce application.

## Base URL
```
http://localhost:8000/api/
```

## Authentication
Currently, no authentication is required for the public API endpoints. For admin operations, authentication may be added in the future.

## Response Format
All API responses follow a consistent JSON structure:
```json
{
  "success": true|false,
  "message": "Description of the response",
  "data": { ... } | [ ... ],
  "meta": { ... } // For paginated responses
}
```

## Pagination
Paginated endpoints return additional metadata:
```json
{
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50
  }
}
```

### Pagination Parameters
- `per_page`: Number of items per page (default: 10)
- `page`: Page number (default: 1)

## Products API

### Get All Products
Retrieve a list of products with optional filtering, sorting, and pagination.

**Endpoint:** `GET /products`

**Query Parameters:**
- `per_page` (int): Items per page (default: 10)
- `page` (int): Page number (default: 1)
- `category_id` (int): Filter by category ID
- `brand_id` (int): Filter by brand ID
- `search` (string): Search in product name or description
- `sort` (string): Sort options:
  - `price_asc`: Price ascending
  - `price_desc`: Price descending
  - `name_asc`: Name ascending
  - `name_desc`: Name descending
  - `created_at_desc`: Newest first (default)

**Example Request:**
```
GET /api/products?per_page=5&category_id=1&sort=price_asc&search=laptop
```

**Response:**
```json
{
  "success": true,
  "message": "Products fetched successfully",
  "data": [
    {
      "id": 1,
      "name": "Laptop Pro",
      "slug": "laptop-pro",
      "description": "High-performance laptop",
      "price": 999.99,
      "compare_price": 1199.99,
      "stock": 50,
      "sku": "LP001",
      "active": true,
      "categories": [...],
      "brand": {...},
      "media": [...],
      "cover": {...}
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 5,
    "total": 15
  }
}
```

### Get Single Product
Retrieve detailed information about a specific product.

**Endpoint:** `GET /products/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Product fetched successfully",
  "data": {
    "id": 1,
    "name": "Laptop Pro",
    "slug": "laptop-pro",
    "description": "High-performance laptop",
    "price": 999.99,
    "compare_price": 1199.99,
    "stock": 50,
    "sku": "LP001",
    "active": true,
    "categories": [...],
    "brand": {...},
    "media": [...],
    "cover": {...},
    "property_options": [...]
  }
}
```

### Get Related Products
Retrieve products related to a specific product (same categories).

**Endpoint:** `GET /products/{id}/related`

**Response:**
```json
{
  "success": true,
  "message": "Related products fetched successfully",
  "data": [
    {
      "id": 2,
      "name": "Gaming Laptop",
      "slug": "gaming-laptop",
      "price": 1299.99,
      "categories": [...],
      "brand": {...},
      "cover": {...}
    }
  ]
}
```

## Categories API

### Get All Categories
Retrieve a list of top-level categories with pagination.

**Endpoint:** `GET /categories`

**Query Parameters:**
- `per_page` (int): Items per page (default: 10)
- `page` (int): Page number (default: 1)

**Response:**
```json
{
  "success": true,
  "message": "Categories fetched successfully",
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "slug": "electronics",
      "description": "Electronic devices and accessories",
      "image": "categories/electronics.jpg",
      "image_url": "http://localhost:8000/storage/categories/electronics.jpg",
      "status": "active",
      "children": [...]
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 2,
    "per_page": 10,
    "total": 15
  }
}
```

### Get Single Category
Retrieve detailed information about a specific category.

**Endpoint:** `GET /categories/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Category fetched successfully",
  "data": {
    "id": 1,
    "name": "Electronics",
    "slug": "electronics",
    "description": "Electronic devices and accessories",
    "image": "categories/electronics.jpg",
    "image_url": "http://localhost:8000/storage/categories/electronics.jpg",
    "status": "active",
    "children": [...]
  }
}
```

### Get Products in Category
Retrieve products belonging to a specific category with pagination.

**Endpoint:** `GET /categories/{id}/products`

**Query Parameters:**
- `per_page` (int): Items per page (default: 10)
- `page` (int): Page number (default: 1)

**Response:**
```json
{
  "success": true,
  "message": "Products for category fetched successfully",
  "data": [
    {
      "id": 1,
      "name": "Laptop Pro",
      "price": 999.99,
      "brand": {...},
      "media": [...],
      "cover": {...}
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 10,
    "total": 25
  }
}
```

## Error Responses
All endpoints may return error responses in the following format:

**404 Not Found:**
```json
{
  "success": false,
  "message": "Resource not found"
}
```

**500 Internal Server Error:**
```json
{
  "success": false,
  "message": "Internal server error"
}
```

## Running the API
1. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

2. The API will be available at `http://localhost:8000/api/`

3. Use tools like Postman, curl, or any HTTP client to test the endpoints.

**Example curl command:**
```bash
curl -X GET "http://localhost:8000/api/products?per_page=5&sort=price_asc"
```

## Notes
- Image URLs are generated using Laravel's Storage facade and require the storage link to be set up (`php artisan storage:link`).
- All prices are in the default currency (assumed USD).
- Product variants and complex property options are supported but may require additional endpoints for full management.