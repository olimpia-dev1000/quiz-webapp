describe('Viewing Quizzes', () => {

  const testUser = {
    name: 'Test User',
    email: `test1245678910@example.com`,
    password: 'password123',
    password_confirmation: 'password123'
  }

  beforeEach(() => {
    cy.visit('http://localhost:8000/register')

    // Fill in registration form
    cy.get('input#name').type(testUser.name)
    cy.get('input#email').type(testUser.email)
    cy.get('input#password').type(testUser.password)
    cy.get('input#password_confirmation').type(testUser.password_confirmation)
    cy.get('button[type="submit"]').contains('Register').click()

    cy.visit('http://localhost:8000/login')

    // Fill in login form
    cy.get('input#email').type(testUser.email)
    cy.get('input#password').type(testUser.password)

    // Submit form
    cy.get('button[type="submit"]').contains('Log in').click()

  })

  it('see the quizzes tab in the navigation bar', () => {
    cy.visit('http://localhost:8000/dashboard').contains('Dashboard');
    cy.visit('http://localhost:8000/dashboard').contains('Quizzes');
  })

  it('see the add link on the quizzes page', () => {
    cy.visit('http://localhost:8000/quizzes');
    cy.getByData('add-quiz-link').should('exist');
  })

  it('see the form to create a quizz containing the token', () => {
    cy.visit('http://localhost:8000/quizzes/create');
    cy.getByData('add-quiz-form').within(() => {
      cy.get('input[name="_token"]').should('exist');
    });

  })

  it('should contain all the neccesary fields', () => {
    cy.visit('http://localhost:8000/quizzes/create');
    cy.getByData('add-quiz-form-title-field').should('exist');
    cy.getByData('add-quiz-form-description-field').should('exist');
    // cy.getByData('add-quiz-form-is-public-field').should('exist');
    cy.getByData('add-quiz-form-time-limit-field').should('exist');
    cy.getByData('add-quiz-form-save-button').should('exist');
    cy.getByData('add-quiz-form-cancel-button').should('exist');

  })

  it('form is successfully submitted', () => {
    cy.visit('http://localhost:8000/quizzes/create');

    cy.getByData('add-quiz-form-title-field').type('Basic Laravel');
    cy.getByData('add-quiz-form-description-field').type('This quiz is about basics of Laravel.');
    cy.getByData('add-quiz-form-time-limit-field').type('15');
    cy.getByData('add-quiz-form-save-button').click();

    cy.contains('Basic Laravel');
    cy.contains('This quiz is about basics of Laravel.');

  })

  it('can be deleted', () => {
    cy.visit('http://localhost:8000/quizzes/create');

    cy.getByData('add-quiz-form-title-field').type('Basic Laravel');
    cy.getByData('add-quiz-form-description-field').type('This quiz is about basics of Laravel.');
    cy.getByData('add-quiz-form-time-limit-field').type('15');
    cy.getByData('add-quiz-form-save-button').click();

    cy.getByData('add-quiz-form-delete-quiz-button').first().click();

    cy.on('window:confirm', (confirmText) => {
      expect(confirmText).to.equal('Are you sure you want to delete this quiz?');
      return true;
    });


  })

  it('can have multiple choice questions', () => {
    cy.visit('http://localhost:8000/quizzes');
    cy.getByData('add-quiz-form-add-questions-button').first().click();
    cy.getByData('add-question-question-text-field').type('Test question');
    cy.getByData('add-question-points-text-field').type('5');

    cy.getByData('add-question-form-save-button').click();
  })

  it('question title can be edited', () => {
    cy.visit('http://localhost:8000/quizzes');

    cy.getByData('add-quiz-form-add-questions-button').first().click();
    cy.getByData('add-question-question-text-field').type('Test question');
    cy.getByData('add-question-points-text-field').type('5');
    cy.getByData('add-question-form-save-button').click();

    cy.getByData('edit-question-question-text-field').first()
      .clear()
      .type('Changed question')
      .blur(); // Ensures input field update

    cy.getByData('edit-question-question-text-field')
      .first()
      .should('have.value', 'Changed question'); // Waits for the update
  });


  it('question can be deleted', () => {
    cy.visit('http://localhost:8000/quizzes');
    cy.getByData('add-quiz-form-add-questions-button').first().click();
    cy.getByData('add-question-question-text-field').type('Test question');
    cy.getByData('add-question-points-text-field').type('5');

    cy.getByData('add-question-form-save-button').click();
    cy.getByData('edit-question-delete-button').first().click();

    cy.on('window:confirm', (confirmText) => {
      expect(confirmText).to.equal('Are you sure you want to delete this question?');
      return true;
    });

  })




})