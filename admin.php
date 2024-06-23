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
        <h1 class="text-white bg-primary text-center p-3">Admin Chat</h1>

        <div class="form-group mb-5">
            <label class="mb-1" for="room">Gửi link này cho người dùng: </label>
            <div class="d-flex gap-3">
                <input type="text" class="form-control" id="link_chat" disabled>
                <button id="btn_copy" class="btn btn-primary" type="button">Copy</button>
            </div>
        </div>

        <div class="flex-1 flex-grow-1 overflow-hidden row">
            <div class="col d-flex flex-column h-100 col-12 col-xl-6 order-2">
                <div class="bg-gray mb-3 border border-2 border-dark flex-grow-1 p-3 d-flex flex-column gap-3 position-relative overflow-scroll" id="box_msg">
                    <div class="position-sticky top-0 left-0" id="coming_msg">
                        <div class="d-flex bg-dark text-white w-100 p-2 justify-content-between ps-3">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <div class="ping bg-success"></div>
                                <p class="m-0 p-2">People đang gọi</p>
                            </div>
                            <div class="d-flex flex-row gap-2 align-items-center">
                                <button class="btn btn-primary" id="btn_answer">
                                    <img src="./assets/images/call.svg" />
                                </button>
                                <button class="btn btn-danger" id="btn_reject">
                                    <img src="./assets/images/close.svg" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="form-group mb-2" onsubmit="return false;">
                    <div class="d-flex gap-3">
                        <input type="text" class="form-control" id="inp_msg" placeholder="Viết tin nhắn ở đây">
                        <button id="btn_send" class="btn btn-primary" type="button">
                            <img src="./assets/images/send.svg" />
                        </button>
                        <button id="btn_expand" class="btn btn-warning" type="button">
                            <img src="./assets/images/expand.svg" />
                        </button>
                    </div>
                </form>
            </div>

            <div class="col d-flex flex-column h-100 col-12 col-xl-6 order-1" id="box_call">
                <div class="bg-secondary flex-grow-1 mb-3 position-relative overflow-hidden">
                    <video id="vid_local" autoplay muted playsinline class="w-25 position-absolute top-0 left-0"></video>
                    <video id="vid_remote" autoplay playsinline style="height: 100%; width:100%"></video>
                </div>

                <form class="form-group mb-2 d-flex gap-3 justify-content-end">
                    <button id="btn_call" class="btn btn-success" type="button" title="Gọi thoại">
                        <img src="./assets/images/call.svg" />
                    </button>
                    <button id="btn_video" class="btn btn-success" type="button" title="Gọi video">
                        <img src="./assets/images/video.svg" />
                    </button>
                    <button id="btn_switch" class="btn btn-success" type="button" title="Lật cam">
                        <img src="./assets/images/switch.svg" />
                    </button>
                    <button id="btn_end" class="btn btn-danger" type="button" title="Kết thúc">
                        <img src="./assets/images/close.svg" />
                    </button>
                    <button id="btn_collapse" class="btn btn-warning" type="button">
                        <img src="./assets/images/collapse.svg" />
                    </button>
                </form>
            </div>
        </div>
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
        link.value = window.location.origin + `/viewer.php?userID=${userID}&room=${roomID}`;
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

    const clientID = <?php echo "'" . uniqid() . "'"; ?>;
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