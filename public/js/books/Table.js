import { BookExample } from "./BookExample.js";

export class Table {
  constructor(tableId) {
    this.table = document.getElementById(tableId);
    this.tbody = this.table.querySelector("tbody");
    this.books = [];
    this.sortOptions = ["az", "za"];
    this.sortStatus = null;
  }

  async loadData() {
    const res = await fetch("/api/books");
    const data = await res.json();

    this.books = data.map((book) => new BookExample(book));
  }

  render() {
    this.tbody.innerHTML = "";
    this.books.forEach((book) => {
      const row = book.renderRow();
      this.tbody.appendChild(row);
    });
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
  }
}
