# API Documentation

This document provides comprehensive information about the available API endpoints for the content management system. All endpoints return JSON responses and support pagination where applicable.

## Base URL
```
http://your-domain.com/api
```

## Response Format
All API responses follow a consistent format:

### Standard Collection Response:
```json
{
  "data": [...],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 67
  }
}
```

### Standard Single Resource Response:
```json
{
  "data": {
    "id": 1,
    "title": "Example",
    ...
  }
}
```

## Common Parameters

### Pagination
- `per_page`: Number of items per page (max: 100, default: 15-20 depending on endpoint)
- `page`: Page number to retrieve

### Ordering
- `order_by`: Field to order by
- `order_direction`: `asc` or `desc`

### Search
- `search`: General search term
- `q`: Search query (for dedicated search endpoints)

---

## Categories API

### GET /api/categories
Retrieve all categories with optional filtering.

**Parameters:**
- `is_active`: Filter by active status (boolean)
- `parent_only`: Get only parent categories (boolean)
- `parent_id`: Get categories by specific parent ID
- `search`: Search in title, slug, or description
- `order_by`: `title`, `slug`, `order`, `created_at` (default: `order`)
- `order_direction`: `asc`, `desc` (default: `asc`)
- `per_page`: Items per page (default: 15)

**Example:**
```
GET /api/categories?parent_only=true&is_active=1
```

### GET /api/categories/{category}
Get a specific category by ID or slug.

**Response includes:**
- Category details
- Parent category (if applicable)
- Children categories
- Children count

### GET /api/categories/tree
Get hierarchical category structure.

**Parameters:**
- `is_active`: Filter by active status

### GET /api/categories/{category}/children
Get all children categories for a specific parent.

### GET /api/categories/search
Search categories.

**Parameters:**
- `q`: Search query (required, min: 2, max: 255)

---

## Cities API

### GET /api/cities
Retrieve all cities with optional filtering.

**Parameters:**
- `country`: Filter by country
- `search`: Search in name, slug, or country
- `order_by`: `name`, `slug`, `country`, `created_at` (default: `name`)
- `order_direction`: `asc`, `desc` (default: `asc`)
- `per_page`: Items per page (default: 20)

### GET /api/cities/{city:slug}
Get a specific city by slug.

**Includes:**
- City details
- Count of careers in this city

### GET /api/cities/search
Search cities.

**Parameters:**
- `q`: Search query (required)

---

## Job Types API

### GET /api/job-types
Retrieve all job types.

**Parameters:**
- `search`: Search in name, slug, or description
- `order_by`: `name`, `slug`, `created_at` (default: `name`)
- `per_page`: Items per page (default: 20)

### GET /api/job-types/{jobType:slug}
Get a specific job type by slug.

**Includes:**
- Job type details
- Count of careers for this job type

### GET /api/job-types/search
Search job types.

**Parameters:**
- `q`: Search query (required)

---

## Tags API

### GET /api/tags
Retrieve all tags.

**Parameters:**
- `search`: Search in name, slug, or description
- `order_by`: `name`, `slug`, `created_at` (default: `name`)
- `per_page`: Items per page (default: 20)

### GET /api/tags/{tag:slug}
Get a specific tag by slug.

**Includes:**
- Tag details
- Count of posts using this tag

### GET /api/tags/popular
Get most popular tags (most used).

**Parameters:**
- `limit`: Number of tags to return (max: 50, default: 10)

### GET /api/tags/search
Search tags.

**Parameters:**
- `q`: Search query (required)

---

## Posts API

### GET /api/posts
Retrieve all published posts with optional filtering.

**Parameters:**
- `category_id`: Filter by category ID
- `category_slug`: Filter by category slug  
- `tag_id`: Filter by tag ID
- `is_featured`: Filter featured posts (boolean)
- `author_id`: Filter by author ID
- `search`: Search in title, content, slug, or excerpt
- `order_by`: `title`, `slug`, `created_at`, `view_count`, `published_at` (default: `published_at`)
- `order_direction`: `asc`, `desc` (default: `desc`)
- `per_page`: Items per page (default: 15)

