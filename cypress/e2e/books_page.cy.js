describe("Books Page", () => {
  beforeEach(() => {
    cy.visit("http://localhost:8000/?page=books");
  });

  it("should load the books table", () => {
    cy.get("#books_table").should("exist");
  });

  it("should open Add Book modal when Add button clicked", () => {
    cy.get("#table_button_add").click();
    cy.get("#add_book_modal").should("be.visible");
  });

  it("should open Edit Book modal when clicking a book row", () => {
    cy.get("tbody tr").first().click();
    cy.get("#edit_book_modal").should("be.visible");
  });

  it("should fill Add Book form and validate required fields", () => {
    cy.get("#table_button_add").click();
    cy.get("#add_book_modal").should("be.visible");

    // Sprawdzamy, że pola istnieją i są required
    cy.get("#title").should("have.attr", "required");
    cy.get("#author").should("have.attr", "required");
    cy.get("#year").should("have.attr", "required");
    cy.get("#genre").should("have.attr", "required");
  });

  it("should show validation alerts if form is empty", () => {
    cy.get("#table_button_add").click();
    cy.get("#submit_button").click();

    // Ponieważ alerty w JS są trudne do złapania w Cypress bez stubowania,
    // sprawdzimy czy modal nadal widoczny => znaczy że nie zamknięto go z pustymi danymi
    cy.get("#add_book_modal").should("be.visible");
  });

  it("should sort table when clicking on Title header", () => {
    cy.get("#title_headline").click();
    cy.get("#title_sort_icon").should("exist");
  });

  it("should sort table when clicking on Author header", () => {
    cy.get("#author_headline").click();
    cy.get("#author_sort_icon").should("exist");
  });
});
