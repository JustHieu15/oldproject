# Install Composer Dependencies

-   composer install

# Install NPM Dependencies (Optional, If any)

-   npm install

# Create a copy of your .env file

-   cp .env.example .env

# Generate an app encryption key

-   php artisan key:generate

# Create an empty database for our application

-   Create a database in your local machine and update the database credentials in .env file

# Migrate the database

-   php artisan migrate

# Seed the database (Optional, If any)

-   php artisan db:seed

# Link storage folder

-   php artisan storage:link

# Start the development server

-   php artisan serve
