const moreDetailsButton = (moreDetails) => {
  return $("<button>")
    .text("More details")
    .on("click", () => {
      const modal = $(`
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-header">
              <h1 class="modal-title fs-5">More details</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content">
              ${moreDetails}
            </div>
          </div>
        </div>
      `);
      $("body").append(modal);
      new bootstrap.Modal(modal[0]).show();
      modal.on("hidden.bs.modal", modal.remove);
    });
};

/** Generate a new alert using bootstrap+jquery
 * @param {string} content the alert message
 * @param {string} type "success", "info", "warning", "danger" ....
 * @param {boolean} isDismissable whether it has a dismiss (X) button
 * @param {number} autoDismissMS dismiss this alert automatically after this many milliseconds
 * @param {string} moreDetails HTML to be shown in a big modal
 * @param  {...HTMLElement} extraElements HTML elements to be added after the alert (like buttons)
 */
const appendAlert = (
  content,
  type = "warning",
  isDismissable = true,
  autoDismissMS = 0,
  moreDetails = null,
  ...extraElements
) => {
  const placeholderID = "#liveAlertPlaceholder";
  let placeholder = $(placeholderID);

  // create+add if missing
  if (placeholder.length === 0) {
    const placeholderDiv = $("<div>").attr("id", "liveAlertPlaceholder");
    $("body").append(placeholderDiv);
    placeholder = $(placeholderID);
  }

  const alertDiv = $("<div>") //
    .attr("role", "alert")
    .addClass("alert")
    .addClass(`alert-${type}`);

  //? try to add the content as clean html
  try {
    const contentClean = $(content);
    if (contentClean.length === 0 || contentClean[0].nodeType === Node.TEXT_NODE) {
      throw new Error("Fall back to text");
    }
    contentClean.find("*").each((_, e) => {
      const $e = $(e);
      if (e.tagName.toLowerCase() === "script") return $e.remove();

      $.each(e.attributes, (_, attr) => {
        if (
          attr.name.startsWith("on") ||
          (["href", "src", "xlink:href"].includes(attr.name) && attr.value.startsWith("javascript:"))
        ) {
          $e.removeAttr(attr.name);
        }
      });
    });
    alertDiv.html(contentClean);
  } catch {
    //? fall back to plain text
    alertDiv.text(content);
  }

  if (isDismissable) {
    alertDiv.addClass("alert-dismissible");

    const closeButton = $("<button>") //
      .addClass("btn-close")
      .attr("type", "button")
      .attr("data-bs-dismiss", "alert")
      .attr("aria-label", "Close Alert")
      .on("click", () => wrapper.remove());
    alertDiv.append(closeButton);
  }

  const wrapper = $("<div>");
  wrapper.append(alertDiv);
  placeholder.append(wrapper);

  if (moreDetails) {
    wrapper.append(moreDetailsButton(moreDetails)).append("<br/>");
  }

  for (const button of extraElements) wrapper.append(button);
  if (autoDismissMS > 0) setTimeout(() => wrapper.remove(), autoDismissMS);
};