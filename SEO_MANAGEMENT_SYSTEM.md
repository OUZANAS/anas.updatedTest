# SEO Management System Documentation

## Overview

The SEO Management System allows administrators to manage SEO metadata for static pages through the Filament admin panel. The system includes:

1. A database schema for storing SEO metadata
2. A Filament admin interface for managing SEO data
3. An API endpoint for retrieving SEO data
4. React components for integrating SEO data into the frontend

## Database Structure

The system uses a `static_pages` table with the following fields:

- `id`: Primary key
- `slug`: Unique identifier for the page (e.g., 'home', 'about')
- `title`: Page title
- `page_name`: Descriptive name for the page
- `meta_title`: SEO title tag
- `meta_description`: SEO meta description
- `meta_keywords`: JSON array of keywords
- `canonical_url`: Canonical URL for the page
- `og_title`: Open Graph title
- `og_description`: Open Graph description
- `og_image`: Path to Open Graph image
- `og_type`: Open Graph type (default: 'website')
- `structured_data`: JSON-LD structured data for rich snippets
- `index_page`: Whether search engines should index the page
- `follow_links`: Whether search engines should follow links on the page
- `timestamps`: Created/updated timestamps

## Admin Interface

The SEO management interface is accessible in the Filament admin panel under **Settings > SEO & Static Pages**. The interface provides:

1. A list view showing all static pages with key SEO information
2. A form for adding/editing SEO metadata with tabs for:
   - Basic Information (title, slug, page name)
   - SEO (meta title, description, keywords)
   - Open Graph (og title, description, image)
   - Advanced (indexing controls, structured data)

## API Endpoints

### Get SEO Data for a Static Page

**Endpoint:** `GET /api/pages/{slug}/seo`

**Parameters:**
- `slug`: The page slug (e.g., 'home', 'about')

**Response Format:**
```json
{
  "success": true,
  "data": {
    "meta_title": "Page Title",
    "meta_description": "Page description",
    "meta_keywords": ["keyword1", "keyword2"],
    "og_title": "Open Graph Title",
    "og_description": "Open Graph Description",
    "og_image": "http://example.com/image.jpg",
    "canonical_url": "https://example.com/page",
    "no_index": false,
    "no_follow": false,
    "structured_data": { /* JSON-LD data */ }
  }
}
```

## Frontend Integration

The SEO system includes React components for easy integration with the frontend:

1. `seo.js`: Utility functions for fetching SEO data
2. `PageSeo.jsx`: React component that uses React Helmet to apply SEO data

### Example Usage

```jsx
import PageSeo from '../components/PageSeo';

const HomePage = () => {
  return (
    <>
      <PageSeo 
        slug="home"
        defaultData={{
          meta_title: 'Default Title',
          meta_description: 'Default description',
        }} 
      />
      
      {/* Page content */}
    </>
  );
};
```

## Initial Setup

The system comes with pre-seeded data for common pages:
- Home
- About Us
- Contact Us
- Services

You can modify these or add new pages through the admin interface.

## Best Practices

1. Keep meta titles under 60 characters
2. Keep meta descriptions between 120-160 characters
3. Use relevant keywords naturally in your content
4. Provide high-quality Open Graph images (1200x630px recommended)
5. Use structured data appropriate for your page content
6. Set canonical URLs to prevent duplicate content issues
