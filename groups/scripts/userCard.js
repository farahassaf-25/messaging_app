const userCardBadge = (faIcon, label) =>
  $("<div>") //
    .addClass("badge")
    .append(
      $("<div>").append($("<i>").addClass(`fa-solid ${faIcon}`)), //
      $("<div>").addClass("label").text(` ${label}`)
    );

/**
 * Member card element
 * @param {object} user
 * @param {(ev: Event) => {}} onSelectChanged
 * @param {boolean} selected auto select (only if onSelectChanged is provided)
 * @param {...HTMLElement} overlayed HTML elements to be added on top of the card (on hover)
 * @returns {HTMLDivElement} The generated <div> element
 */
function userCard(
  user, //
  onSelectChanged = undefined,
  selected = false,
  overlayBackground = "#fff8",
  ...overlayed
) {
  const div = $("<div>") //
    .addClass("userCard")
    .addClass(`userCard_${user.id}`);

  if (onSelectChanged instanceof Function) {
    // const idEmail = email.replace(/[^a-zA-Z0-9]/g, "_");
    const input = $("<input>") //
      .attr("type", "checkbox")
      .attr("id", `userCheck_${user.id}`)
      .on("change", (ev) => {
        onSelectChanged(user.id, ev.target.checked);
      });

    div
      .on("click", () => {
        const newState = !!!input.attr("checked");
        input.attr("checked", newState);
        onSelectChanged(user.id, newState);
        div[(newState ? "add" : "remove") + "Class"]("selected");
      })
      .append(input);

    //? before setting events
    if (selected) {
      input.attr("checked", true);
      div.addClass("selected");
    }
  }

  $("<img>") //
    .attr("src", user.imageURL || "../assets/defaultProfile.webp")
    .attr("class", "pfp")
    .appendTo(div);

  $("<div>") //
    .addClass("userInfo")
    .append($("<div>").addClass("name").text(user.name))
    .append($("<div>").addClass("email").text(user.email))
    .appendTo(div);

  const badges = $("<div>") //
    .addClass("badges")
    .appendTo(div);

  if (user.isMe) {
    userCardBadge("fa-user", "You").appendTo(badges);
  }
  const adminIcon = userCardBadge("fa-shield", "Admin")
    .css("display", user.isGroupAdmin ? "" : "none")
    .appendTo(badges);

  div.setIsGroupAdmin = (isGroupAdmin) => {
    adminIcon.css("display", isGroupAdmin ? "" : "none");
  };
  div.addOverlay = (overlayed) => {
    const overlay = $("<div>")
      .addClass("overlay")
      .append(...overlayed);

    const wrapper = $("<div>").addClass("overlayWrapper"); //? why a wrapper? => move overlay while blur is stays filling the parent
    if (typeof overlayBackground === "string") {
      wrapper.css("background", overlayBackground);
    } else {
      wrapper.addClass("blur");
    }
    wrapper.append(overlay).appendTo(div);
  };

  if (overlayed.length) div.addOverlay(overlayed);

  return div;
}
