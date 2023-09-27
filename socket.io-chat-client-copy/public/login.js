import {setCookie, getCookie} from "./utils.js";
import { addChatMessage } from "./messages.js";

const setLoginUser = (user, usernameValue) => {
  user.username = usernameValue;

  setCookie('loggedInAs', usernameValue, 2);
  document.body.classList += 'user-logged-in';
  addChatMessage(`Welcome ${usernameValue}`);
}

/**
 * @desc this is a minimal implementation
 * @todo extend login authentication
 */
const authenticateLogin = (username, password) => {
  if (password.length === 0 || username.length === 0) {
    return false;
  }

  return true;
}

const showLoginFail = () => {
  const loginErrorElement = document.querySelector('.login-error')
  loginErrorElement.innerHTML = 'Login failed.';
  setTimeout(() => {
    loginErrorElement.innerHTML = '';
  }, 3000)
}

const initLoginInput = (user) => {
  const savedUsername = getCookie('loggedInAs');
  if (savedUsername) {
    setLoginUser(user, savedUsername);
  }

  document.getElementById("sign-in")
    .addEventListener(
      'click',
      (event) => {
        const usernameValue = document.getElementById('login-username').value;
        const passwordValue = document.getElementById('login-password').value;

        if (authenticateLogin(usernameValue, passwordValue)) {
          setLoginUser(user, usernameValue);
        } else {
          showLoginFail();
        }
      }
    );
}

export {initLoginInput}