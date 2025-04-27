export async function getBooks() {
  const res = await fetch("/api/books");
  const data = await res.json();
  return data;
}

export async function addBook(bookData) {
  const res = await fetch("/api/books/post.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(bookData),
  });

  if (!res.ok) {
    throw new Error("Failed to add book");
  }

  return res.json();
}

export async function updateBook(bookData) {
  const res = await fetch("/api/books/put.php", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(bookData),
  });

  if (!res.ok) {
    throw new Error("Failed to update book");
  }

  return res.json();
}

export async function deleteBook(bookId) {
  const res = await fetch("/api/books/delete.php", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: bookId }),
  });

  if (!res.ok) {
    throw new Error("Failed to delete book");
  }

  return res.json();
}
