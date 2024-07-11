const alertAuth = () => {
  const loginButton = $("<button>")
    .addClass("colored") //
    .text("Login")
    .on("click", () => {
      window.location.href = "../account/login.html";
    })[0];
  return appendAlert("You are not authenticated!", "danger", false, 0, loginButton);
};
