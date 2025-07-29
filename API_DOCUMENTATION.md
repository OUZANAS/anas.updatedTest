# Category API Documentation

This API provides read-only access to category data with filtering and search capabilities.

## Base URL
```
/api/categories
```

## Endpoints

### 1. Get All Categories (with filtering and pagination)
**GET** `/api/categories`

#### Query Parameters:
- `is_active` (boolean): Filter by active status (true/false)
- `parent_only` (boolean): Get only main categories (without parent)
- `parent_id` (integer): Get categories that belong to a specific parent
- `search` (string): Search in title, slug, and description
- `order_by` (string): Order by field (title, slug, order, created_at). Default: order
- `order_direction` (string): Order direction (asc/desc). Default: asc
- `per_page` (integer): Items per page (max 100). Default: 15
- `page` (integer): Page number

#### Example Requests:
```
GET /api/categories
GET /api/categories?is_active=true&parent_only=true
GET /api/categories?search=technology&per_page=20
GET /api/categories?parent_id=1&order_by=title&order_direction=desc
```

#### Response:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Technology",
      "slug": "technology",
      "description": "Tech related content",
      "is_active": true,
      "order": 1,
      "image": "http://yoursite.com/storage/categories/image.jpg",
      "parent_id": null,
      "parent": null,
      "children": [],
      "children_count": 3,
      "created_at": "2025-07-29 10:00:00",
      "updated_at": "2025-07-29 10:00:00"
    }
  ],
  "links": {
    "first": "http://yoursite.com/api/categories?page=1",
    "last": "http://yoursite.com/api/categories?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 15,
    "to": 1,
    "total": 1
  }
}
```

### 2. Get Single Category
**GET** `/api/categories/{id}`

#### Response:
```json
{
  "data": {
    "id": 1,
    "title": "Technology",
    "slug": "technology",
    "description": "Tech related content",
    "is_active": true,
    "order": 1,
    "image": "http://yoursite.com/storage/categories/image.jpg",
    "parent_id": null,
    "parent": null,
    "children": [
      {
        "id": 2,
        "title": "Web Development",
        "slug": "web-development",
        "description": "Web dev content",
        "is_active": true,
        "order": 1,
        "image": null,
        "parent_id": 1,
        "parent": {
          "id": 1,
          "title": "Technology",
          "slug": "technology"
        },
        "children": [],
        "children_count": 0,
        "created_at": "2025-07-29 10:00:00",
        "updated_at": "2025-07-29 10:00:00"
      }
    ],
    "children_count": 1,
    "created_at": "2025-07-29 10:00:00",
    "updated_at": "2025-07-29 10:00:00"
  }
}
```

### 3. Get Category Tree (Hierarchical Structure)
**GET** `/api/categories/tree`

#### Query Parameters:
- `is_active` (boolean): Filter by active status

#### Response:
Returns all parent categories with their children nested.

### 4. Get Category Children
**GET** `/api/categories/{id}/children`

#### Response:
Returns all active children of the specified category.

### 5. Search Categories
**GET** `/api/categories/search`

#### Query Parameters:
- `q` (string, required): Search term (minimum 2 characters)

#### Example:
```
GET /api/categories/search?q=tech
```

#### Response:
Returns up to 20 matching categories.

## Response Format

All responses use the CategoryResource format with the following fields:

- `id`: Category ID
- `title`: Category title (translatable)
- `slug`: URL-friendly slug
- `description`: Category description (translatable)
- `is_active`: Whether the category is active
- `order`: Sort order
- `image`: Full URL to category image (if exists)
- `parent_id`: ID of parent category (null for main categories)
- `parent`: Parent category object (when loaded)
- `children`: Array of child categories (when loaded)
- `children_count`: Number of child categories
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp

## Error Responses

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "q": ["The q field is required."]
  }
}
```

### Not Found (404)
```json
{
  "message": "No query results for model [App\\Models\\Category] 999"
}
```
