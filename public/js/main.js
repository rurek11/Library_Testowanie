const logo = document.getElementById("header_logo_bar_id");
const admin_button = document.getElementById("Admin_page_p");

logo.addEventListener("click", go_homepage);
admin_button.addEventListener("click", go_homepage);

function go_homepage() {
  location.href = "/index.php?page=admin_homepage";
}
