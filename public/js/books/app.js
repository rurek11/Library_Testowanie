import { Table } from "./Table.js";
import { initTableEvents } from "./events.js";

const table = new Table("books_table");

table.loadData().then(() => {
  table.render();
  initTableEvents(table);
});
