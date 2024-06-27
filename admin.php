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

    <script>
        var token = 'eyJjdHkiOiJzdHJpbmdlZS1hcGk7dj0xIiwidHlwIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJTSy4wLnZGc0ZReU9NeUJkT1cwTU5ybWNQZ3hvZU04UjlJc1ItMTcxOTA1NDkxOCIsImlzcyI6IlNLLjAudkZzRlF5T015QmRPVzBNTnJtY1BneG9lTThSOUlzUiIsImV4cCI6MTcyMTY0NjkxOCwidXNlcklkIjoiYWRtaW4ifQ.DmyXoTrih7WA7LyRF4gKAPIA-lcAX0rwME-rF_uEtsc';
        const callerId = 'admin';
        const calleeId = 'client1';
    </script>
</head>

<body>
    <?php include_once("./components/admin_code.php"); ?>
    <div class="container bg-light p-2 vh-100 d-flex flex-column ">
        <?php
        include_once("./components/header.php");
        echo renderHeader("Admin");
        ?>
        <?php include_once("./components/address_box.php"); ?>

        <?php include_once("./components/content.php"); ?>
    </div>
</body>

<script src="./assets/js/stringee.js"></script>

<script type="module" src="./assets/js/chat_ui.js"></script>
<script type="module" src="./assets/js/voice.js"></script>

</html>