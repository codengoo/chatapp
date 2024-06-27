import { render } from "./utils.js"
import { getConstants } from "./constants.js"

const { chat, userID } = getConstants();
console.log(userID);

const btn_send = document.getElementById("btn_send");
const inp_msg = document.getElementById("inp_msg");
const box_msg = document.getElementById("box_msg");

btn_send.addEventListener("click", function (e) {
    chat.addMessage(inp_msg.value, userID);
    inp_msg.value = '';
});

inp_msg.addEventListener("keydown", function (event) {
    if (event.key === "Enter") btn_send.click();
})

chat.onChange((data) => {
    render(box_msg, data, userID);
});