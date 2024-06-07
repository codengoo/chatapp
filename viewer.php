<!DOCTYPE html>
<html>

<head>
    <title>Room chat</title>
    <link rel="stylesheet" href="./styles.css" />
</head>

<body>
    <div class="container">
        <h1 class="title">Chat</h1>

        <div class="chat" id="chat_box">
        </div>

        <div style="display: flex; width: 100%">
            <input type="text" id="message" name="message" placeholder="MeetingRoom">
            <button class="btn" id="send_btn">Send</button>
            <form action="handle.php" method="post" class="form" target="_blank" id="call_action">
                <input type="submit" value="Call" class="btn">
                <input type="hidden" name="roomID" id="roomID">
            </form>
        </div>
    </div>
</body>

<script>
    function addLinkChat(roomID, userID) {
        const room = document.getElementById("roomID");
        room.value = roomID;
    }
</script>

<script type="module">
    import {
        Chat
    } from "./assets/js/load_message.js";
    import {
        render,
        getParameterByName
    } from "./assets/js/utils.js"

    const userID = getParameterByName('userID');
    const roomID = getParameterByName('room');

    if (!userID || !roomID) {
        alert("Sai đường dẫn");
        window.location.href = 'https://www.google.com.vn/?hl=vi'
    }

    const chat = new Chat(roomID)
    const btn_send = document.getElementById("send_btn");
    const btn_call = document.getElementById("call_action");
    const msg_inp = document.getElementById("message");

    addLinkChat(roomID, userID);

    btn_call.addEventListener("submit", function() {
        chat.addMessage('<calling>', userID);
    })

    btn_send.addEventListener("click", function() {
        chat.addMessage(msg_inp.value, userID);
        msg_inp.value = '';
    });

    msg_inp.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            btn_send.click()
        }
    })

    chat.onChange((data) => {
        render(data, userID);
    });
</script>

</html>