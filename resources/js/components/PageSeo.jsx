import React, { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet';
import { fetchSeoData } from '../utils/seo';

/**
 * SEO component that fetches and applies SEO metadata for a specific page
 * 
 * @param {Object} props - Component props
 * @param {string} props.slug - The page slug (e.g., 'home', 'about', 'contact')
 * @param {Object} props.defaultData - Default SEO data to use while loading
 * @returns {React.Component} - A React component with Helmet for SEO
 */
const PageSeo = ({ slug, defaultData = {} }) => {
  const [seoData, setSeoData] = useState(defaultData);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const loadSeoData = async () => {
      setLoading(true);
      const data = await fetchSeoData(slug);
      setSeoData(data);
      setLoading(false);
    };

    loadSeoData();
  }, [slug]);

  // Parse the structured data if it exists and is a string
  let structuredData = null;
  if (seoData.structured_data) {
    try {
      // If already an object, use it directly, otherwise parse it
      structuredData = typeof seoData.structured_data === 'string' 
        ? JSON.parse(seoData.structured_data) 
        : seoData.structured_data;
    } catch (e) {
      console.error('Error parsing structured data:', e);
    }
  }

  // Parse keywords if they're a string
  let keywords = seoData.meta_keywords;
  if (typeof keywords === 'string') {
    try {
      keywords = JSON.parse(keywords);
    } catch (e) {
      keywords = keywords.split(',').map(k => k.trim());
    }
  }

  return (
    <Helmet>
      {/* Basic Meta Tags */}
      <title>{seoData.meta_title}</title>
      <meta name="description" content={seoData.meta_description} />
      {Array.isArray(keywords) && (
        <meta name="keywords" content={keywords.join(', ')} />
      )}
      
      {/* Canonical URL */}
      {seoData.canonical_url && (
        <link rel="canonical" href={seoData.canonical_url} />
      )}
      
      {/* Robots Meta Tags */}
      <meta 
        name="robots" 
        content={`${seoData.no_index ? 'noindex' : 'index'}, ${seoData.no_follow ? 'nofollow' : 'follow'}`} 
      />
      
      {/* Open Graph Meta Tags */}
      <meta property="og:title" content={seoData.og_title || seoData.meta_title} />
      <meta property="og:description" content={seoData.og_description || seoData.meta_description} />
      {seoData.og_image && <meta property="og:image" content={seoData.og_image} />}
      <meta property="og:type" content={seoData.og_type || 'website'} />
      <meta property="og:url" content={seoData.canonical_url || window.location.href} />
      
      {/* Structured Data */}
      {structuredData && (
        <script type="application/ld+json">
          {JSON.stringify(structuredData)}
        </script>
      )}
      
      {/* Additional Meta Tags (if provided) */}
      {seoData.extra_meta_tags && (
        <div dangerouslySetInnerHTML={{ __html: seoData.extra_meta_tags }} />
      )}
    </Helmet>
  );
};

export default PageSeo;