**Example:**
```
GET /api/posts?category_slug=technology&is_featured=true&per_page=10
```

### GET /api/posts/{post:slug}
Get a specific post by slug.

**Parameters:**
- `skip_view_increment`: Skip incrementing view count (boolean)

**Includes:**
- Full post content
- Category details
- Author information
- Tags
- Gallery images
- Meta information

### GET /api/posts/featured
Get featured posts.

**Parameters:**
- `limit`: Number of posts (max: 50, default: 10)

### GET /api/posts/popular
Get popular posts (most viewed).

**Parameters:**
- `limit`: Number of posts (max: 50, default: 10)
- `days`: Time period in days (default: 30)

### GET /api/posts/{post:slug}/related
Get related posts for a specific post.

**Parameters:**
- `limit`: Number of posts (max: 20, default: 5)

**Logic:** Posts are considered related if they share the same category, tags, or author.

### GET /api/posts/search
Search posts.

**Parameters:**
- `q`: Search query (required)

---

## Careers API

### GET /api/careers
Retrieve all active careers with optional filtering.

**Parameters:**
- `category_id`: Filter by category ID
- `category_slug`: Filter by category slug
- `job_type_id`: Filter by job type ID
- `city_id`: Filter by city ID
- `tag_id`: Filter by tag ID
- `contract_type`: Filter by contract type (`cdi`, `cdd`, `freelance`, `internship`)
- `payment_type`: Filter by payment type (`monthly`, `daily`, `hourly`, `project`)
- `is_featured`: Filter featured careers (boolean)
- `location`: Search in location field
- `company`: Search in company name
- `search`: Search in title, content, company name, location, or slug
- `order_by`: `title`, `slug`, `created_at`, `view_count`, `company_name` (default: `created_at`)
- `order_direction`: `asc`, `desc` (default: `desc`)
- `per_page`: Items per page (default: 15)

**Example:**
```
GET /api/careers?city_id=1&contract_type=cdi&is_featured=true
```

### GET /api/careers/{career:slug}
Get a specific career by slug.

**Parameters:**
- `skip_view_increment`: Skip incrementing view count (boolean)

**Includes:**
- Full career details
- Category, job type, city information
- Author information
- Tags
- Salary information
- Application deadline
- Computed fields (salary range, days remaining, etc.)

### GET /api/careers/featured
Get featured careers.

**Parameters:**
- `limit`: Number of careers (max: 50, default: 10)

### GET /api/careers/popular
Get popular careers (most viewed).

**Parameters:**
- `limit`: Number of careers (max: 50, default: 10)
- `days`: Time period in days (default: 30)

### GET /api/careers/{career:slug}/related
Get related careers for a specific career.

**Parameters:**
- `limit`: Number of careers (max: 20, default: 5)

**Logic:** Careers are considered related if they share the same category, job type, city, or company.

### GET /api/careers/company/{company}
Get careers by company name.

**Parameters:**
- `limit`: Number of careers (max: 50, default: 10)

### GET /api/careers/search
Search careers.

**Parameters:**
- `q`: Search query (required)

---

## Data Models

### Category
```json
{
  "id": 1,
  "title": "Technology",
  "slug": "technology",
  "description": "<p>Technology related content</p>",
  "is_active": true,
  "order": 1,
  "image": "http://example.com/storage/categories/image.jpg",
  "parent_id": null,
  "parent": null,
  "children_count": 3,
  "created_at": "2025-01-01T00:00:00.000000Z",
  "updated_at": "2025-01-01T00:00:00.000000Z"
}
```

