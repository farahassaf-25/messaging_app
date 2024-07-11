const errorHandler = async (res = null, error = null) => {
  console.error("Error: ", res, error);
  const msg = res?.statusText || "Operation failed";
  const msgType = "danger";

  if (error) return appendAlert(`${msg}: ${error}`, msgType, true);

  const contentType = res?.headers.get("content-type");

  if (contentType === "application/json") {
    //? json means an intended error was given
    //? - contains `error` property
    const resJ = await res.json();
    return appendAlert(`${msg}: ${resJ.error}`, msgType, true, 0);
  }

  try {
    if (!res) throw new Error("Unknown error occured");
    //? html means php threw an error (unintended)
    const resHTML = await res.text();
    return appendAlert(msg, msgType, true, 0, resHTML);
    //
  } catch (e) {
    //? something else (bigger) happened
    return appendAlert(`${msg}: ${e}`, msgType, true);
  }
};

/** Fetch groups.php safely with error handling
 * @param {string} path path to the php file
 * @param {string} action action to perform on the server side
 * @param {string} method http method
 * @param {string} errorMsg message to display in case of error
 * @param {object} extras extra parameters to add to the url (...&key=value...)
 * @returns response json
 */
const fetchSafe = async (path, action, method, errorMsg = "Operation failed", extras = {}, silent = false) => {
  try {
    let res = null;
    if (method === "GET") {
      // add extras to url
      const url = Object.keys(extras) //
        .reduce(
          (all, key) => `${all}&${key}=${extras[key]}`, //
          `${path}?action=${action}`
        );
      res = await fetch(url);
      //
    } else {
      res = await fetch(path, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action, ...extras }),
      });
    }
    if (!res.ok) {
      errorHandler(res);
      return res;
    }
    const resj = await res.json();
    if (resj.error) {
      console.error(resj.error);
      if (!silent) appendAlert(errorMsg + ": " + resj.error, "warning", true, 0);
    }
    return resj;
  } catch (e) {
    if (!silent) await errorHandler(null, e);
    return null;
  }
};
