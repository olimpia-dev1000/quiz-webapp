describe('Authentication', () => {

  beforeEach(() => {
    // Clear cookies and local storage between tests
    cy.clearCookies()
    cy.clearLocalStorage()
  })


  describe('Registration', () => {
    const testUser = {
      name: 'Test User',
      email: `test${Math.random()}@example.com`,
      password: 'password123',
      password_confirmation: 'password123'
    }

    it('should allow a user to register', () => {
      cy.visit('http://localhost:8000/register')

      // Fill in registration form
      cy.get('input#name').type(testUser.name)
      cy.get('input#email').type(testUser.email)
      cy.get('input#password').type(testUser.password)
      cy.get('input#password_confirmation').type(testUser.password_confirmation)

      // Submit form
      cy.get('button[type="submit"]').contains('Register').click()

      // Assert successful registration
      cy.url().should('include', '/dashboard')
      cy.contains('Dashboard').should('be.visible')
    })

    it('should show validation errors for invalid registration', () => {
      cy.visit('http://localhost:8000/register')

      // Submit empty form
      cy.get('button[type="submit"]').contains('Register').click()

      // Check if form is invalid
      cy.get('input#name').then($input => {
        expect($input[0].validationMessage).to.not.be.empty
      })

      cy.get('input#name').type('a')

      // Submit form with filled in name
      cy.get('button[type="submit"]').contains('Register').click()

      cy.get('input#email').then($input => {
        expect($input[0].validationMessage).to.not.be.empty
      })

      cy.get('input#email').type('test@gmail.com')

      // Submit form with filled in name and meail
      cy.get('button[type="submit"]').contains('Register').click()

      cy.get('input#password').then($input => {
        expect($input[0].validationMessage).to.not.be.empty
      })

      cy.get('input#password').type('test123')

      // Submit form with filled in name, email and password
      cy.get('button[type="submit"]').contains('Register').click()

      cy.get('input#password_confirmation').then($input => {
        expect($input[0].validationMessage).to.not.be.empty
      })

      cy.get('input#password_confirmation').type('test123')


      // Submit form with filled in name, email and password confirmation
      cy.get('button[type="submit"]').contains('Register').click()

      cy.get('input#password').then($input => {
        expect($input[0].validationMessage).to.not.be.empty
      })

    })

  })

  describe('Login', () => {

    const testUser = {
      name: 'Test User',
      email: `test${Math.random()}@example.com`,
      password: 'password123',
      password_confirmation: 'password123'
    }

    // beforeEach(() => {

    // TO-DO !!! //
    // Create test user via API/database before running login tests
    // cy.createUser({
    //   email: 'test@example.com',
    //   password: 'password123'
    // })

    // Temporarily

    // const testUser = {
    //   name: 'Test User',
    //   email: `test${Math.random()}@example.com`,
    //   password: 'password123',
    //   password_confirmation: 'password123'
    // }

    it('should allow a user to register', () => {
      cy.visit('http://localhost:8000/register')

      // Fill in registration form
      cy.get('input#name').type(testUser.name)
      cy.get('input#email').type(testUser.email)
      cy.get('input#password').type(testUser.password)
      cy.get('input#password_confirmation').type(testUser.password_confirmation)

      // Submit form
      cy.get('button[type="submit"]').contains('Register').click()


      // Log out
      cy.get('button').contains(testUser.name).click(); // Ensure this opens the dropdown

      cy.get('a').contains("Log Out").click()
    })


    it('should allow user to login with correct credentials', () => {
      cy.visit('http://localhost:8000/login')

      // Fill in login form
      cy.get('input#email').type(testUser.email)
      cy.get('input#password').type('password123')

      // Submit form
      cy.get('button[type="submit"]').contains('Log in').click()

      // Assert successful login
      cy.url().should('include', '/dashboard')
      cy.contains('Dashboard').should('be.visible')
    })

    it('should show error for invalid credentials', () => {
      cy.visit('http://localhost:8000/login')

      // Fill in wrong credentials
      cy.get('input#email').type('test@example.com')
      cy.get('input#password').type('wrongpassword')

      cy.get('button[type="submit"]').contains('Log in').click()

      // Assert error message
      cy.contains('These credentials do not match our records')
    })
    // })
  })

  describe('Password Reset', () => {

    // TO-DO 

    // it('should allow user to request password reset', () => {
    //   cy.visit('http://localhost:8000/forgot-password')

    //   // Submit email for password reset
    //   cy.get('input#email').type('test@example.com')
    //   cy.get('button').contains('Email Password Reset Link').click()

    //   // Assert success message
    //   cy.contains('We have emailed your password reset link.')
    // })

    it('should show error for non-existent email', () => {
      cy.visit('http://localhost:8000/forgot-password')

      // Submit non-existent email
      cy.get('input#email').type('nonexistent@example.com')
      cy.get('button').contains('Email Password Reset Link').click()

      // Assert error message
      cy.contains('We can\'t find a user with that email address')
    })
  })

  // TO-DO

  // describe('Logout', () => {
  //   beforeEach(() => {
  //     // Login before testing logout
  //     cy.login('test@example.com', 'password123')
  //   })

  //   it('should allow user to logout', () => {
  //     cy.visit('/dashboard')

  //     // Click logout button/link
  //     cy.get('[data-cy=logout-button]').click()

  //     // Assert successful logout
  //     cy.url().should('include', '/login')

  //     // Verify can't access protected route
  //     cy.visit('/dashboard')
  //     cy.url().should('include', '/login')
  //   })
  // })
})