$(async () => {
  const params = new URLSearchParams(document.location.search);
  const groupID = parseInt(params.get("groupID"));
  if (isNaN(groupID) || groupID < 1) {
    console.error("Invalid Group ID:", groupID);
    return $(() => appendAlert(`Invalid Group ID: ${groupID}`, "danger", false));
  }
  console.log("Group ID:", groupID);

  const links = {
    groups: {
      about: { page: "../groups/about.php" },
      php: "../groups/php/groups.php",
    },
    chat: {
      php: "./php/chat.php",
    },
  };

  let group = null;
  let members = {};
  let me = null;

  const ids = [];
  const randomID = () => {
    const id = Math.floor(Math.random() * 10000);
    if (ids.includes(id)) return randomID();
    return id;
  };

  const sayNotFound = () => {
    appendAlert(`Group not found: id=${groupID}`, "danger", true, 5000);
    const notfound = $("<div>") //
      .css({ textAlign: "center", flex: 1 })
      .append(
        $("<h1>").text("404").css({ color: "var(--color-error)", fontSize: "72pt" }), //
        $("<p>").text("Group not found").css({ fontWeight: "bold", fontSize: "larger" }),
        $("<p>").text(`Group ID: ${groupID}`),
        $("<div>") //
          .append(
            $("<hr>"), //
            $("<p>").text(`This message appears also when you are not a member of the group`)
          )
      );
    showModal("Group not found", [notfound]);
  };

  const updateGroupInfo = () => {
    $(".screen.chat .header .groupInfo .pfp").attr("src", group.imageURL);
    $(".screen.chat .header .groupInfo .name").text(group.name);
  };
  const getGroupInfo = async () => {
    const groupFromServer = await fetchSafe(
      links.groups.php, //
      "getGroupInfo",
      "GET",
      "Failed to get group info",
      { groupID }
    );
    const status = groupFromServer?.status;
    if (status && status === 404) {
      sayNotFound();
      return (group = null);
    }
    group = groupFromServer;
    console.log("Group:", group);
    updateGroupInfo();
    return group;
  };

  const getGroupMembers = async () => {
    const res = await fetchSafe(
      links.groups.php, //
      "getMembers",
      "GET",
      "Failed to get the group members",
      { groupID }
    );
    //? find me
    me = res.find((m) => m.isMe);
    //? convert members array to object with member.id as key
    const ids = res.map((m) => m.id);
    members = Object.fromEntries(ids.map((id, i) => [id, res[i]]));
    return members;
  };

  const pollMessages = (afterMS) => {
    return fetchSafe(
      links.chat.php, //
      "pollMessages",
      "GET",
      "Failed to poll messages",
      { groupID, afterMS },
      true
    );
  };

  let currentPollingInterval = null;
  const stopPolling = () => clearInterval(currentPollingInterval);
  const pollMessages_interval = (everyMS) => {
    //? interval polling is bad but used here due to time constraints
    let pollAfterMS = 0;
    currentPollingInterval = setInterval(async () => {
      const res = await pollMessages(pollAfterMS);
      if (!res || !res.success || res.error) {
        stopPolling();
        console.error("Failed to poll messages:", res?.error);
        const retryButton = $("<button>") //
          .addClass("colored")
          .text("Retry")
          .on("click", (ev) => {
            //? close this alert and retry
            $(ev.target).parent("div").remove();
            pollMessages_interval(everyMS);
          });
        return appendAlert("Failed to poll messages", "danger", false, 0, null, retryButton);
      }
      pollAfterMS = Date.now();
    }, everyMS);
  };

  const appendMessage = async (message) => {
    messageFactory(
      message, //
      members[message.user_id],
      message.user_id === me.id //? is me (show pfp if not me + other stuff)
    ).appendTo(".screen.chat .body"); //? append to chat body
  };

  const TEST = async () => {
    [
      new Message(randomID(), me.id, "Hello everyone! I hope you are doing great today"),
      new Message(randomID(), members[21].id, "Hi, I'm great! How are you today?"),
      new Message(randomID(), me.id, "Amazing! What are you up to?"),
      new Message(randomID(), members[21].id, "Hey hey hey, what's up?"),
      new Message(randomID(), members[23].id, "Hi, I'm great! How are you today?"),
      new Message(randomID(), me.id, "Amazing!"),
      new Message(randomID(), members[24].id, "Hey hey hey, what's up?"),
    ] //
      .forEach((msg, i) => appendMessage(msg));
  };

  await getGroupInfo();
  if (!group) return;
  await getGroupMembers();

  $(".screen.chat .header").on("click", () => {
    window.location.href = `${links.groups.about.page}?groupID=${groupID}`;
  });
  const messageInput = $(".screen.chat .footer input.messageInput");
  const sendButton = $(".screen.chat .footer .sendButton");
  messageInput.on("keypress", (ev) => {
    if (ev.key !== "Enter") return;
    ev.preventDefault();
    sendButton.trigger("click");
  });
  sendButton.on("click", () => {
    const value = messageInput.val().trim();
    if (!value.length) return;
    messageInput.val("");
    appendMessage(new Message(randomID(), me, value));
  });

  //? poll every 2sec
  //pollMessages_interval(2000);

  //TEST();
});
