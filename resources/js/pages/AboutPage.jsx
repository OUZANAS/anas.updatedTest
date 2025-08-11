import React from 'react';
import PageSeo from '../components/PageSeo';

/**
 * About Page Component
 */
const AboutPage = () => {
  return (
    <>
      {/* Apply SEO data for the about page */}
      <PageSeo 
        slug="about"
        defaultData={{
          meta_title: 'About Anas - Our Mission and Vision',
          meta_description: 'Learn about our career platform',
        }} 
      />
      
      {/* Your about page content */}
      <div className="about-page">
        <h1>About Anas</h1>
        <p>Our mission and vision</p>
        {/* Rest of your about page content */}
      </div>
    </>
  );
};

export default AboutPage;
