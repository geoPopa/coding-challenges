
const setCookie = (name, value, expDays) => {
  let date = new Date();
  date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
  const expires = "expires=" + date.toUTCString();
  document.cookie = `${name}=${value}; ${expires}; path=/`;
}

const getCookie = (name) => {
  var cookieArr = document.cookie.split(";");

  for(var i = 0; i < cookieArr.length; i++) {
      var cookiePair = cookieArr[i].split("=");

      if (name == cookiePair[0].trim()) {
          return decodeURIComponent(cookiePair[1]);
      }
  }

  return null;
}

export {setCookie, getCookie};