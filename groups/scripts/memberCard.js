/**
 * Member card element
 * @param {string} name
 * @param {string} imageURL
 * @param {(ev: Event) => {}} onSelectChanged
 * @returns {HTMLDivElement} The generated <div> element
 */
function memberCard(email, imageURL, onSelectChanged = undefined) {
  const div = document.createElement("div");
  div.classList.add("memberCard");

  if (onSelectChanged instanceof Function) {
    const input = document.createElement("input");
    const idEmail = email.replace(/[^a-zA-Z0-9]/g, "_");
    input.id = `memberCheck_${idEmail}`;
    input.type = "checkbox";
    input.addEventListener("change", onSelectChanged);
    div.appendChild(input);
  }

  const img = document.createElement("img");
  img.src = imageURL || "../assets/defaultProfile.webp";
  img.classList.add("pfp");
  div.appendChild(img);

  const nameDiv = document.createElement("div");
  nameDiv.classList.add("email");
  nameDiv.appendChild(document.createTextNode(email));
  div.appendChild(nameDiv);

  return div;
}
