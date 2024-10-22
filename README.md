# Laravel Twill Project

## Overview

This project is built using [Laravel](https://laravel.com/) and [Twill](https://twill.io/), an open-source CMS toolkit for Laravel applications. The goal is to create a flexible and powerful content management solution that leverages the capabilities of both Laravel and Twill.

## Requirements

- PHP >= 8.2
- Composer
- Laravel >= 8.x
- MySQL or any other database supported by Laravel
- Twill >= 2.x

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Mk-avtandil/test_project.git
    ```

2. Navigate into the project directory:
    ```bash
    cd your-repo-name
    ```

3. Install PHP dependencies:
    ```bash
    composer install
    ```

4. Copy the `.env` file:
    ```bash
    cp .env.example .env
    ```

5. Set up your environment variables in the `.env` file (such as database configuration).

6. Generate the application key:
    ```bash
    php artisan key:generate
    ```

7. Run database migrations with seeders:
    ```bash
    php artisan migrate --seed
    ```   
8. Link storage for images:
   ```bash
   php artisan storage:link
   ```
9. Serve the application:
    ```bash
    php artisan serve
    ```

## Usage

Once the server is up and running, requests can be sent to `http://localhost:8000` to access the application API.

To access the Twill admin panel, navigate to `http://localhost:8000/admin`.

## Features

- **Modular Content Management:** Twill simplifies the creation of content modules that can be reused across the site.
- **Media Library:** A robust media management system with drag-and-drop support.
- **Multilingual Support:** Manage content in multiple languages with ease.

## Contributors

- **[Avtandil](https://github.com/Mk-avtandil)**
- **[Baitur](https://github.com/bby2r)**

## Support

For any questions or support, feel free to reach out via email or open an issue on GitHub.
