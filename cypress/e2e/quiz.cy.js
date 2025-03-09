describe('Viewing Quizzes', () => {

  const user = {
    name: "Test User",
    email: "testuser@example.com",
    password: "passwloiretfdf!!@",
  };

  before(() => {
    cy.task('resetDatabase').then(() => {
      cy.log('Database reset completed');
    });
    cy.task('createTestUser', user).then(() => {
      cy.log('Test user created');
    });
    cy.task('createQuiz', {
      email: user.email,
      questionsCount: 5,
      hasAnswers: true
    }).then(() => {
      cy.log('Quiz created');
    });
  });

  beforeEach(() => {
    cy.session("user-session", () => {
      cy.log('Attempting to log in');
      cy.login(user.email, user.password);
    }, {
      cacheAcrossSpecs: true,
      validate() {
        cy.log('Validating session');
        cy.visit('/quizzes');
        cy.url().should('include', '/quizzes');
      }
    });
  });

  it('see the quizzes tab in the navigation bar', () => {
    cy.visit('/dashboard').contains('Dashboard');
    cy.visit('/dashboard').contains('Quizzes');
  });

  it('see the add link on the quizzes page', () => {
    cy.visit('/quizzes');
    cy.getByData('add-quiz-link').should('exist');
  })

  it('see the form to create a quizz containing the token', () => {
    cy.visit('/quizzes/create');
    cy.getByData('add-quiz-form').within(() => {
      cy.get('input[name="_token"]').should('exist');
    });

  })

  it('should contain all the neccesary fields', () => {
    cy.visit('/quizzes/create');
    cy.getByData('add-quiz-form-title-field').should('exist');
    cy.getByData('add-quiz-form-description-field').should('exist');
    // cy.getByData('add-quiz-form-is-public-field').should('exist');
    cy.getByData('add-quiz-form-time-limit-field').should('exist');
    cy.getByData('add-quiz-form-save-button').should('exist');
    cy.getByData('add-quiz-form-cancel-button').should('exist');

  })

  it('form is successfully submitted', () => {
    cy.visit('/quizzes/create');

    cy.getByData('add-quiz-form-title-field').type('Basic Laravel');
    cy.getByData('add-quiz-form-description-field').type('This quiz is about basics of Laravel.');
    cy.getByData('add-quiz-form-time-limit-field').type('15');
    cy.getByData('add-quiz-form-save-button').click();

    cy.contains('Basic Laravel');
    cy.contains('This quiz is about basics of Laravel.');

  })

  it('can be deleted', () => {
    cy.visit('/quizzes/create');

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
    cy.visit('/quizzes');
    cy.getByData('add-quiz-form-add-questions-button').first().click();
    cy.getByData('add-question-question-text-field').type('Test question');
    cy.getByData('add-question-points-text-field').type('5');

    cy.getByData('add-question-form-save-button').click();
  })

  it('question title can be edited', () => {
    cy.visit('/quizzes');

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
    cy.visit('/quizzes');
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

  it('question has add answers button', () => {
    cy.visit('/quizzes');
    cy.getByData('add-quiz-form-add-questions-button').first().click();
    cy.getByData('add-question-question-text-field').type('Test question');
    cy.getByData('add-question-points-text-field').type('5');

    cy.getByData('add-question-form-save-button').click();
    cy.getByData('edit-answers-button').should('exist');

  })

})