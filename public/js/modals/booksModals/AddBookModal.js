export class AddBookModal {
  constructor(modalId) {
    this.modal = document.getElementById(modalId);
  }

  open() {
    this.modal.classList.remove("invisible");
    this.modal.classList.add("visible");
  }

  close() {
    this.modal.classList.remove("visible");
    this.modal.classList.add("invisible");
  }
}
