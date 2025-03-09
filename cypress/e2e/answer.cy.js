describe('Viewing Answers', () => {

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

    it('can be added using the input field', () => {
        cy.visit('/quizzes');

        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('add-question-question-text-field').type('Some test question');
        cy.getByData('add-question-points-text-field').type('1');
        cy.getByData('add-question-multiple-choice-radio').click();

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
        cy.visit('/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('edit-answers-button').first().click();

        cy.getByData('add-answer-answer-delete-button').first().click();

        cy.on('window:confirm', (confirmText) => {
            expect(confirmText).to.equal('Are you sure you want to delete this answer?');
            return true;
        });

    })

    it('can be updated', () => {
        cy.visit('/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').first().click();
        cy.getByData('edit-answers-button').first().click();

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

    it('only 4 answers can be added per question', () => {
        cy.visit('/quizzes');
        cy.getByData('add-quiz-link').click();

        cy.getByData('add-quiz-form-title-field').type('Basic Laravel');
        cy.getByData('add-quiz-form-description-field').type('This quiz is about basics of Laravel.');
        cy.getByData('add-quiz-form-time-limit-field').type('15');
        cy.getByData('add-quiz-form-save-button').click();

        cy.contains('Basic Laravel');

        cy.contains('Basic Laravel')
            .parents('.relative.flex.flex-col') // Navigate to the quiz container
            .find('[data-test="add-quiz-form-add-questions-button"]')
            .click();

        cy.getByData('add-question-question-text-field').type('Some test question');
        cy.getByData('add-question-points-text-field').type('1');
        cy.getByData('add-question-multiple-choice-radio').click();

        cy.getByData('add-question-form-save-button').click();

        cy.get('input#question_text')
            .filter('[value="Some test question"]')
            .first()
            .should('have.value', 'Some test question').closest('.grid').find('a[data-test="edit-answers-button"]')
            .click();


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


    it('only 1 answer can be correct', () => {
        cy.visit('/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').eq(1).click();
        cy.getByData('edit-answers-button').first().click();

        // Find all checkboxes
        cy.getByData('edit-answer-is-correct-checkbox').then(($checkboxes) => {
            let checkedIndex = -1;

            // Find the index of the checked checkbox
            $checkboxes.each((index, checkbox) => {
                if (Cypress.$(checkbox).prop('checked')) {
                    checkedIndex = index;
                }
            });

            if (checkedIndex !== -1) {
                // If a checkbox is checked, ensure others are disabled
                cy.getByData('edit-answer-is-correct-checkbox').each(($el, idx) => {
                    if (idx !== checkedIndex) {
                        cy.wrap($el).should('be.disabled');
                    }
                });
            }
        });
    });


    it.only('if its question is of type true false text can not be edited or deleted', () => {
        cy.visit('/quizzes');
        cy.getByData('add-quiz-form-add-questions-button').eq(0).click();

        cy.getByData('edit-question-true-false-radio').first().click();

        cy.getByData('edit-answers-button').first().click();

        cy.getByData('edit-answer-answer-text-field').each(($el, idx) => {
            cy.wrap($el).should('be.disabled');
        });

        cy.getByData('add-answer-answer-delete-button').each(($el, idx) => {
            cy.wrap($el).should('be.disabled');
        });


    });

})


// TODO: next question arrows

// TODO: proper handling of error message

// TODO: can edit text with editing checbox

// TODO: when you want change type of question confirmation screen will appear
