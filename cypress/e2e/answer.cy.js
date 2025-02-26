describe('Viewing Answers', () => {

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

    it('can be added using the input field', () => {
        cy.visit('http://localhost:8000/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('add-question-question-text-field').type('Some test question');
        cy.getByData('add-question-points-text-field').type('1');

        cy.getByData('add-question-form-save-button').click();

        cy.get('input#question_text')
            .filter('[value="Some test question"]')
            .first()
            .should('have.value', 'Some test question').closest('.grid').find('a[data-test="edit-answers-button"]')
            .click();

        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();

        cy.getByData('edit-answer-answer-text-field')
            .first()
            .should('have.value', 'Some answer');

    })

    it('can be deleted', () => {
        cy.visit('http://localhost:8000/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('edit-answers-button').first().click();
        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();
        cy.getByData('add-answer-answer-delete-button').first().click();

        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

    })

    it('can be updated', () => {
        cy.visit('http://localhost:8000/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('edit-answers-button').first().click();
        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();


        cy.getByData('edit-answer-answer-text-field').first()
            .clear()
            .type('Changed question')
            .blur(); // Ensures input field update

        cy.getByData('edit-answer-answer-text-field')
            .first()
            .should('have.value', 'Changed question');

        cy.getByData('add-answer-answer-delete-button').first().click();

        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });
    })

    it.only('only 4 answers can be added per question', () => {
        cy.visit('http://localhost:8000/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('edit-answers-button').first().click();

        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();

        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();

        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();

        cy.getByData('add-answer-answer-text-field').type('Some answer');
        cy.getByData('add-answer-answer-submit-button').click();

        cy.contains('All answers added!');

        cy.getByData('add-answer-answer-delete-button').first().click();
        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

        cy.getByData('add-answer-answer-delete-button').first().click();
        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

        cy.getByData('add-answer-answer-delete-button').first().click();
        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

        cy.getByData('add-answer-answer-delete-button').first().click();
        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

    })

    // TODO: only one answer is correct

    // TODO: next question arrows

    // TODO: proper handling of error message 
})