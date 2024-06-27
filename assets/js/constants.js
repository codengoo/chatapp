import { Chat } from "./chat.js";

const agent = document.getElementById("agent").value;
const clientID = document.getElementById("agent_clientID").value;
const adminID = document.getElementById("agent_adminID").value;
const roomID = document.getElementById("agent_roomID").value;
const chat = new Chat(roomID)

export function getConstants() {
    if (agent === "admin") {
        return {
            userID: adminID,
            roomID,
            chat
        }
    } else {
        return {
            userID: clientID,
            roomID,
            chat
        }
    }
}