$(async () => {
  const params = new URLSearchParams(document.location.search);
  const groupID = parseInt(params.get("groupID"));
  if (isNaN(groupID) || groupID < 1) {
    return $(() => appendAlert(`Invalid Group ID: ${groupID}`, "danger", false));
  }

  console.log("Group ID:", groupID);

  // from db:
  let users = {};
  let members = {};
  let me = null; // from members (where isMe=true)
  let group = null;

  //

  const userCardFactory_toAdd = (user) => {
    const addButton = $("<button>") //
      .append($("<i>").addClass("fa-solid fa-user-plus"), " Add")
      .on("click", async () => {
        const res = await addRemoveMember(user.id, true);
        if (!res?.success) return;

        //? remove user card (to add)
        //? add member card (group member)
        $(`#usersContainer .userCard.userCard_${user.id}`).remove();
        userCardFactory_member(user).appendTo("#membersContainer");

        appendAlert(
          $("<span>") //
            .append(
              $("<span>").text("Member "),
              $("<span>").text("added").css({ fontWeight: "bold" }),
              $("<span>").text(" successfully: "),
              $("<span>").text(user.name).css({ color: "var(--color-primary)", fontWeight: "bold" })
            ),
          "success",
          true,
          5000
        );
        // setTimeout(() => location.reload(), 1500);
      });

    const viewButton = $("<button>") //
      .addClass("colored")
      .append($("<i>").addClass("fa-solid fa-eye"), " Profile")
      .on("click", () => {
        window.location.href = `../user/profile.php?id=${user.id}`;
      });

    return userCard(user, null, false, "#0000", addButton, viewButton);
  };

  const userCardFactory_member = (user) => {
    const cardBG = user.isMe || !me.isGroupAdmin ? "#0000" : null;
    const card = userCard(user, null, false, cardBG);
    if (user.isMe) return card;

    const overlay = [];

    //? only if im an admin (toggle admin + remove)
    if (me.isGroupAdmin) {
      // remove button
      const removeButton = $("<button>") //
        .addClass("red")
        .append($("<i>").addClass("fa-solid fa-user-minus"), " Remove")
        .on("click", () => removeMember_withModal(user));

      // admin button
      const shieldIcon = (isAdmin) =>
        $("<i>")
          .addClass("fa-solid")
          .addClass(`fa-shield${isAdmin ? "-halved" : ""}`);
      const adminButtonText = (isAdmin) => " " + (isAdmin ? "Demote" : "Admin");

      const makeGroupAdminButton = $("<button>") //
        .append(shieldIcon(user.isGroupAdmin), adminButtonText(user.isGroupAdmin))
        .on("click", async (ev) => {
          const isGroupAdminNew = !user.isGroupAdmin;
          const res = await addRemoveGroupAdmin(user.id, isGroupAdminNew);
          if (!res?.success) return;
          user.isGroupAdmin = isGroupAdminNew;
          card.setIsGroupAdmin(isGroupAdminNew);
          $(ev.target) //
            .empty()
            .append(shieldIcon(user.isGroupAdmin), adminButtonText(isGroupAdminNew))
            [(isGroupAdminNew ? "add" : "remove") + "Class"]("red");

          appendAlert(
            $("<span>").append(
              $("<span>").text('Member "'),
              $("<span>").text(user.name).css({ color: "var(--color-primary)", fontWeight: "bold" }),
              $("<span>").text('" is now a '),
              $("<span>")
                .text("group " + (isGroupAdminNew ? "admin" : "member"))
                .css(isGroupAdminNew ? { fontWeight: "bold" } : {})
            ),
            "success",
            true,
            5000
          );
        });
      if (user.isGroupAdmin) makeGroupAdminButton.addClass("red");
      overlay.push(makeGroupAdminButton, removeButton);
    }

    const viewButton = $("<button>") //
      .addClass("colored")
      .append($("<i>").addClass("fa-solid fa-eye"), " Profile")
      .on("click", () => {
        window.location.href = `../user/profile.php?id=${user.id}`;
      });
    overlay.push(viewButton);
    card.addOverlay(overlay);
    return card;
  };

  //

  const removeMember_withModal = (user) => {
    const yesButton = $("<button>") //
      .addClass("red")
      .attr("data-bs-dismiss", "modal")
      .text("Yes")
      .on("click", async () => {
        const membersArr = Object.values(members);
        if (membersArr.length === 1) return deleteGroup();
        const otherGroupAdmin = membersArr.find((m) => m.isGroupAdmin && !m.isMe);
        if (!otherGroupAdmin) {
          const res_newAdmin = await addRemoveGroupAdmin(membersArr[0], true, true);
          if (!res_newAdmin?.success)
            return appendAlert(
              res_newAdmin?.message || "Failed to leave group (Must have at least 1 admin)",
              "danger",
              true,
              5000
            );
        }

        const res = await addRemoveMember(user.id, false);
        if (!res?.success) return;
        user.isGroupAdmin = false;

        //? remove member card
        //? add user card (to add)
        $(`#membersContainer .userCard.userCard_${user.id}`).remove();
        userCardFactory_toAdd(user).appendTo("#usersContainer");

        appendAlert(
          $("<span>") //
            .append($("<span>").text("Member "))
            .append($("<span>").text("removed").css({ color: "var(--color-error)", fontWeight: "bold" }))
            .append($("<span>").text(" successfully: "))
            .append($("<span>").text(user.name).css({ color: "var(--color-primary)", fontWeight: "bold" })),
          "success",
          true,
          5000
        );
        //? go to index after leaving
        if (user.isMe) setTimeout(() => (location.href = "../index.php"), 200);
      });
    const cancelButton = $("<button>") //
      .addClass("colored")
      .attr("data-bs-dismiss", "modal")
      .text("Cancel");

    const buttons = [cancelButton, yesButton];
    const title = user.isMe ? "Leave group" : "Remove member";

    const content = [
      $("<p>").append(
        "Are you sure you want to ", //
        $("<span>") //
          .text(user.isMe ? "leave this group" : "remove this member")
          .css({ fontWeight: "bold", color: "var(--color-error)", textDecoration: "underline" }),
        "?"
      ),
    ];
    if (!user.isMe) {
      content.push(
        $("<br>"),
        $("<div>") //
          .append(
            $("<img>").addClass("pfp big").attr("src", user.imageURL),
            $("<div>") //
              .css({ textAlign: "center" })
              .append(
                $("<div>") //
                  .text(" " + user.name)
                  .css({ fontWeight: "bold" }),
                $("<div>") //
                  .text(user.email)
                  .css({ fontSize: "small" })
              )
          )
          .css({
            display: "flex",
            flexDirection: "column",
            gap: "4px",
            alignItems: "center",
            justifyContent: "center",
          })
      );
    }

    showModal(title, content, buttons);
  };

  const stepDown_withModal = () => {
    const yesButton = $("<button>") //
      .addClass("red")
      .attr("data-bs-dismiss", "modal")
      .text("Yes")
      .on("click", async () => {
        const res = await addRemoveGroupAdmin(me.id, false);
        if (!res?.success) {
          return appendAlert(res?.message || "Failed to step down", "danger", true, 5000);
        }
        appendAlert("You are no longer a group admin (Reloading soon)", "success", true, 5000);
        setTimeout(() => location.reload(), 2000);
      });
    const cancelButton = $("<button>") //
      .addClass("colored")
      .attr("data-bs-dismiss", "modal")
      .text("Cancel");
    const buttons = [cancelButton, yesButton];

    const title = "Step Down";
    const content = [
      $("<div>").text("Are you sure you want to step down as group admin?"), //
      $("<br>"),
      $("<div>").text("You will no longer be an admin in this group").css({ color: "var(--color-error)", fontWeight: "bold" }),
    ];

    showModal(title, content, buttons);
  };

  const deleteGroup_withModal = () => {
    const yesButton = $("<button>") //
      .addClass("red")
      .attr("data-bs-dismiss", "modal")
      .text("Yes")
      .on("click", async () => {
        const res = await deleteGroup();
        if (!res?.success) return;
        appendAlert("Group deleted (Reloading soon)", "success", true, 5000);
        setTimeout(() => (location.href = "../index.php"), 2000);
      });
    const cancelButton = $("<button>") //
      .addClass("colored")
      .attr("data-bs-dismiss", "modal")
      .text("Cancel");
    const buttons = [cancelButton, yesButton];

    const title = "Delete Group";
    const msg = $("<p>")
      .append(
        "Are you sure you want to ",
        $("<span>").text("DELETE").css({ textDecoration: "underline", fontWeight: "bold", color: "inherit" }),
        " this group?"
      )
      .css({ color: "var(--color-error)" });

    const content = [
      $("<p>").html(msg),
      $("<br>"),
      $("<div>") //
        .append(
          $("<img>").addClass("pfp big").attr("src", group.imageURL),
          $("<div>") //
            .text(" " + group.name)
            .css({ textAlign: "center", fontWeight: "bold" })
        )
        .css({
          display: "flex",
          flexDirection: "column",
          gap: "4px",
          alignItems: "center",
          justifyContent: "center",
        }),
    ];

    showModal(title, content, buttons);
  };

  //

  const deleteGroup = () => {
    return fetchGroupSafe("deleteGroup", "POST", "Failed to delete the group", { groupID });
  };

  const getUsersToAdd = async () => {
    console.log(groupID);
    const res = await fetchGroupSafe("getUsers", "GET", "Failed to get users outside this group", { groupID });
    users = res;
    return users;
  };

  const getGroupMembers = async () => {
    const res = await fetchGroupSafe("getMembers", "GET", "Failed to get the group members", { groupID });
    members = res;
    me = members.find((m) => m.isMe);
    return members;
  };

  const getGroupInfo = async () => {
    const groupFromServer = await fetchGroupSafe("getGroupInfo", "GET", "Failed to get group info", { groupID });
    const status = groupFromServer?.status;
    if (status && status === 404) {
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
      $(".screen").html(notfound);
      return null;
    }
    group = groupFromServer;
    console.log("Group:", group);
    updateGroupInfo();
    return group;
  };

  const updateGroupInfoBackend = async (name, imageURL) => {
    const imageURLEncoded = encodeURIComponent(imageURL || "null");
    const nameEncoded = encodeURIComponent(name);
    const res = await fetchGroupSafe(
      "updateGroupInfo", //
      "POST",
      "Failed to update group info",
      {
        groupID,
        name: nameEncoded,
        imageURL: imageURLEncoded,
      }
    );
    if (!res) return;
    appendAlert("Group info updated successfully", "success", true, 5000);
    group.name = name;
    group.imageURL = imageURL;
    updateGroupInfo();
    imageURLModal.modal("hide");
  };

  const updateGroupInfo = async () => {
    $("#groupImage").attr("src", group.imageURL);
    $("#imageURLPreview").attr("src", group.imageURL);
    $("#groupName").text(group.name);
    $("#groupNameInput").val(group.name);
  };

  const addRemoveMember = async (memberID, isAdd) => {
    return fetchGroupSafe(
      "addRemoveMember", //
      "POST",
      `Failed to remove member (ID=${memberID})`,
      { groupID, memberID, isAdd }
    );
  };

  const addRemoveGroupAdmin = async (memberID, isGroupAdmin) => {
    const groupAdminCount = members.filter((m) => m.isGroupAdmin).length;
    if (!isGroupAdmin && groupAdminCount === 1) return { success: false, message: "The group must have at least 1 group admin" };
    return fetchGroupSafe(
      "addRemoveGroupAdmin", //
      "POST",
      `Failed to change user admin state (memberID=${memberID}, isGroupAdmin=${isGroupAdmin})`,
      { groupID, memberID, isGroupAdmin }
    );
  };

  const listGroupMembers = async () => {
    console.log("Members:", members);
    usersContainer("Group members", "membersContainer", userCardFactory_member, ...members) //
      .insertBefore("#groupInfo > :last-child");
  };

  const listUsersToAdd = async () => {
    console.log("Users:", users);
    usersContainer("Add users", "usersContainer", userCardFactory_toAdd, ...users) //
      .appendTo($(".screen"));
  };

  //
  await getGroupInfo();
  await getGroupMembers();
  await listGroupMembers();

  console.log("Me:", me);
  $("nav .nav-link img.pfp").attr("src", me.imageURL);
  $("#leaveGroupButton").on("click", () => removeMember_withModal(me));

  //! Stop for non-admins (the server won't allow group management for non group-admins)
  if (!me.isGroupAdmin) return;

  await getUsersToAdd();
  await listUsersToAdd();

  //
  $("#stepDownButton").on("click", () => stepDown_withModal());
  $("#deleteGroupButton").on("click", () => deleteGroup_withModal());

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
    const catID = (await catRaw.json())._id;
    const url = `https://cataas.com/cat/${catID}`;
    imageURLPreview.attr("src", url);
    imageURLInput.val(url);
    imageURLInput.trigger("focus");
    setTimeout(() => {
      imageURLRandomCatIcon.removeClass("fa-bounce");
    }, 1000); // 1.6s just in case it ends so fast
  });

  const groupNameInput = $("#groupNameInput");
  const groupImage = $("#groupImage");
  const imageURLModal = $("#editGroupModal");
  imageURLModal.on("show.bs.modal", () => {
    imageURLInput.val(groupImage.attr("src"));
  });
  $("#saveGroupInfo").on("click", async () => {
    const name = groupNameInput.val().trim();
    const nameIsValid = /^[\w+ ~!@#$%^&*()_+`\-=]{1,64}$/.test(name);
    if (!nameIsValid) {
      const special = "~!@#$%^&*()_+`-=";
      return appendAlert(
        `Invalid group name: ${name}` + //
          `\n Must be between 1 and 64 alphanumeric characters (Also the following characters are allowed: ${special})`,
        "warning",
        true,
        5000
      );
    }
    const imageURL = imageURLInput.val().trim() || null;
    if (imageURL === null) {
      return appendAlert("Please enter a valid image URL", "warning", true, 5000);
    }
    try {
      const url = new URL(imageURL);
      groupImage.attr("src", url.toString());
    } catch (e) {
      return appendAlert(`Invalid URL: ${imageURL}`, "warning", true, 5000);
    }
    updateGroupInfoBackend(name, imageURL.toString());
  });

  //? show any available edit containers
  $("#groupInfo .editContainer") //
    .each((_, element) => element.classList.remove("hidden"));
});
