const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      // auditeur d'événements
    },
    supportFile: false, // Désactive le fichier support si vous n'en avez pas besoin
    experimentalStudio: true
  },
});