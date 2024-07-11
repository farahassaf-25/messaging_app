const formatDate = (ms) => {
  const date = new Date(ms);
  const hours = date.getHours();
  const minutes = date.getMinutes();
  const day = date.getDate();
  const month = date.getMonth() + 1; // Months are zero-indexed
  const y = date.getFullYear();

  const ampm = hours >= 12 ? "PM" : "AM";
  const h = hours % 12 || 12; // Convert 0 to 12 for 12 AM
  const m = minutes.toString().padStart(2, "0");
  const d = day.toString().padStart(2, "0");
  const M = month.toString().padStart(2, "0");

  return `${h}:${m} ${ampm} • ${d}/${M}/${y}`;
};

/** @param {Message} message */
const messageFactory = (message, user, isme = false) => {
  //? wrapper to freely position the message (left/right)
  const messageRow = $("<div>").addClass("messageRow");

  const messageWrapper = $("<div>").addClass("messageWrapper").appendTo(messageRow);
  const messageDiv = $("<div>").addClass("message").appendTo(messageWrapper);

  const messageContent = $("<div>") //
    .addClass("messageContent")
    .appendTo(messageDiv);

  if (isme) {
    messageRow.addClass("me");
  } else {
    //? add pfp
    $("<img>") //
      .addClass("pfp")
      .attr("src", user.imageURL)
      .prependTo(messageDiv);

    //? add user name
    $("<p>") //
      .addClass("name")
      .text(user.name)
      .appendTo(messageContent);
  }

  //? message content
  $("<div>") //
    .addClass("content")
    .text(message.content)
    .appendTo(messageContent);

  //? message date
  $("<div>") //
    .addClass("date")
    .text(formatDate(message.createdAt))
    .appendTo(messageWrapper);

  return messageRow;
};
