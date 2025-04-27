import http from "k6/http";
import { check, group, sleep } from "k6";

export default function () {
  group("Books Page", () => {
    const res = http.get("http://localhost:8000/?page=books");
    check(res, {
      "Books page - status 200": (r) => r.status === 200,
      "Books page - contains BOOKS": (r) => r.body.includes("BOOKS"),
    });
  });

  group("GET /api/books", () => {
    const res = http.get("http://localhost:8000/api/books");
    check(res, {
      "Books API - status 200": (r) => r.status === 200,
      "Books API - is JSON": (r) =>
        r.headers["Content-Type"].includes("application/json"),
    });
  });

  group("GET /api/genres/get.php", () => {
    const res = http.get("http://localhost:8000/api/genres/get.php");
    check(res, {
      "Genres API - status 200": (r) => r.status === 200,
      "Genres API - is JSON": (r) =>
        r.headers["Content-Type"].includes("application/json"),
    });
  });

  group("GET /api/authors/get.php", () => {
    const res = http.get("http://localhost:8000/api/authors/get.php");
    check(res, {
      "Authors API - status 200": (r) => r.status === 200,
      "Authors API - is JSON": (r) =>
        r.headers["Content-Type"].includes("application/json"),
    });
  });

  group("POST /api/books/post.php - create book", () => {
    const payload = JSON.stringify({
      title: "K6 Test Book",
      author_id: 1,
      year: 2024,
      genre_id: 1,
    });

    const headers = { "Content-Type": "application/json" };
    const res = http.post("http://localhost:8000/api/books/post.php", payload, {
      headers,
    });

    check(res, {
      "Book created - status 201": (r) => r.status === 201,
      "Book created - message OK": (r) =>
        JSON.parse(r.body).message === "Book added successfully",
    });

    // Zapamiętaj ID nowo dodanej książki
    const createdBook = JSON.parse(res.body);
    sleep(1); // mała przerwa żeby baza zdążyła się zaktualizować

    group("Update the created book", () => {
      const booksRes = http.get("http://localhost:8000/api/books");
      const books = JSON.parse(booksRes.body);
      const addedBook = books.find((b) => b.title === "K6 Test Book");

      if (addedBook) {
        const updatePayload = JSON.stringify({
          id: addedBook.id,
          title: "K6 Test Book (Updated)",
          author_id: 1,
          year: 2025,
          genre_id: 1,
        });

        const updateRes = http.put(
          "http://localhost:8000/api/books/put.php",
          updatePayload,
          { headers }
        );

        check(updateRes, {
          "Book updated - status 200": (r) => r.status === 200,
          "Book updated - message OK": (r) =>
            JSON.parse(r.body).message === "Book updated successfully",
        });
      } else {
        console.error("Book not found for update.");
      }
    });

    group("Delete the created book", () => {
      const booksRes = http.get("http://localhost:8000/api/books");
      const books = JSON.parse(booksRes.body);
      const addedBook = books.find((b) => b.title === "K6 Test Book (Updated)");

      if (addedBook) {
        const deletePayload = JSON.stringify({ id: addedBook.id });
        const deleteRes = http.del(
          "http://localhost:8000/api/books/delete.php",
          deletePayload,
          { headers }
        );

        check(deleteRes, {
          "Book deleted - status 200": (r) => r.status === 200,
          "Book deleted - message OK": (r) =>
            JSON.parse(r.body).message === "Book deleted successfully",
        });
      } else {
        console.error("Book not found for delete.");
      }
    });
  });
}
