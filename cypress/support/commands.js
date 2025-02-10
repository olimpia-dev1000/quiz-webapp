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

Cypress.Commands.add('createUser', (user) => {
    // Create user via API or database
    cy.request({
        method: 'POST',
        url: 'http://localhost:8000/api/cypress/create-user', // You'll need to create this endpoint
        body: user,
        failOnStatusCode: false
    })
})

Cypress.Commands.add('login', (email, password) => {
    cy.session([email, password], () => {
        cy.request({
            method: 'POST',
            url: 'http:/localhost:8000/login',
            body: { email, password },
            failOnStatusCode: false
        }).then((response) => {
            // Handle CSRF token if needed
            cy.visit('http:/localhost:8000/')
        })
    })
})