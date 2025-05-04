/// <reference types="cypress" />

// unikalny tytuł generowany raz na cały plik
const uniqueTitle = `CypressTest ${Date.now()}`;
const uniqueYear = "2025";
const uniqueAuthor = "George Orwell";
const uniqueGenre = "Mystery";

describe("Strona BooksPage", () => {
  //
  // 1) HEADER + SORTOWANIE
  //
  context("Nagłówki i sortowanie", () => {
    it("header i nawigacja działają poprawnie", () => {
      cy.visit("/index.php?page=books");
      cy.get("#header_logo_bar_id").click();
      cy.url().should("include", "page=adminHomepage");
      cy.visit("/index.php?page=books");
      cy.get("#Admin_page_p").click();
      cy.url().should("include", "page=adminHomepage");
      cy.visit("/index.php?page=books");
      cy.get("nav a").contains("Books").click();
      cy.url().should("include", "page=books");
      cy.get("nav a").contains("Authors").click();
      cy.url().should("include", "page=authors");
    });

    it("sortuje tabelę po wszystkich kolumnach (stubowane)", () => {
      const stub = [
        {
          id: 1,
          title: "AAA",
          year: 2020,
          genre: "X",
          author_name: "Anna",
          author_surname: "Nowak",
        },
        {
          id: 2,
          title: "BBB",
          year: 2019,
          genre: "Y",
          author_name: "Bartek",
          author_surname: "Kowalski",
        },
        {
          id: 3,
          title: "CCC",
          year: 2021,
          genre: "Z",
          author_name: "Celina",
          author_surname: "Wiśniewska",
        },
      ];
      cy.intercept("GET", "/api/books", { statusCode: 200, body: stub }).as(
        "getBooks"
      );
      cy.visit("/index.php?page=books");
      cy.wait("@getBooks");
      const cols = [
        {
          h: "title_headline",
          i: "title_sort_icon",
          idx: 0,
          asc: "AAA",
          desc: "CCC",
        },
        {
          h: "author_headline",
          i: "author_sort_icon",
          idx: 1,
          ascRegex: /^Anna\s+Nowak$/,
          descRegex: /^Celina\s+Wiśniewska$/,
        },
        {
          h: "year_headline",
          i: "year_sort_icon",
          idx: 2,
          asc: "2019",
          desc: "2021",
        },
        {
          h: "genre_headline",
          i: "genre_sort_icon",
          idx: 3,
          asc: "X",
          desc: "Z",
        },
        { h: "id_headline", i: "id_sort_icon", idx: 4, asc: "1", desc: "3" },
      ];
      cols.forEach((col) => {
        cy.get(`#${col.h}`).click();
        cy.get(`#${col.i}`).should("have.text", "▼");
        const first = cy.get("tbody tr").first().find("td").eq(col.idx);
        if (col.asc) first.should("contain", col.asc);
        else first.invoke("text").should("match", col.ascRegex);
        cy.get(`#${col.h}`).click();
        cy.get(`#${col.i}`).should("have.text", "▲");
        const firstD = cy.get("tbody tr").first().find("td").eq(col.idx);
        if (col.desc) firstD.should("contain", col.desc);
        else firstD.invoke("text").should("match", col.descRegex);
      });
    });
  });

  //
  // 2) DODAWANIE KSIĄŻKI
  //
  context("Dodawanie książki", () => {
    it("dodaje i pokazuje w tabeli", () => {
      cy.intercept("GET", "/api/books").as("getBooks");
      cy.intercept("GET", "/api/genres/get.php").as("getGenres");
      cy.intercept("POST", "/api/books/post.php").as("postBook");

      cy.visit("/index.php?page=books");
      cy.wait("@getBooks");

      cy.get("#table_button_add").click();
      cy.wait("@getGenres");
      cy.get("#add_book_modal").within(() => {
        cy.get('input[name="title"]').type(uniqueTitle);
        cy.get('input[name="year"]').type(uniqueYear);
        cy.get('select[name="genre"]').select(uniqueGenre);
        cy.get('select[name="author"]').select(uniqueAuthor);
        cy.get("button.buttonSubmit").click();
      });

      cy.wait("@postBook").its("response.statusCode").should("eq", 201);
      cy.wait("@getBooks");

      cy.get("tbody")
        .first()
        .should("contain", uniqueTitle)
        .and("contain", uniqueYear)
        .and("contain", uniqueAuthor.split(" ")[0])
        .and("contain", uniqueAuthor.split(" ")[1])
        .and("contain", uniqueGenre);
    });
  });

  //
  // 3) EDYCJA KSIĄŻKI
  //
  context("Edycja książki", () => {
    it("zmienia tytuł i rok oraz weryfikuje w tabeli", () => {
      const newTitle = `${uniqueTitle} EDITED`;
      const newYear = "2026";

      // dodajemy
      cy.intercept("GET", "/api/books").as("getBooks0");
      cy.intercept("GET", "/api/genres/get.php").as("getGenres0");
      cy.intercept("POST", "/api/books/post.php").as("postBook0");

      cy.visit("/index.php?page=books");
      cy.wait("@getBooks0");
      cy.get("#table_button_add").click();
      cy.wait("@getGenres0");
      cy.get("#add_book_modal").within(() => {
        cy.get('input[name="title"]').type(uniqueTitle);
        cy.get('input[name="year"]').type(uniqueYear);
        cy.get('select[name="genre"]').select(uniqueGenre);
        cy.get('select[name="author"]').select(uniqueAuthor);
        cy.get("button.buttonSubmit").click();
      });
      cy.wait("@postBook0");
      cy.wait("@getBooks0");

      // sortujemy i otwieramy modal edycji
      cy.get("#id_headline").click().click();
      cy.get("#id_sort_icon").should("have.text", "▲");
      cy.get("tbody tr").first().click();
      cy.wait("@getGenres0");

      // stub PUT + nowy GET z edytowanymi danymi
      cy.intercept("PUT", "/api/books/put.php", {
        statusCode: 200,
        body: {},
      }).as("putBook");
      cy.intercept("GET", "/api/books", {
        statusCode: 200,
        body: [
          {
            id: 9999,
            title: newTitle,
            year: Number(newYear),
            genre: uniqueGenre,
            author_name: uniqueAuthor.split(" ")[0],
            author_surname: uniqueAuthor.split(" ")[1],
          },
        ],
      }).as("getBooksAfterEdit");

      cy.get("#edit_book_modal").within(() => {
        cy.get('input[name="title"]').clear().type(newTitle);
        cy.get('input[name="year"]').clear().type(newYear);
        cy.get("button.buttonSubmit").click();
      });

      cy.wait("@putBook");
      cy.wait("@getBooksAfterEdit");

      cy.get("tbody tr")
        .first()
        .within(() => {
          cy.get("td").eq(0).should("contain", newTitle);
          cy.get("td").eq(2).should("contain", newYear);
        });
    });
  });

  //
  // 4) USUWANIE KSIĄŻKI
  //
  context("Usuwanie książki", () => {
    beforeEach(() => {
      // przygotowanie: dodajemy i otwieramy modal dla naszej książki
      cy.intercept("GET", "/api/books").as("getBooks1");
      cy.intercept("GET", "/api/genres/get.php").as("getGenres1");
      cy.intercept("POST", "/api/books/post.php").as("postBook1");

      cy.visit("/index.php?page=books");
      cy.wait("@getBooks1");
      cy.get("#table_button_add").click();
      cy.wait("@getGenres1");
      cy.get("#add_book_modal").within(() => {
        cy.get('input[name="title"]').type(uniqueTitle);
        cy.get('input[name="year"]').type(uniqueYear);
        cy.get('select[name="genre"]').select(uniqueGenre);
        cy.get('select[name="author"]').select(uniqueAuthor);
        cy.get("button.buttonSubmit").click();
      });
      cy.wait("@postBook1");
      cy.wait("@getBooks1");

      cy.get("#id_headline").click().click();
      cy.get("#id_sort_icon").should("have.text", "▲");
      cy.get("tbody tr").first().click();
      cy.wait("@getGenres1");
      cy.get("#edit_book_modal").should("be.visible");
    });

    it("anuluje usunięcie i modal oraz tabela pozostają bez zmian", () => {
      // klik Delete, ale w confirm zwracamy false
      cy.get("#edit_book_modal button.buttonDelete").click();
      cy.on("window:confirm", () => false);

      cy.get("#edit_book_modal").should("be.visible");
      cy.visit("/index.php?page=books");
      cy.wait("@getBooks1");
      cy.get("tbody").should("contain", uniqueTitle);
    });

    it("usuwa książkę po potwierdzeniu i weryfikuje, że zniknęła", () => {
      // intercept DELETE i pusty GET
      cy.intercept("DELETE", "/api/books/delete.php", {
        statusCode: 200,
        body: {},
      }).as("delBook");
      cy.intercept("GET", "/api/books", { statusCode: 200, body: [] }).as(
        "getBooksAfterDel"
      );

      cy.get("#edit_book_modal button.buttonDelete").click();
      cy.on("window:confirm", () => true);

      cy.wait("@delBook");
      cy.wait("@getBooksAfterDel");
      cy.get("tbody").should("not.contain", uniqueTitle);
    });
  });
});
