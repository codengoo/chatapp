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

        <?php include_once("./components/content.php"); ?>
    </div>
</body>

<script src="./assets/js/ui.js"></script>
<script>
    var token = 'eyJjdHkiOiJzdHJpbmdlZS1hcGk7dj0xIiwidHlwIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJTSy4wLnZGc0ZReU9NeUJkT1cwTU5ybWNQZ3hvZU04UjlJc1ItMTcxOTA1NjIwNCIsImlzcyI6IlNLLjAudkZzRlF5T015QmRPVzBNTnJtY1BneG9lTThSOUlzUiIsImV4cCI6MTcyMTY0ODIwNCwidXNlcklkIjoiY2xpZW50MSJ9.0SpEQhAzBFs7kAmn8cfi0CjweLYuJb_zA1NGks_2jyU';
    var callerId = 'client1';
    var calleeId = 'admin';
</script>

<script src="./assets/js/stringee.js"></script>

<script type="module">
    import {
        Chat
    } from "./assets/js/load_message.js";
    import {
        render,
        getParameterByName
    } from "./assets/js/utils.js"

    // const userID = getParameterByName('userID');
    // const roomID = getParameterByName('room');
    const userID = "66764ff19fafb";
    const roomID = "66764ff19fd02";

    // if (!userID || !roomID) {
    //     alert("Sai đường dẫn");
    //     window.location.href = 'https://www.google.com.vn/?hl=vi'
    // }

    const chat = new Chat(roomID)
    const btn_send = document.getElementById("btn_send");
    const inp_msg = document.getElementById("inp_msg");
    const box_msg = document.getElementById("box_msg");

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