<!DOCTYPE html>
<html>

<head>
    <title>Simple Chat</title>
    <link rel="stylesheet" href="./styles.css" />
</head>

<body>
    <div class="container">
        <h1 class="title">Admin Chat</h1>
        <div style="display: flex;">
            <input type="text" id="link_chat" style="width: 100%" />
            <button id="btn_copy">Copy</button>
        </div>

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
    const btn_copy = document.getElementById("btn_copy");
    const link_chat = document.getElementById("link_chat");

    btn_copy.addEventListener("click", function() {
        link_chat.select();
        document.execCommand("copy");
        alert("Đã sao chép link")
    });

    function addLinkChat(roomID, userID) {
        const link = document.getElementById("link_chat")
        const room = document.getElementById("roomID");
        
        link.value = window.location.origin + `/viewer.php?userID=${userID}&room=${roomID}`;
        room.value = roomID;
    }
</script>

<script type="module">
    import {
        Chat
    } from "./assets/js/load_message.js";
    import {
        render
    } from "./assets/js/utils.js"

    const userID = <?php echo "'" . uniqid() . "'"; ?>;
    const clientID = <?php echo "'" . uniqid() . "'"; ?>;
    const roomID = <?php echo "'" . uniqid() . "'"; ?>;

    const chat = new Chat(roomID)
    const btn_send = document.getElementById("send_btn");
    const btn_call = document.getElementById("call_action");
    const msg_inp = document.getElementById("message");

    addLinkChat(roomID, clientID)

    btn_send.addEventListener("click", function() {
        chat.addMessage(msg_inp.value, userID);
        msg_inp.value = '';
    });

    btn_call.addEventListener("submit", function() {
        chat.addMessage('<calling>', userID);
    })

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