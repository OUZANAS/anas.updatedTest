/**
 * Fetches SEO data for a specific page from the backend API
 * 
 * @param {string} slug - The page slug (e.g., 'home', 'about', 'contact')
 * @returns {Promise<Object>} - The SEO data for the page
 */
export const fetchSeoData = async (slug) => {
  try {
    const response = await fetch(`/api/pages/${slug}/seo`);
    const data = await response.json();
    
    if (!data.success) {
      console.error('Error fetching SEO data:', data.message);
      return getDefaultSeoData();
    }
    
    return data.data;
  } catch (error) {
    console.error('Error fetching SEO data:', error);
    return getDefaultSeoData();
  }
};

/**
 * Returns default SEO data if the API request fails
 * 
 * @returns {Object} - Default SEO data
 */
export const getDefaultSeoData = () => {
  return {
    meta_title: 'Anas - Career Development Platform',
    meta_description: 'Find job opportunities, career insights, and professional development resources at Anas.',
    meta_keywords: ['career', 'jobs', 'professional development'],
    og_title: 'Anas - Career Development Platform',
    og_description: 'Discover job opportunities and career resources to advance your professional journey.',
    og_image: '/images/default-og-image.jpg',
    canonical_url: window.location.href,
    no_index: false,
    no_follow: false,
    structured_data: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'Organization',
      'name': 'Anas',
      'url': 'https://anas.com',
      'logo': 'https://anas.com/logo.png',
    }),
  };
};
