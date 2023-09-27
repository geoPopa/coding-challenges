import { initLoginInput } from "./login.js";
import { addChatMessage, initMessageInput } from "./messages.js";
import { handleCommandResponse } from "./commands.js";

const socket = io('https://demo-chat-server.on.ag/');
let user = {
  username: null
};

socket.on('message', (data) => {
  addChatMessage(data.message);
});

socket.on('command', (data) => {
  handleCommandResponse(data.command, user);
});

(() => {
    initLoginInput(user);
    initMessageInput(socket, user);
    socket.emit('command');
  }
)();
