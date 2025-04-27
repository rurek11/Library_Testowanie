export class BookExample {
  constructor(data) {
    this.data = data;
  }

  renderRow() {
    const tr = document.createElement("tr");
    tr.dataset.id = this.data.id;

    const columns = ["title", "year", "genre", "id"];
    columns.forEach((col) => {
      const td = document.createElement("td");
      td.textContent = this.data[col];
      tr.appendChild(td);
    });

    const author = document.createElement("td");
    author.textContent = `${this.data.author_name}  ${this.data.author_surname}`;
    tr.insertBefore(author, tr.children[1]);
    return tr;
  }
}
