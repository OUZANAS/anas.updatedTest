<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user as author
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Get all categories of type 'post'
        $categories = Category::where('type', 'post')->get();
        
        // Get all tags
        $tags = Tag::all();
        
        // Sample content for posts
        $contentSamples = [
            [
                'title' => 'The Future of Digital Transformation in Moroccan Businesses',
                'content' => '<h2>Digital Transformation Trends</h2><p>Digital transformation is revolutionizing how businesses operate in Morocco. From small startups to established enterprises, organizations are leveraging technology to improve efficiency, enhance customer experiences, and gain competitive advantages in an increasingly digital marketplace.</p><p>Key technologies driving this transformation include:</p><ul><li>Cloud computing solutions</li><li>AI and machine learning applications</li><li>Advanced data analytics</li><li>IoT integration</li></ul><p>These technologies are enabling Moroccan businesses to modernize operations and compete on a global scale.</p><h2>Challenges and Opportunities</h2><p>Despite the clear benefits, many organizations face challenges in their digital transformation journeys. Limited technical expertise, budget constraints, and resistance to change are common obstacles.</p><p>However, the opportunities far outweigh these challenges. Businesses that successfully navigate digital transformation can expect:</p><ul><li>Increased operational efficiency</li><li>Enhanced customer engagement</li><li>Access to new markets</li><li>Data-driven decision making</li></ul><p>The key to success lies in developing a clear strategy that aligns technology investments with business objectives.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/futuristic-technology-concept-digital-transformation-260nw-1931234567.jpg',
                'meta_keywords' => ['Digital Transformation', 'Morocco', 'Business Technology', 'Innovation'],
            ],
            [
                'title' => 'Effective HR Management Strategies for Remote Teams',
                'content' => '<h2>The Rise of Remote Work</h2><p>Remote work has become increasingly common, transforming how HR departments recruit, onboard, and manage employees. This shift presents both challenges and opportunities for HR professionals.</p><p>Remote teams offer several advantages:</p><ul><li>Access to a global talent pool</li><li>Reduced overhead costs</li><li>Increased employee satisfaction</li><li>Improved work-life balance</li></ul><p>However, managing remote teams requires a different approach than traditional office-based teams.</p><h2>Best Practices for Remote HR Management</h2><p>Successful remote HR management strategies focus on communication, culture, and technology:</p><ol><li><strong>Clear Communication Channels</strong>: Establish regular check-ins and use appropriate tools for different types of communication.</li><li><strong>Remote-Friendly Culture</strong>: Build a culture that values results over hours worked and fosters inclusion regardless of location.</li><li><strong>Technology Integration</strong>: Implement HR software that facilitates remote onboarding, performance management, and team collaboration.</li></ol><p>By adapting HR practices to the unique needs of remote teams, organizations can maintain high levels of productivity and employee engagement.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/remote-work-concept-hr-management-260nw-1931234568.jpg',
                'meta_keywords' => ['Remote Work', 'HR Management', 'Team Building', 'Employee Engagement'],
            ],
            [
                'title' => 'Leveraging AI for Business Growth in Morocco',
                'content' => '<h2>AI Applications for Business</h2><p>Artificial Intelligence is transforming businesses across Morocco, offering innovative solutions to complex problems and creating new opportunities for growth and efficiency.</p><p>Key AI applications being adopted include:</p><ul><li>Chatbots for customer service</li><li>Predictive analytics for demand forecasting</li><li>Process automation for routine tasks</li><li>Personalized marketing through recommendation engines</li></ul><p>These technologies are helping Moroccan businesses improve customer experiences while reducing operational costs.</p><h2>Implementation Strategies</h2><p>Successfully implementing AI requires a strategic approach:</p><ol><li><strong>Start Small</strong>: Identify specific use cases where AI can deliver immediate value.</li><li><strong>Build Data Capabilities</strong>: Ensure your organization has the data infrastructure necessary to support AI initiatives.</li><li><strong>Develop Talent</strong>: Invest in training existing staff or hiring specialists with AI expertise.</li><li><strong>Partner with Experts</strong>: Consider collaborating with tech companies or consultants specializing in AI implementation.</li></ol><p>By taking a measured approach to AI adoption, businesses can maximize benefits while minimizing risks.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/ai-business-growth-260nw-1931234569.jpg',
                'meta_keywords' => ['Artificial Intelligence', 'Business Growth', 'Morocco', 'Technology Adoption'],
            ],
            [
                'title' => 'Creating an Effective Digital Marketing Strategy',
                'content' => '<h2>The Digital Marketing Landscape</h2><p>Digital marketing has become essential for businesses seeking to connect with customers in an increasingly online world. An effective strategy encompasses multiple channels and approaches tailored to your target audience.</p><p>Key components of a successful digital marketing strategy include:</p><ul><li>Content marketing that provides value to your audience</li><li>SEO optimization to improve visibility in search results</li><li>Social media campaigns that engage and build community</li><li>Email marketing that nurtures leads and maintains customer relationships</li></ul><p>These elements work together to create a comprehensive approach to reaching and converting potential customers.</p><h2>Data-Driven Decision Making</h2><p>Modern digital marketing relies heavily on data analysis:</p><ol><li><strong>Set Clear KPIs</strong>: Define what success looks like for each marketing initiative.</li><li><strong>Implement Tracking</strong>: Use analytics tools to monitor performance across channels.</li><li><strong>Test and Optimize</strong>: Continuously experiment with different approaches and refine based on results.</li><li><strong>Customer Journey Analysis</strong>: Understand how customers interact with your brand across touchpoints.</li></ol><p>By leveraging data effectively, marketers can allocate resources to the channels and tactics that deliver the best results.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/digital-marketing-strategy-260nw-1931234570.jpg',
                'meta_keywords' => ['Digital Marketing', 'Content Strategy', 'SEO', 'Social Media Marketing'],
            ],
            [
                'title' => 'Building a Sustainable Business Model in Today\'s Economy',
                'content' => '<h2>Sustainability as a Business Imperative</h2><p>Sustainability has evolved from a nice-to-have to a business imperative. Companies that integrate environmental and social considerations into their core business models are better positioned for long-term success.</p><p>Benefits of sustainable business practices include:</p><ul><li>Reduced operational costs through resource efficiency</li><li>Enhanced brand reputation and customer loyalty</li><li>Improved ability to attract and retain talent</li><li>Reduced regulatory and supply chain risks</li></ul><p>These advantages contribute to both short-term profitability and long-term resilience.</p><h2>Implementing Sustainable Practices</h2><p>Creating a sustainable business model requires a holistic approach:</p><ol><li><strong>Assess Current Impact</strong>: Understand your organization\'s environmental and social footprint.</li><li><strong>Set Meaningful Goals</strong>: Establish specific, measurable targets for improvement.</li><li><strong>Engage Stakeholders</strong>: Involve employees, customers, suppliers, and investors in sustainability initiatives.</li><li><strong>Integrate Into Operations</strong>: Embed sustainability considerations into day-to-day decision making.</li></ol><p>By taking a systematic approach to sustainability, businesses can create value while contributing to environmental and social well-being.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/sustainable-business-model-260nw-1931234571.jpg',
                'meta_keywords' => ['Sustainability', 'Business Model', 'Corporate Responsibility', 'Green Business'],
            ],
            [
                'title' => 'The Impact of Cloud Computing on Business Operations',
                'content' => '<h2>Cloud Computing Advantages</h2><p>Cloud computing has fundamentally changed how businesses operate, offering unprecedented flexibility, scalability, and efficiency. Organizations of all sizes are migrating critical systems to cloud platforms to reduce costs and improve agility.</p><p>Key benefits of cloud computing include:</p><ul><li>Reduced capital expenditure on IT infrastructure</li><li>Scalable resources that adjust to business needs</li><li>Improved collaboration through shared access</li><li>Enhanced disaster recovery capabilities</li></ul><p>These advantages make cloud computing an attractive option for businesses looking to modernize their IT operations.</p><h2>Implementation Considerations</h2><p>Moving to the cloud requires careful planning:</p><ol><li><strong>Assess Workload Suitability</strong>: Determine which applications and data are appropriate for cloud migration.</li><li><strong>Choose the Right Model</strong>: Evaluate public, private, and hybrid cloud options based on business requirements.</li><li><strong>Address Security Concerns</strong>: Implement robust security measures to protect sensitive data.</li><li><strong>Manage Costs Effectively</strong>: Monitor usage and optimize resources to control expenses.</li></ol><p>With thoughtful implementation, cloud computing can deliver significant business value while minimizing potential risks.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/cloud-computing-business-260nw-1931234572.jpg',
                'meta_keywords' => ['Cloud Computing', 'IT Infrastructure', 'Digital Transformation', 'Business Technology'],
            ],
            [
                'title' => 'Developing a Strong Corporate Culture in Remote Work Environments',
                'content' => '<h2>Culture in a Distributed Workforce</h2><p>As organizations embrace remote work, maintaining a strong corporate culture has become both more challenging and more important. A positive culture drives engagement, retention, and performance, even when team members are geographically dispersed.</p><p>Elements of strong remote work culture include:</p><ul><li>Clear mission and values that guide decision-making</li><li>Transparent communication at all levels</li><li>Trust-based management approaches</li><li>Intentional social connection opportunities</li></ul><p>These foundations help remote teams feel connected to the organization and each other.</p><h2>Strategies for Building Remote Culture</h2><p>Developing culture in remote environments requires deliberate effort:</p><ol><li><strong>Structured Communication</strong>: Establish regular team meetings, one-on-ones, and informal check-ins.</li><li><strong>Virtual Team Building</strong>: Create opportunities for non-work interactions through virtual events and activities.</li><li><strong>Recognition Programs</strong>: Celebrate achievements and milestones to maintain motivation and engagement.</li><li><strong>Documented Processes</strong>: Clearly articulate expectations and workflows to provide structure.</li></ol><p>By investing in these practices, organizations can foster a strong culture that transcends physical distance.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/remote-work-culture-260nw-1931234573.jpg',
                'meta_keywords' => ['Corporate Culture', 'Remote Work', 'Employee Engagement', 'Team Building'],
            ],
            [
                'title' => 'Effective Leadership Strategies for Uncertain Times',
                'content' => '<h2>Leadership During Uncertainty</h2><p>Leading during uncertain times requires a unique set of skills and approaches. Effective leaders navigate ambiguity while providing clarity, direction, and support to their teams.</p><p>Key leadership qualities for uncertain times include:</p><ul><li>Adaptability and comfort with change</li><li>Transparent communication about challenges</li><li>Emotional intelligence and empathy</li><li>Decisive action based on available information</li></ul><p>These attributes help leaders maintain team confidence and productivity despite external challenges.</p><h2>Practical Leadership Approaches</h2><p>Leaders can implement several strategies to guide teams through uncertainty:</p><ol><li><strong>Establish Clear Priorities</strong>: Focus team efforts on the most critical objectives.</li><li><strong>Create Psychological Safety</strong>: Foster an environment where team members feel safe sharing concerns and ideas.</li><li><strong>Develop Scenario Plans</strong>: Prepare for multiple potential outcomes to increase organizational agility.</li><li><strong>Emphasize Learning and Adaptation</strong>: Treat setbacks as opportunities for growth and improvement.</li></ol><p>By embracing these approaches, leaders can help their organizations not only survive but thrive during uncertain times.</p>',
                'featured_image' => 'https://image.shutterstock.com/image-photo/leadership-strategies-uncertain-times-260nw-1931234574.jpg',
                'meta_keywords' => ['Leadership', 'Crisis Management', 'Organizational Change', 'Resilience'],
            ],
        ];

        foreach ($contentSamples as $index => $sample) {
            // Create post
            $post = Post::create([
                'title' => $sample['title'],
                'slug' => Str::slug($sample['title']),
                'content' => $sample['content'],
                'featured_image' => $sample['featured_image'],
                'gallery_images' => [], // No actual gallery in seeder
                'meta_title' => $sample['title'],
                'meta_description' => $sample['title'],
                'meta_keywords' => $sample['meta_keywords'],
                'is_published' => true,
                'is_featured' => $index < 3, // First 3 posts are featured
                'is_active' => true,
                'view_count' => rand(10, 500),
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);

            // Attach 2-5 random tags to each post
            $post->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );
        }
    }
}
