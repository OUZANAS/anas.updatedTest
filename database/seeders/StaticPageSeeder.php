<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'page_name' => 'Home Page',
                'meta_title' => 'Welcome to Anas - Your Career Development Platform',
                'meta_description' => 'Find job opportunities, career insights, and professional development resources at Anas. Start your career journey today!',
                'meta_keywords' => json_encode(['career', 'jobs', 'professional development', 'employment', 'careers']),
                'og_title' => 'Anas - Your Career Development Platform',
                'og_description' => 'Discover job opportunities and career resources to advance your professional journey.',
                'og_image' => 'storage/images/og-home.jpg',
                'canonical_url' => 'https://anas.com',
                'index_page' => true,
                'follow_links' => true,
                'structured_data' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Organization',
                    'name' => 'Anas',
                    'url' => 'https://anas.com',
                    'logo' => 'https://anas.com/logo.png',
                ]),
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'page_name' => 'About Page',
                'meta_title' => 'About Anas - Our Mission and Vision',
                'meta_description' => 'Learn about Anas, our mission to connect professionals with opportunities, and our vision for the future of career development.',
                'meta_keywords' => json_encode(['about anas', 'career platform', 'mission', 'vision', 'our story']),
                'og_title' => 'About Anas - Career Development Platform',
                'og_description' => 'Discover our mission and vision for transforming career development.',
                'og_image' => 'storage/images/og-about.jpg',
                'canonical_url' => 'https://anas.com/about',
                'index_page' => true,
                'follow_links' => true,
                'structured_data' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'AboutPage',
                    'mainEntity' => [
                        '@type' => 'Organization',
                        'name' => 'Anas',
                        'description' => 'A career development platform connecting professionals with opportunities.',
                        'foundingDate' => '2023',
                    ],
                ]),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'page_name' => 'Contact Page',
                'meta_title' => 'Contact Anas - Get in Touch With Our Team',
                'meta_description' => 'Have questions or feedback? Contact the Anas team for support with our career services and platform features.',
                'meta_keywords' => json_encode(['contact', 'support', 'help', 'feedback', 'get in touch']),
                'og_title' => 'Contact the Anas Team',
                'og_description' => 'Reach out to our team for assistance with our career platform.',
                'og_image' => 'storage/images/og-contact.jpg',
                'canonical_url' => 'https://anas.com/contact',
                'index_page' => true,
                'follow_links' => true,
                'structured_data' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'ContactPage',
                    'mainEntity' => [
                        '@type' => 'Organization',
                        'name' => 'Anas',
                        'contactPoint' => [
                            '@type' => 'ContactPoint',
                            'telephone' => '+1-555-555-5555',
                            'email' => 'info@anas.com',
                            'contactType' => 'Customer Support',
                        ],
                    ],
                ]),
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'page_name' => 'Services Page',
                'meta_title' => 'Anas Services - Career Development Solutions',
                'meta_description' => 'Explore our range of career services including job listings, career counseling, resume building, and professional development resources.',
                'meta_keywords' => json_encode(['services', 'career services', 'job listings', 'resume building', 'career counseling']),
                'og_title' => 'Anas Career Development Services',
                'og_description' => 'Comprehensive career services to help you advance professionally.',
                'og_image' => 'storage/images/og-services.jpg',
                'canonical_url' => 'https://anas.com/services',
                'index_page' => true,
                'follow_links' => true,
                'structured_data' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'serviceType' => 'Career Development',
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Anas',
                    ],
                    'offers' => [
                        [
                            '@type' => 'Offer',
                            'name' => 'Job Listings',
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Career Counseling',
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Resume Building',
                        ],
                    ],
                ]),
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::create($page);
        }
    }
}
