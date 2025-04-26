import {
  table_buttons,
  table_sort_icons,
  table_mode_name,
  books_table_header_bar,
  table_headlines,
} from "./selectors.js";

import { symbolDown, symbolUp, cleanSymbol } from "./utils.js";

let tableReference = null;

export function initTableEvents(table) {
  tableReference = table;
  const headlines = {
    title_headline: {
      field: "title",
      icon: table_sort_icons.title_sort_icon,
    },
    author_headline: {
      field: "author",
      icon: table_sort_icons.author_sort_icon,
    },
    year_headline: {
      field: "year",
      icon: table_sort_icons.year_sort_icon,
    },
    genre_headline: {
      field: "genre",
      icon: table_sort_icons.genre_sort_icon,
    },
    id_headline: {
      field: "id",
      icon: table_sort_icons.id_sort_icon,
    },
  };

  Object.entries(headlines).forEach(([headline, { field, icon }]) => {
    table_headlines[headline].addEventListener("click", () => {
      Object.entries(headlines).forEach(([_, { icon }]) => {
        cleanSymbol(icon);
      });
      const direction = tableReference.sortStatus === "az" ? "za" : "az";

      tableReference.sortBy(field, direction);

      if (direction === "az") {
        symbolDown(icon);
      } else {
        symbolUp(icon);
      }

      tableReference.render();
    });
  });

  // table_headlines.title_headline.addEventListener("click", () => {
  //   const direction = tableReference.sortStatus === "az" ? "za" : "az";

  //   tableReference.sortBy("title", direction);

  //   if (direction === "az") {
  //     symbolDown(headerElement);
  //   } else {
  //     symbolUp(headerElement);
  //   }

  //   tableReference.render();
  // });
}
