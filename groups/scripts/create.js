const users = {};

const setUserChecked = (id, checked) => {
  //? Should fix if it happens
  if (!users.hasOwnProperty(id)) throw new Error(`Cannot toggle selection of missing user: ${email}`);
  users[id].selected = checked;
};

const ajaxFailHandler = (jqXHR, status, e) => {
  console.log(jqXHR);
  console.error(status, "AJAX request timed out:", `(${jqXHR.status})`, e);
  container.empty();
  const isAuthError = jqXHR.status === 401;
  return isAuthError //
    ? alertAuth()
    : appendAlert(
        `Error while loading the list of users: (${jqXHR.status}) ${e}`, //
        "warning",
        false,
        0,
        jqXHR.responseText
      );
};

const listUsers = async () => {
  const container = $(".usersContainer");
  container.text("Loading...");

  $.get("../common/php/users.php") //
    .done((usersFromServer) => {
      console.log(typeof usersFromServer, usersFromServer);
      try {
        console.log(usersFromServer);
        if (!usersFromServer.length) {
          container.text("No members found");
          return;
        }
        usersContainer(
          //
          "Search or select users",
          "usersContainer",
          (user) => {
            user.selected = false;
            users[user.id] = user;

            const viewButton = $("<button>") //
              .addClass("colored")
              .append($("<i>").addClass("fa-solid fa-eye"))
              .append(" Profile")
              .on("click", () => {
                window.open(`../user/profile.php?id=${user.id}`, "_blank");
              });
            return userCard(user, setUserChecked, false, "#0000", viewButton);
          },
          ...usersFromServer
        ).appendTo($(".screen"));
        //
      } catch (err) {
        console.error(err);
        appendAlert(`Error while loading the list of users: ${err}`, "danger");
        container.text(`Failed to load the list of users.`);
      }
    })
    .fail(ajaxFailHandler);
};

const search = (part) => {
  const membersContainer = $(".userContainer");

  const searching = typeof part !== "string" || !part.length;
  membersContainer[`${searching ? "remove" : "add"}Class`]("searching");

  const filtered = Object.values(users) //
    .filter((user) => user.name.includes(part || ""));

  if (!filtered.length) {
    membersContainer.html("<p align='center'>(No members found)</p>");
    return;
  }

  membersContainer.empty();
  for (const user of filtered) {
    const selected = user.selected;
    const card = memberCard(user, setUserChecked, selected);
    membersContainer.append(card);
  }
};

const createGroup = async () => {
  const nameInput = document.getElementById("groupName");
  const name = nameInput.value;
  const members = Object.values(users) //
    .filter((it) => it.selected);

  if (!name.length) {
    appendAlert("Please enter a group name", "warning", true, 5000);
    nameInput.focus();
    return;
  }
  if (members.length < 1) {
    appendAlert("Please select 1 or more members to be added to the group", "warning", true, 5000);
    return;
  }

  const imageURL = $("#groupImage").attr("src");

  const res = await fetchGroupSafe(
    "createGroup", //
    "POST",
    "Failed to create the group",
    {
      name,
      members: JSON.stringify(members),
      imageURL,
    }
  );

  const id = res.groupID;
  const aboutButton = $("<button>") //
    .text("About Group")
    .on("click", () => {
      window.location.href = `../groups/about.php?groupID=${id}`;
    });
  const openButton = $("<button>") //
    .addClass("colored")
    .text("Open Group")
    .on("click", () => {
      window.location.href = `../chat/group.php?groupID=${id}`;
    });
  //? Auto continue after 5s
  let seconds = 5;
  const i = setInterval(() => {
    if (seconds <= 0) {
      clearInterval(i);
      openButton.trigger("click");
      return;
    }
    openButton.text(`Open Group (${seconds}s)`);
    seconds--;
  }, 1000);
  console.log("Group created successfully:", res);
  appendAlert(`Group created successfully: ID=${res.groupID}`, "success", false, 0, null, aboutButton[0], openButton[0]);
};

// document ready
$(async () => {
  listUsers();

  const searchMembersInput = $("#searchMembers");
  searchMembersInput.on("input", () => {
    search(searchMembersInput.val().trim() || ""); //! $(this) -- t.nodeName is undefined
  });

  const myInfo = await getMyInfo();
  if (myInfo?.success) $("nav .nav-link img.pfp").attr("src", myInfo.me.imageURL);
  console.log(myInfo?.me);

  $("#createButton").on("click", createGroup);

  const groupNameInput = $("#groupName");
  groupNameInput.on("keypress", async (ev) => {
    if (ev.key === "Enter") await createGroup();
  });
  groupNameInput.trigger("focus");

  const imageURLInput = $("#imageURLInput");
  const imageURLRandomCatIcon = $("#imageURLRandomCatIcon");
  const imageURLPreview = $("#imageURLPreview");

  imageURLInput.on("input", () => {
    const value = imageURLInput.val().trim();
    if (!value.length) return;
    try {
      const url = new URL(value);
      imageURLPreview.attr("src", url.toString());
    } catch (e) {}
  });
  $("#imageURLRandomCat").on("click", async () => {
    imageURLRandomCatIcon.addClass("fa-bounce");
    const catRaw = await fetch("https://cataas.com/cat/cute?json=true");
    const cat = await catRaw.json();
    const url = `https://cataas.com/cat/${cat._id}`;
    imageURLPreview.attr("src", url);
    imageURLInput.val(url);
    imageURLInput.trigger("focus");
    setTimeout(() => {
      imageURLRandomCatIcon.removeClass("fa-bounce");
    }, 1000); // 1.6s just in case it ends so fast
  });

  const groupImage = $("#groupImage");
  const imageURLModal = $("#imageURLModal");
  imageURLModal.on("show.bs.modal", () => {
    imageURLInput.val(groupImage.attr("src"));
  });
  $("#setGroupImage").on("click", () => {
    const value = imageURLInput.val().trim();
    if (!value.length) return;
    try {
      const url = new URL(value);
      groupImage.attr("src", url.toString());
    } catch (e) {
      return appendAlert(`Invalid URL: ${value}`, "warning", true, 5000);
    }
    imageURLModal.modal("hide");
  });
});
