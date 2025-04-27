<div id="add_book_modal" class="invisible">
    <form id="add_book_form" class="modal_form flex_container">

        <h2>Add a New Book</h2>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <select id="author" name="author" required>
        </select>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required>

        <label for="genre">Genre:</label>
        <select id="genre" name="genre" required>
        </select>

        <div class="modal_buttons_div flex_container">
            <button type="submit" id="submit_button" class="buttonSubmit modal_button">Submit</button>
            <button type="button" id="abandon_button" class="buttonAbandon modal_button">Abandon</button>
        </div>

    </form>
</div>