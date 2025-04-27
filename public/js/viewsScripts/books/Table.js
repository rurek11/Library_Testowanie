import { BookExample } from "./BookExample.js";
import { getBooks } from "../../api/books_api.js";

export class Table {
  constructor(tableId, editModal) {
    this.table = document.getElementById(tableId);
    this.tbody = this.table.querySelector("tbody");
    this.editModal = editModal;
    this.books = [];
    this.sortOptions = ["az", "za"];
    this.sortStatus = null;
    this.currentSortField = null;
  }

  async loadData() {
    const data = await getBooks();
    this.books = data.map((book) => new BookExample(book));
  }

  render() {
    this.tbody.innerHTML = "";
    this.books.forEach((book) => {
      const row = book.renderRow();
      this.tbody.appendChild(row);
      row.addEventListener("click", () => {
        this.handleRowClick(book);
      });
    });
  }

  handleRowClick(book) {
    this.editModal.open(book);
  }

  sortBy(field, type) {
    this.books.sort((a, b) => {
      let aValue =
        field === "author"
          ? a.data.author_name + a.data.author_surname
          : a.data[field];
      let bValue =
        field === "author"
          ? b.data.author_name + b.data.author_surname
          : b.data[field];
      if (aValue < bValue) return type === "az" ? -1 : 1;
      if (aValue > bValue) return type === "az" ? 1 : -1;
    });
    this.sortStatus = type;
    this.currentSortField = field;
  }
}
