const getMyInfo = async () => {
  try {
    const res = await fetch("../common/php/users.php?action=me");
    if (!res.ok) return;
    return await res.json();
  } catch (e) {
    appendAlert(`Error while fetching my profile image: ${e}`, "danger", true, 0);
    console.error(e);
  }
  return null;
};
