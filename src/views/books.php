<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books page</title>
    <link rel="stylesheet" href="/css/styles.css?v=1">
</head>

<body>
    <?php include __DIR__ . '/partials/header.php'; ?>

    <div id="modal_add_book" class="invisible"></div>

    <main class="container_padding">
        <div id="books_table_header_bar">
            <h2 class="display_inline table_header">BOOKS</h2>
            <span id="table_mode_name" class="margin_right_table_bar_mode">VIEW MODE</span>
            <button id="table_button_add" class="margin_right_table_bar table_header_button">Add Book</button>
            <button id="table_button_edit" class="margin_right_table_bar table_header_button">Edit</button>
            <button id="table_button_stop" class="margin_right_table_bar table_header_button invisible">Stop</button>
        </div>
        <div class="table_wrapper">
            <table id="books_table">
                <thead>
                    <tr>
                        <th id="title_headline" class="pointer">
                            <span>Title</span>
                            <p id="title_sort_icon" class="display_inline"></p>
                        </th>
                        <th id="author_headline" class="pointer">
                            <span>Author</span>
                            <p id="author_sort_icon" class="display_inline"></p>
                        </th>
                        <th id="year_headline" class="pointer">
                            <span>Year</span>
                            <p id="year_sort_icon" class="display_inline"></p>
                        </th>
                        <th id="genre_headline" class="pointer">
                            <span>Genre</span>
                            <p id="genre_sort_icon" class="display_inline"></p>
                        </th>
                        <th id="id_headline" class="pointer">
                            <span>Id</span>
                            <p id="id_sort_icon" class="display_inline"></p>
                        </th>
                    </tr>
                </thead>

                <tbody id="table_body">
                </tbody>

                <tfoot>
                </tfoot>

            </table>
        </div>

    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script type="module" src="/js/books/main.js"></script>
</body>

</html>