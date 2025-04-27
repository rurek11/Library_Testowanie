const table_headlines_id = [
  "title_headline",
  "author_headline",
  "year_headline",
  "genre_headline",
  "id_headline",
];
const table_headlines = {};
table_headlines_id.forEach((id) => {
  table_headlines[id] = document.getElementById(id);
});

const table_sort_icons_id = [
  "title_sort_icon",
  "author_sort_icon",
  "year_sort_icon",
  "genre_sort_icon",
  "id_sort_icon",
];
const table_sort_icons = {};
table_sort_icons_id.forEach((id) => {
  table_sort_icons[id] = document.getElementById(id);
});

const table_buttons_id = [
  "table_button_add",
  // "table_button_edit",
  // "table_button_stop",
];
const table_buttons = {};
table_buttons_id.forEach((id) => {
  table_buttons[id] = document.getElementById(id);
});

const table_mode_name = document.getElementById("table_mode_name");

const books_table_header_bar = document.getElementById(
  "books_table_header_bar"
);

export {
  table_buttons,
  table_sort_icons,
  table_mode_name,
  books_table_header_bar,
  table_headlines,
};
