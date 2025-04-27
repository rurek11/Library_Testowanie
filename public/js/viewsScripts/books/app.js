import { Table } from "./Table.js";
import { initTableEvents } from "./events.js";
import { AddBookModal } from "../../modals/booksModals/AddBookModal.js";
import { EditBookModal } from "../../modals/booksModals/EditBookModal.js";

const editModal = new EditBookModal("edit_book_modal");

const table = new Table("books_table", editModal);

editModal.table = table;

const modal = new AddBookModal("add_book_modal", table);

table.loadData().then(() => {
  table.render();
  initTableEvents(table, modal);
});
