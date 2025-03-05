Cypress.Commands.add("createTestUser", (user) => {
    return cy.task("createTestUser", user);
});

Cypress.Commands.add("createQuiz", (email, questionsCount = 5, hasAnswers = false) => {
    return cy.task("createQuiz", { email, questionsCount, hasAnswers });
});

// .then(() => {
//     cy.login(user.email, user.password);
// });