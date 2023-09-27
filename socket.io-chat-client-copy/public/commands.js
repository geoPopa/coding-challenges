import { addChatMessage } from "./messages.js";

const handleDateCommand = (response, user) => {
  const daysOfWeek = [
    "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"
  ];
  const dataDate = new Date(response.data);
  const dataDateWeekDayIndex = dataDate.getDay();

  let result = [];
  if (dataDateWeekDayIndex === 0) {
    result = daysOfWeek;
  } else {
    result = daysOfWeek.slice(dataDateWeekDayIndex - 1);
    result.push(...daysOfWeek.slice(0, dataDateWeekDayIndex - 1 ));
  }

  addChatMessage(
    '<div id="command-date">Please select a day: ' + result.map(
      (day) => '<button class="button-date">' + day + '</button>',
      result
    ).join('') + '</div>',
    true
  );

  document.querySelectorAll('.button-date').forEach(
    (buttonEl) => {
      buttonEl.addEventListener(
        'click',
        () => {
        document.getElementById('command-date').innerHTML = user.username + ' ' + buttonEl.innerHTML;
        }
      );
  });
}

const handleMapCommand = (response, user) => {
  addChatMessage(
    '<div id="command-map"></div>',
    true
  );

  new google.maps.Map(document.getElementById("command-map"), {
    center: response.data,
    zoom: 8,
  });
}

const handleRateCommand = (response, user) => {
  let i = response.data[0];
  let j = response.data[1]+1;
  let grades = [...Array(j).keys()].slice(i, j+1);

  addChatMessage(
    '<div id="command-rate">'
      + 'Please rate this conversation: '
      + grades.map((index) => `<button class="button-rate">${index}</button>`).join('')
    + '</div>'
    , true
  );

  document.querySelectorAll('.button-rate').forEach(
    (buttonEl) => {
      buttonEl.addEventListener(
        'click',
        () => {
          document.getElementById('command-rate').innerHTML = user.username
            + ' rated the conversation a ' + buttonEl.innerHTML;
        }
      )
  });
}

const handleCompleteCommand = (response, user) => {
  addChatMessage(
    '<div id="command-complete">Would you like to close the window? '
      + ['yes', 'no'].map(
        (entry) => '<button class="button-complete">' + entry + '</button>',
    ).join('') + '</div>',
    true
  );

  document.querySelectorAll('.button-complete').forEach(
    (buttonEl) => {
      buttonEl.addEventListener(
        'click',
        () => {
          document.getElementById('command-complete').innerHTML = user.username
            + ' chose:  ' + buttonEl.innerHTML;
        }
      )
  });
}

const handleCommandResponse = (response, user) => {
  switch (response.type) {
    case "date":
      handleDateCommand(response, user);
      break;
    case "map":
      handleMapCommand(response, user);
      break;
    case "rate":
      handleRateCommand(response, user);
      break;
    case "complete":
    default:
      handleCompleteCommand(response, user);
  }
}

export { handleCommandResponse };