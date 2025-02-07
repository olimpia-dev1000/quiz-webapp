# Quiz Platform

A web application built with Laravel and TailwindCSS that allows users to create, share, and embed quizzes.

## Features

- User authentication and registration
- Quiz creation and management
- Quiz sharing functionality
- Score tracking and results dashboard
- WordPress embedding support

## Tech Stack

### Backend
- PHP 8.2+
- Laravel 10.x
- MySQL 8.0+
- Laravel Sanctum for API

### Frontend
- TailwindCSS
- Alpine.js
- Laravel Blade
- JavaScript

### Infrastructure
- Laravel Forge
- SSL certificate
- Automated backups

## Project Structure

### Phase 1: Setup & Authentication
- Initial Laravel project setup with TailwindCSS
- User authentication:
  - Registration
  - Login/Logout
  - Password reset
- Database schema for users

### Phase 2: Quiz Creation
- Quiz management:
  - Creation form
  - Multiple choice questions
  - Quiz editing
  - Quiz deletion
- Quiz preview functionality

### Phase 3: Quiz Sharing & Taking
- Quiz sharing mechanism
- Quiz taking interface
- Score calculation
- Results storage
- Results dashboard

### Phase 4: WordPress Integration
- Embedding mechanism
- WordPress plugin
- Embedded quiz styling
- Integration documentation

### Phase 5: Deployment
- Testing & bug fixes
- Forge deployment
- SSL setup
- Production configuration

## Database Schema

### Core Tables
- users
- quizzes
- questions
- answers
- quiz_attempts
- quiz_results

## Security

- CSRF protection
- XSS prevention
- API authentication for WordPress
- Input validation

## Future Enhancements
- Additional question types
- Quiz templates
- Analytics dashboard
- API for third-party integration

## Installation

```bash
# Clone the repository
git clone [your-repository-url]

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Compile assets
npm run dev
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
