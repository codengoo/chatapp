<!DOCTYPE html>
<html>

<head>
    <title>Simple Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css" />
    <script src="./assets/js/libs/jquery.js"></script>
    <script src="./assets/js/libs/stringeeSDK.js"></script>
    <script src="./assets/js/libs/socket.js"></script>
</head>

<body>
    <div class="container bg-light p-2 vh-100 d-flex flex-column ">
        <?php
        include_once("./components/header.php");
        echo renderHeader("Admin");
        ?>
        <?php include_once("./components/address_box.php"); ?>

        <?php include_once("./components/content.php"); ?>
    </div>
</body>

<script src="./assets/js/ui.js"></script>

<script>
    const btn_copy = document.getElementById("btn_copy");
    const link_chat = document.getElementById("link_chat");

    btn_copy.addEventListener("click", function() {
        navigator.clipboard.writeText(link_chat.value)
        alert("Đã sao chép link")
    });

    function addLinkChat(roomID, userID) {
        const link = document.getElementById("link_chat")
        // link.value = window.location.origin + `/viewer.php?userID=${userID}&room=${roomID}`;
        link.value = window.location.origin + `/viewer.php`;
    }
</script>

<script>
    var token = 'eyJjdHkiOiJzdHJpbmdlZS1hcGk7dj0xIiwidHlwIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJTSy4wLnZGc0ZReU9NeUJkT1cwTU5ybWNQZ3hvZU04UjlJc1ItMTcxOTA1NDkxOCIsImlzcyI6IlNLLjAudkZzRlF5T015QmRPVzBNTnJtY1BneG9lTThSOUlzUiIsImV4cCI6MTcyMTY0NjkxOCwidXNlcklkIjoiYWRtaW4ifQ.DmyXoTrih7WA7LyRF4gKAPIA-lcAX0rwME-rF_uEtsc';
    var callerId = 'admin';
    var calleeId = 'client1';
</script>

<script src="./assets/js/stringee.js"></script>

<script type="module">
    import {
        Chat
    } from "./assets/js/load_message.js";
    import {
        render
    } from "./assets/js/utils.js"

    // const userID = <?php echo "'" . uniqid() . "'"; ?>;
    // const clientID = <?php echo "'" . uniqid() . "'"; ?>;
    // const roomID = <?php echo "'" . uniqid() . "'"; ?>;

    const clientID = "66764ff19fafb";
    const userID = "66764ff19fcfe";
    const roomID = "66764ff19fd02";

    const chat = new Chat(roomID)
    const btn_send = document.getElementById("btn_send");
    const inp_msg = document.getElementById("inp_msg");
    const box_msg = document.getElementById("box_msg");

    addLinkChat(roomID, clientID)

    btn_send.addEventListener("click", function(e) {
        chat.addMessage(inp_msg.value, userID);
        inp_msg.value = '';
    });

    inp_msg.addEventListener("keydown", function(event) {
        if (event.key === "Enter") btn_send.click();
    })

    chat.onChange((data) => {
        render(box_msg, data, userID);
    });
</script>

</html>