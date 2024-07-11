/**
 * @param {string?} title
 * @param {boolean} withSearch
 * @param {string} id
 * @param {(user)=>JQuery<HTMLElement>} userCardFactory
 * @param  {...User} users
 * @returns {JQuery<HTMLElement>} usersContainer or a wrapper if `withSearch`
 */
const usersContainer = (
  title = null, //
  id = `usersContainer_${Math.random().toString(36)}`,
  userCardFactory = null,
  ...users
) => {
  const wrapper = $("<div>").addClass("usersContainerWrapper");
  const container = $("<div>") //
    .attr("id", id)
    .addClass("usersContainer");

  const noMembers = $("<p>") //
    .addClass("noMembers")
    .text("No members found")
    .css({ display: "none", textAlign: "center" });

  const input = $("<input>") //
    .attr("id", "searchMembers")
    .attr("placeholder", title || "Search")
    .on("input", (ev) => {
      const query = ev.target.value.toLowerCase().trim();
      let count = 0;
      container.find(`.userCard`).each((_, card) => {
        const name = card.querySelector("div.name").innerHTML;
        const email = card.querySelector("div.email").innerHTML;
        // if one of them contains the target
        const found = [name, email].some((it) => it.toLowerCase().includes(query));
        if (found) {
          card.style.display = "";
          count++;
        } else {
          card.style.display = "none";
        }
      });

      // update style
      const writing = !!query.length;
      const foundAny = count > 0;

      input[`${writing && !foundAny ? "add" : "remove"}Class`]("red");
      wrapper[`${writing ? "add" : "remove"}Class`]("searching");
      container.css({ opacity: foundAny ? 1 : 0 });
      noMembers.css({ display: foundAny ? "none" : "" /* default  */ });
    });

  const clearInputButton = $("<button>") //
    .html($(`<i>`).addClass("fas fa-delete-left"))
    .addClass("clearInput")
    .on("click", () => input.val("").trigger("input"));

  const inputWrapper = $("<div>") //
    .addClass("inputWrapper")
    .append(input);
  inputWrapper.append(input, clearInputButton);
  wrapper.append(inputWrapper, noMembers);

  if (userCardFactory instanceof Function) {
    for (const user of users) {
      if (!user) continue;
      const f = user.isMe ? "prepend" : "append";
      container[f](userCardFactory(user));
    }
  }

  container.appendTo(wrapper);
  return wrapper;
};
