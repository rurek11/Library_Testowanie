import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    // to musi wskazywać Twój serwer z Docker-a
    baseUrl: "http://localhost:8000",
    specPattern: "cypress/e2e/**/*.cy.js",
    supportFile: "cypress/support/e2e.js",
    // jeżeli masz niestandardowe time-outy:
    // defaultCommandTimeout: 8000,
  },
});
