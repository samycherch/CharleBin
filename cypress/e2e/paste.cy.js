describe('Test fonctionnel CharleBin - Finalisation TD6', () => {
  it('doit créer un secret, charger l\'URL et vérifier le contenu', () => {
    const messageContent = 'Validation TD6 Final';
    const motDePasse = 'Chut123';

    cy.visit('http://localhost:8080'); 
    cy.get('#message').type(messageContent, { force: true });
    cy.get('#passwordinput').type(motDePasse);
    cy.get('#sendbutton').click();

    cy.get('#pastesuccess', { timeout: 15000 }).should('be.visible');
    cy.get('#pastelink a').first().then(($a) => {
      const urlGeneree = $a.attr('href');
      
      cy.visit(urlGeneree);
      
      cy.get('#passwordmodal').invoke('addClass', 'in').invoke('show'); 
      cy.get('#passworddecrypt').should('be.visible').type(motDePasse);
      cy.get('#passwordform').submit(); 
      
      cy.get('article', { timeout: 20000 })
        .should(($article) => {
          const contenuNettoye = $article.text().replace(/\s+/g, ' ');
          expect(contenuNettoye).to.include(messageContent);
        });
    });
  });
});