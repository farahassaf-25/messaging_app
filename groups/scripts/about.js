const groupName = new URLSearchParams(window.location.search) //
  .get("groupName");

const container = document.getElementsByClassName("membersContainer")[0];

const memberCard = (name, imageURL) => {
  const img = document.createElement("img");
  img.src = imageURL ?? "./assets/defaultProfile.webp";
  img.classList.add("php");

  const nameDiv = document.createElement("div");
  nameDiv.classList.add("name");
  nameDiv.innerHTML = name;

  const div = document.createElement("div");
  div.classList.add("memberCard");
  div.appendChild(img);
  div.appendChild(nameDiv);
  return div;
};

const listMembers = async () => {
  $.ajax({
    type: "GET",
    timeout: 10000,
    url: "./php/users.php",
    error: (jqXHR, status, e) => {
      console.error("AJAX request timed out:", status, e);
    },
    success: (members) => {
      const container = document.getElementById("membersContainer");

      if (!members) {
        container.innerHTML = "<div>No members found</div>";
        return;
      }
      container.innerHTML = "";
      for (let member of members) {
        container.appendChild(memberCard(member.email, member.imageURL));
      }
    },
  });
};

const loadName = () => {
  const groupNameLabel = document.getElementById("groupNameLabel");
  groupNameLabel.value = groupName || "(Error)";
};

const editGroup = () => {
  const newName = prompt("Enter new group name:");
  if (!newName) return alert("Group name cannot be empty... Try again.");

  window.location.href = `./create.html?groupName=${newName}`;
};

loadName();
listMembers();

document.getElementById("groupNameBox").innerHTML = `
<form id="editGroupForm" action="./php/create.php" method="post">
  <label id="groupNameLabel">${groupName || "Loading..."}</label>
  <button onclick="editGroup()" class="colored"><i class="fa-solid fa-pen-to-square"></i></button>
</form>`;
