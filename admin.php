<!DOCTYPE html>
<html>

<head>
    <title>Simple Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css" />
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

        <div class="row flex-1 flex-grow-1 overflow-hidden">
            <div class="col d-flex flex-column h-100">
                <div class="bg-gray mb-3 border border-2 border-dark flex-grow-1  p-3 d-flex flex-column gap-3 position-relative overflow-scroll" id="box_msg">
                    <div class="d-flex bg-dark text-white w-100 p-2 justify-content-between position-sticky top-0 left-0 ps-3">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <div class="ping bg-success"></div>
                            <p class="m-0 p-2">People đang gọi</p>
                        </div>
                        <div class="d-flex flex-row gap-2 align-items-center">
                            <button class="btn btn-primary">
                                <img src="./assets/images/call.svg" />
                            </button>
                            <button class="btn btn-danger">
                                <img src="./assets/images/close.svg" />
                            </button>
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
                        <button id="btn_collapse" class="btn btn-warning d-none" type="button">
                            <img src="./assets/images/collapse.svg" />
                        </button>
                    </div>
                </form>
            </div>
            <div class="col d-flex flex-column" id="box_call">
                <div class="bg-secondary flex-grow-1 mb-3"></div>

                <form class="form-group mb-2 d-flex gap-3 justify-content-end">
                    <button id="btn_copy" class="btn btn-success" type="button" title="Gọi thoại">
                        <img src="./assets/images/call.svg" />
                    </button>
                    <button id="btn_copy" class="btn btn-success" type="button" title="Gọi video">
                        <img src="./assets/images/video.svg" />
                    </button>
                    <button id="btn_copy" class="btn btn-danger" type="button" title="Kết thúc" disabled>
                        <img src="./assets/images/close.svg" />
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