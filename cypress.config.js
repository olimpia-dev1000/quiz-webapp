import { defineConfig } from "cypress";
import { exec } from "child_process";

export default defineConfig({
  e2e: {
    baseUrl: 'http://localhost:9001',

    setupNodeEvents(on, config) {
      on("task", {
        createTestUser({ name, email, password }) {
          return new Promise((resolve, reject) => {
            exec(
              `TEST_USER_NAME="${name}" TEST_USER_EMAIL="${email}" TEST_USER_PASSWORD="${password}" php artisan db:seed --class=TestUserSeeder --env=cypress`,
              (error, stdout, stderr) => {
                if (error) {
                  console.error("Error creating test user:", stderr);
                  return reject(error);
                }
                resolve(stdout ? stdout.trim() : null);
              }
            );
          });
        },

        createQuiz({ email, questionsCount, hasAnswers }) {
          return new Promise((resolve, reject) => {
            exec(
              `TEST_USER_EMAIL="${email}" TEST_QUESTIONS_COUNT=${questionsCount} TEST_HAS_ANSWERS=${hasAnswers} php artisan db:seed --class=TestQuizSeeder --env=cypress`,
              (error, stdout, stderr) => {
                if (error) {
                  console.error("Error creating quiz:", stderr);
                  return reject(error);
                }
                resolve(stdout ? stdout.trim() : null);
              }
            );
          });
        },


        resetDatabase() {
          return new Promise((resolve, reject) => {
            exec(
              'php artisan migrate:fresh --seed --env=cypress',
              (error, stdout, stderr) => {
                if (error) {
                  console.error("Error resetting database:", stderr);
                  return reject(error);
                }
                resolve(stdout ? stdout.trim() : null);
              }
            );
          });
        }


      });
    },
  },
});