### Post
```json
{
  "id": 1,
  "title": "Example Post",
  "slug": "example-post",
  "content": "<p>Full HTML content...</p>",
  "excerpt": "Short description...",
  "featured_image": "http://example.com/storage/posts/image.jpg",
  "gallery_images": [
    {
      "disk": "uploads",
      "file": "path/to/image.jpg",
      "size": 123456,
      "mime_type": "image/jpeg",
      "customProperties": {
        "alt": "Alt text",
        "title": "Image title"
      }
    }
  ],
  "meta_title": "SEO Title",
  "meta_description": "SEO Description",
  "meta_keywords": ["keyword1", "keyword2"],
  "is_published": true,
  "is_featured": true,
  "is_active": true,
  "view_count": 150,
  "published_at": "2025-01-01T00:00:00.000000Z",
  "category": {
    "id": 1,
    "title": "Technology",
    "slug": "technology",
    "type": "post"
  },
  "author": {
    "id": 1,
    "name": "John Doe"
  },
  "tags": [
    {
      "id": 1,
      "name": "Laravel",
      "slug": "laravel"
    }
  ],
  "reading_time": 5,
  "created_at": "2025-01-01T00:00:00.000000Z",
  "updated_at": "2025-01-01T00:00:00.000000Z"
}
```

### Career
```json
{
  "id": 1,
  "title": "Software Developer",
  "slug": "software-developer",
  "content": "<p>Job description...</p>",
  "excerpt": "Short job summary...",
  "company_name": "Tech Corp",
  "location": "New York",
  "contract_type": "cdi",
  "payment_type": "monthly",
  "salary_min": 50000,
  "salary_max": 70000,
  "currency": "USD",
  "is_remote": false,
  "is_featured": true,
  "is_active": true,
  "application_deadline": "2025-12-31",
  "meta_title": "SEO Title",
  "meta_description": "SEO Description",
  "meta_keywords": ["programming", "software"],
  "view_count": 89,
  "category": {
    "id": 2,
    "name": "IT Jobs",
    "slug": "it-jobs",
    "type": "career",
    "parent_id": null
  },
  "author": {
    "id": 1,
    "name": "HR Manager",
    "email": "hr@techcorp.com"
  },
  "job_type": {
    "id": 1,
    "name": "Full Time",
    "slug": "full-time",
    "description": "Full time position"
  },
  "city": {
    "id": 1,
    "name": "New York",
    "slug": "new-york",
    "country": "USA"
  },
  "tags": [
    {
      "id": 1,
      "name": "PHP",
      "slug": "php"
    }
  ],
  "salary_range": "USD 50,000 - USD 70,000",
  "formatted_application_deadline": "2025-12-31",
  "days_remaining": 300,
  "is_expired": false,
  "reading_time": 3,
  "created_at": "2025-01-01T00:00:00.000000Z",
  "updated_at": "2025-01-01T00:00:00.000000Z"
}
```

---

## Error Handling

All endpoints return appropriate HTTP status codes:

- `200 OK`: Successful request
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation errors
- `500 Internal Server Error`: Server error

Error responses follow this format:
```json
{
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

---

## Usage Tips

1. **Pagination**: Always check the `meta` object for pagination information
2. **Performance**: Use `per_page` parameter to limit results as needed
3. **Search**: Use specific search endpoints for better performance
4. **Filtering**: Combine multiple filters for precise results
5. **Relationships**: Related data is included automatically where relevant
6. **Caching**: Consider implementing client-side caching for frequently accessed data

## Rate Limiting

The API may implement rate limiting in the future. Check response headers for rate limit information.

## Examples

### Get featured posts from a specific category:
```
GET /api/posts?category_slug=technology&is_featured=true&limit=5
```

### Search for remote jobs in a specific city:
```
GET /api/careers?city_id=1&is_remote=true&search=developer
```

### Get popular posts from the last 7 days:
```
GET /api/posts/popular?days=7&limit=10
```

This API provides a comprehensive interface for your React frontend to interact with the content management system.
