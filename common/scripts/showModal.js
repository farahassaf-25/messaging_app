const showModal = (title, bodyContent = [], footerContent = [], closeButton = true) => {
  const modalContent = $(`<div class="modal-content">`);

  const headerContainer = $(`<div class="modal-header">`) //
    .append($(`<h5 class="modal-title">${title}</h5>`))
    .appendTo(modalContent);
  if (closeButton)
    headerContainer.append($(`<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">`));

  const bodyContainer = $(`<div class="modal-body">`);
  bodyContainer.append(...bodyContent).appendTo(modalContent);

  if (footerContent.length) {
    const footerContainer = $(`<div class="modal-footer">`);
    footerContainer.append(...footerContent).appendTo(modalContent);
  }

  return $(`<div class="modal" tabindex="-1">`) //
    .append($(`<div class="modal-dialog">`).append(modalContent))
    .on("bsc.modal.hidden", () => modal.remove())
    .appendTo($("body"))
    .modal("show");
};
