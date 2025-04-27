<div id="edit_book_modal" class="invisible">
    <form id="edit_book_form" class="modal_form flex_container">

        <h2>Edit Book</h2>

        <label for="edit_id">ID:</label>
        <input type="number" id="edit_id" name="id" class="readonly_input" readonly>

        <label for="edit_title">Title:</label>
        <input type="text" id="edit_title" name="title" required>

        <label for="edit_author">Author:</label>
        <select id="edit_author" name="author" required>
        </select>

        <label for="edit_year">Year:</label>
        <input type="number" id="edit_year" name="year" required>

        <label for="edit_genre">Genre:</label>
        <select id="edit_genre" name="genre" required>
        </select>

        <div class="modal_buttons_div flex_container">
            <button type="submit" id="edit_submit_button" class="buttonSubmit modal_button">Save Changes</button>
            <button type="button" id="edit_delete_button" class="buttonDelete modal_button">Delete Book</button>
            <button type="button" id="edit_abandon_button" class="buttonAbandon modal_button">Cancel</button>
        </div>

    </form>
</div>