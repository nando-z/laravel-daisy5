# Laravel Daisy5

Laravel Daisy5 is a UI package for the Laravel framework. It integrates DaisyUI 5, providing a set of pre-designed components and utilities to build modern, maintainable, and scalable web applications.

## Features

- User authentication and authorization
- RESTful API support
- Eloquent ORM for database interactions
- Blade templating engine
- Artisan command-line tool
- Comprehensive testing tools
- Pre-designed UI components with DaisyUI 5

## Installation

1. Install the package via Composer:
    ```bash
    composer require yourusername/laravel-daisy5
    ```
2. Publish the package configuration (if any):
    ```bash
    php artisan vendor:publish --provider="NandoZ\Daisy5\Daisy5ServiceProvider"
    ```
3. Install DaisyUI 5:
    ```bash
    npm install daisyui@5
    ```
4. Run the database migrations:
    ```bash
    php artisan migrate
    ```

## Usage

Start the development server:
```bash
php artisan serve
```
Visit `http://localhost:8000` in your browser to see the application in action.

## Contributing

Contributions are welcome! Please read the [contributing guidelines](CONTRIBUTING.md) for more information.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

