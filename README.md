# Quiz Platform

A test-driven Laravel application for creating, sharing, and embedding quizzes, built with TDD principles from the ground up.

## Development Approach

This project follows Test-Driven Development (TDD) principles:
1. Write failing tests first
2. Write minimal code to pass tests
3. Refactor while keeping tests green

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
- PHPUnit for testing

### Frontend
- TailwindCSS
- Alpine.js
- Laravel Blade
- JavaScript
- Jest for JS testing

### Testing
- PHPUnit for PHP unit/feature tests
- Jest for JavaScript unit tests
- Cypress.io for end-to-end testing

### Infrastructure
- Laravel Forge
- SSL certificate
- Automated backups

## Testing Strategy

### Unit & Feature Tests (PHPUnit)
```bash
# Run all PHP tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage report
php artisan test --coverage
```

### JavaScript Tests (Jest)
```bash
# Run all JS tests
npm run test

# Run tests in watch mode
npm run test:watch
```

### End-to-End Tests (Cypress)
```bash
# Open Cypress Test Runner
npm run cypress:open

# Run Cypress tests headlessly
npm run cypress:run
```

## Cypress Test Structure

```javascript
// cypress/e2e/quiz/creation.cy.js
describe('Quiz Creation', () => {
  beforeEach(() => {
    cy.login()  // Custom command for authentication
  })

  it('allows user to create a quiz', () => {
    // Visit quiz creation page
    cy.visit('/quizzes/create')

    // Fill in quiz details
    cy.get('[data-cy=quiz-title]').type('My Test Quiz')
    cy.get('[data-cy=quiz-description]').type('Quiz description')
    
    // Add a question
    cy.get('[data-cy=add-question]').click()
    cy.get('[data-cy=question-text]').type('What is TDD?')
    
    // Add answers
    cy.get('[data-cy=add-answer]').click()
    cy.get('[data-cy=answer-text]').type('Test Driven Development')
    cy.get('[data-cy=is-correct]').check()

    // Submit the form
    cy.get('[data-cy=submit-quiz]').click()

    // Assert quiz was created
    cy.url().should('include', '/quizzes')
    cy.contains('Quiz created successfully')
  })
})
```

## Project Structure & Test Coverage

### Phase 1: Authentication Foundation
- Feature Tests (PHPUnit):
  - User registration
  - User login/logout
  - Password reset
- E2E Tests (Cypress):
  - Complete registration flow
  - Login with credentials
  - Password reset process
- Unit Tests:
  - User model
  - Authentication services

### Phase 2: Quiz Management
- Feature Tests (PHPUnit):
  - Quiz CRUD operations
  - Question management
- E2E Tests (Cypress):
  - Complete quiz creation flow
  - Quiz editing process
  - Question and answer management
- Unit Tests:
  - Quiz service layer
  - Validation rules

### Phase 3: Quiz Taking System
- Feature Tests (PHPUnit):
  - Quiz attempt functionality
  - Scoring system
- E2E Tests (Cypress):
  - Complete quiz taking flow
  - Real-time score calculation
  - Results display
- Unit Tests:
  - Scoring service
  - Results service

### Phase 4: WordPress Integration
- Feature Tests (PHPUnit):
  - Embed token generation
  - API endpoints
- E2E Tests (Cypress):
  - Embed flow testing
  - WordPress plugin interaction
- Unit Tests:
  - Embed service
  - Token service

## Installation for Development

```bash
# Clone the repository
git clone [your-repository-url]

# Install dependencies
composer install
npm install

# Copy environment files
cp .env.example .env
cp cypress.env.json.example cypress.env.json

# Generate application key
php artisan key:generate

# Create databases
php artisan db:create testing
php artisan db:create cypress

# Run migrations
php artisan migrate
php artisan migrate --env=testing
php artisan migrate --env=cypress

# Install Cypress
npm install cypress --save-dev

# Run all test suites
php artisan test          # PHPUnit tests
npm run test             # Jest tests
npm run cypress:run      # Cypress tests
```

## Continuous Integration

This project uses GitHub Actions for CI/CD with the following test workflow:
1. PHPUnit tests
2. Jest tests
3. Cypress end-to-end tests
4. Code coverage report generation

## Development Workflow

1. Create a new branch for the feature
2. Write failing tests (Unit, Feature, and E2E)
3. Implement minimal code to pass tests
4. Refactor while keeping tests green
5. Submit pull request with all tests passing

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Write tests (Unit, Feature, and E2E)
4. Implement your feature while keeping tests green
5. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
6. Push to the branch (`git push origin feature/AmazingFeature`)
7. Open a Pull Request with test coverage

## License

[MIT](https://choosealicense.com/licenses/mit/)
