import React from 'react';
import PageSeo from '../components/PageSeo';

/**
 * Home Page Component
 */
const HomePage = () => {
  return (
    <>
      {/* Apply SEO data for the home page */}
      <PageSeo 
        slug="home"
        defaultData={{
          meta_title: 'Anas - Your Career Development Platform',
          meta_description: 'Find job opportunities and career resources',
        }} 
      />
      
      {/* Your home page content */}
      <div className="home-page">
        <h1>Welcome to Anas</h1>
        <p>Your career development platform</p>
        {/* Rest of your home page content */}
      </div>
    </>
  );
};

export default HomePage;
