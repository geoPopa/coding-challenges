
const addChatMessage = (message, withHtml = false) => {
  const item = document.createElement('li');

  if (withHtml) {
    item.innerHTML = message;
  } else {
    item.textContent = message;
  }

  document.getElementById('messages').appendChild(item);

  window.scrollTo(0, document.body.scrollHeight);
}

const initMessageInput = (socket, user) => {
  document.forms['client-message-form'].addEventListener(
    'submit',
    function(e) {
      e.preventDefault();
      const textInput = this.elements['message']
      if (textInput.value) {
        socket.emit(
          'message',
          {
            author: user.username ?? 'unknown',
            message: textInput.value
          }
        );

        textInput.value = '';
      }
    }
  );
}


export { addChatMessage, initMessageInput };