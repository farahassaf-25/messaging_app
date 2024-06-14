const users = {};

const listMembers = () => {
  const container = document.getElementById("membersContainer");
  container.innerText = "Loading...";
  $.ajax({
    type: "GET",
    timeout: 10000,
    url: "../common/php/users.php",
    error: (jqXHR, status, e) => {
      console.log(jqXHR);
      console.error(status, "AJAX request timed out:", `(${jqXHR.status})`, e);
      container.innerHTML = "";

      const isAuthError = jqXHR.status === 401;
      const msg = `Error while loading the list of users: (${jqXHR.status}) ${e}`;
      const type = isAuthError ? "danger" : "warning";

      const loginButton = isAuthError ? document.createElement("button") : null;
      if (loginButton) {
        loginButton.classList.add("btn", "btn-primary");
        loginButton.innerHTML = "Login";
        loginButton.addEventListener("click", () => {
          window.location.href = "../account/login.html";
        });
        return appendAlert(msg, type, false, 0, loginButton);
      }

      return appendAlert(msg, type);
    },
    success: (membersJ) => {
      try {
        console.log(membersJ);
        const members = JSON.parse(membersJ);
        if (!members.length) {
          container.innerHTML = "No members found";
          return;
        }

        container.innerHTML = "";
        for (const member of members) {
          users[member.email] = { member, selected: false };
          const card = memberCard(
            member.email, //
            member.imageURL, //
            (ev) => {
              users[member.email].selected = ev.currentTarget.checked;
            }
          );
          container.appendChild(card);
        }
      } catch (err) {
        console.error(err);
        appendAlert(`Error while loading the list of users: ${err}`, "danger");
        container.innerHTML = `Failed to load the list of users.`;
      }
    },
  });
};

const search = (part) => {
  const filtered = Object.values(users) //
    .filter((user) => user.member.email.includes(part));

  const container = document.getElementById("membersContainer");
  container.innerHTML = "";

  for (const user of filtered) {
    const card = memberCard(
      user.member.email, //
      user.member.imageURL, //
      (ev) => {
        users[user.member.email].selected = ev.currentTarget.checked;
      }
    );
    container.appendChild(card);
  }
};

const createGroup = () => {
  const nameInput = document.getElementById("groupName");
  const name = nameInput.value;
  const members = Object.values(users) //
    .filter((it) => it.selected)
    .map((it) => it.member);

  if (!name.length) {
    appendAlert("Please enter a group name", "warning", true, 5000);
    nameInput.focus();
    return;
  }
  if (members.length < 2) {
    appendAlert("Please select 2 or more members to be added to the group", "warning", true, 5000);
    return;
  }
  $.ajax({
    method: "POST",
    timeout: 10000,
    url: "./php/groups.php",
    //contentType: "application/json; charset=utf-8",
    data: {
      name,
      members: JSON.stringify(members),
    },
    error: (jqXHR, status, e) => {
      console.error("AJAX request timed out:", status, e, jqXHR);

      let message = e; // main error message

      // try to extract the info of the error thrown while creating the group
      if (jqXHR.responseText.includes("error")) {
        const lastLine = jqXHR.responseText.includes("\n") ? jqXHR.responseText.split("\n").pop() : jqXHR.responseText;
        try {
          const errorObj = JSON.parse(lastLine);
          if (errorObj.error) message = errorObj.error;
        } catch (err) {} // ignore
      }

      appendAlert(`Error while creating the group: ${message}`, "danger");
    },
    success: (res) => {
      appendAlert(`Group created successfully: ID=${res.groupID}`, "success", true, 6000);
      console.success(res);
    },
  });
};

$(document).ready(listMembers);

$("#searchMembers").on("input", () => {
  search(ev.target.value);
});
$("#createButton").on("click", createGroup);
