# Database Seeders Guide

This guide explains the seeders that have been created for the project and how to use them.

## Available Seeders

The following seeders have been created to populate the database with initial data:

1. `CitySeeder`: Creates 10 major Moroccan cities
2. `JobTypeSeeder`: Creates 8 common job types (Full Time, Part Time, Contract, etc.)
3. `CategorySeeder`: Creates categories for both posts and careers, including parent-child relationships
4. `TagSeeder`: Creates 20 common tags for content categorization
5. `PostSeeder`: Creates 8 sample blog posts with realistic content
6. `CareerSeeder`: Creates 8 sample job postings with detailed descriptions

## Running the Seeders

### Running All Seeders

To run all seeders in the correct order, use:

```bash
php artisan db:seed
```

This will execute the `DatabaseSeeder` class which calls all other seeders in the appropriate order.

### Running Individual Seeders

If you want to run a specific seeder:

```bash
# For just cities
php artisan db:seed --class=CitySeeder

# For just job types
php artisan db:seed --class=JobTypeSeeder

# For just categories
php artisan db:seed --class=CategorySeeder

# For just tags
php artisan db:seed --class=TagSeeder

# For just posts
php artisan db:seed --class=PostSeeder

# For just careers
php artisan db:seed --class=CareerSeeder
```

## Data Relationships

The seeders maintain proper relationships between models:

- Posts and careers are assigned to random categories
- Posts and careers are tagged with random tags
- Careers are assigned to random cities and job types
- All content is assigned to the admin user

## Note About Images

The seeders do not include actual image files. For a complete experience with images:

1. Manually upload images through the admin interface after seeding
2. Or modify the seeders to include real image paths if you have image files available

## Refreshing the Database

If you want to reset your database and re-run all seeders:

```bash
php artisan migrate:fresh --seed
```

**Warning**: This will delete all existing data in your database.

## Adding More Seed Data

To add more seed data, you can modify the existing seeder classes or create new ones.

For example, to add more posts to the `PostSeeder`:

1. Open `database/seeders/PostSeeder.php`
2. Add new entries to the `$contentSamples` array
3. Re-run the seeder

## Troubleshooting

If you encounter any issues when running the seeders:

- Make sure your database connection is configured correctly
- Check if the models referenced in the seeders exist and have the correct relationships
- Verify that the table structure matches the data being seeded

If you need to add additional data or modify the existing seeders, all files are located in the `database/seeders` directory.
