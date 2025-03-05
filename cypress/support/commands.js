// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

// Cypress.Commands.add('createUserWithFactory', (attributes = {}) => {

//     return cy.exec('php artisan tinker --execute="$user = App\\\\Models\\\\User::factory()->create([\\\"name\\\" => \\\"Test User\\\", \\\"email\\\" => \\\"test@example.com\\\", \\\"password\\\" => \\\"password\\\"]); echo json_encode($user);"').then((result) => {
//         try {
//             const userData = JSON.parse(result.stdout);
//             return userData;
//         } catch (error) {
//             console.error('Tinker output:', result.stdout);
//             throw new Error('Failed to parse user data from command output');
//         }
//     });
// });

Cypress.Commands.add('login', (email, password) => {
    cy.visit("http://localhost:8000/login");

    cy.get('input[name="email"]').type(email);
    cy.get('input[name="password"]').type(password);
    cy.get('button[type="submit"]').click();

    cy.url().should("not.include", "/login");
});


Cypress.Commands.add('getByData', (selector) => {
    return cy.get(`[data-test=${selector}]`)
});