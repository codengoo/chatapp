<!DOCTYPE html>
<html>

<head>
    <title>Meet - Join Room</title>
</head>


<script>
    function addLinkChat(roomID, userID) {
        const room = document.getElementById("roomID");
        room.value = roomID;
    }
</script>
<script>
    function getParameterByName(name, url = window.location.href) {
        name = name.replace(/[\\[\\]]/g, '\\\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        return results[2] || '';
    }

    function render(data, userID, roomID) {
        let tmp = [];
        data.forEach(doc => {
            tmp.push({
                id: doc.id,
                data: doc.data()
            })
        })

        tmp = tmp.sort((a, b) => {
            const a_sec = a.data.created.seconds
            const b_sec = b.data.created.seconds

            if (a_sec != b_sec) {
                if (a_sec < b_sec) return -1;
                else return 1;
            } else {
                const a_m = a.data.created.nanoseconds
                const b_m = a.data.created.nanoseconds

                if (a_m < b_m) return -1;
                else if (a_m > b_m) return 1;
                else return 0;
            }
        })

        const box = document.getElementById('chat_box');
        box.innerHTML = '';

        tmp.forEach(doc => {
            const messageContent = doc.data.message;
            const userIDinDoc = doc.data.user
            const content = document.createElement('div');

            if (messageContent === '<calling>') {
                if (userID !== userIDinDoc) {
                    content.innerHTML = userIDinDoc + ' is calling you ';
                    const btnJoin = document.createElement('a');
                    btnJoin.innerText = 'Join';
                    btnJoin.classList.add('btn_join')
                    btnJoin.href = doc.data.link;
                    btnJoin.target = '_blank';
                    content.appendChild(btnJoin);
                } else {
                    content.innerHTML = 'you are calling everyone';
                }
            } else {
                content.innerHTML = messageContent;
            }

            content.classList.add('block', userID === userIDinDoc ? 'my' : 'your')
            box.appendChild(content)
        })
    }
</script>

<script type="module">
    import {
        initializeApp
    } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js';
    import {
        getFirestore,
        collection,
        getDocs,
        addDoc,
        onSnapshot,
        Timestamp
    } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js';

    const firebaseConfig = {
        apiKey: "AIzaSyBAIEGurw4Y_wVUuYy_3FPo65tMhHr3XXU",
        authDomain: "chatapp-d3a8f.firebaseapp.com",
        projectId: "chatapp-d3a8f",
        storageBucket: "chatapp-d3a8f.appspot.com",
        messagingSenderId: "120584822548",
        appId: "1:120584822548:web:14c6074a34cf8b89116c01"
    };

    // const userID = getParameterByName('userID');
    // const roomID = getParameterByName('room');

    const userID = "6664293a52b77";
    const roomID = "6664293a52b78"

    if (!userID || !roomID) {
        alert("Sai đường dẫn");
        window.location.href = 'https://www.google.com.vn/?hl=vi'
    }
    addLinkChat(roomID, userID);
    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);
    const msgCollection = collection(db, 'data', 'message', roomID);
    const querySnapshot = await getDocs(msgCollection);

    render(querySnapshot, userID);

    const btn = document.getElementById("send_btn");
    const messageInp = document.getElementById("message");
    const btn_call = document.getElementById("call_action");

    btn_call.addEventListener("submit", function() {
        addDoc(msgCollection, {
            message: '<calling>',
            user: userID,
            created: Timestamp.now(),
            link: window.location.origin + '/call.php?room=' + roomID
        });
    })

    btn.addEventListener("click", function() {
        if (messageInp.value.trim() === '') {
            alert("Phải có nội dung trước khi gửi")
        } else {
            addDoc(msgCollection, {
                message: messageInp.value,
                user: userID,
                created: Timestamp.now(),
                room: roomID
            });
            messageInp.value = '';
        }
    });

    messageInp.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            btn.click()
        }
    })

    const unsubscribe = onSnapshot(msgCollection, (snapshot) => {
        render(snapshot, userID);
    });
</script>

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

<style>
    .btn_join {
        background-color: greenyellow;
        padding: 5px;
        border-radius: 5px;
    }

    .block {
        padding: 10px;
        border-radius: 10px;
        margin: 10px;
    }

    .your {
        background-color: white;
        text-align: left;
    }

    .my {
        background-color: black;
        text-align: right;
        color: white
    }

    html>body {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    .container {
        background-color: aliceblue;
        padding: 20px;
        border-radius: 10px;
        border-width: 2px;
        border-color: black;
    }

    .title {
        text-align: center;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn {
        height: 30px;
        font-weight: bold;
    }

    .wrapper {
        display: flex;
        flex-direction: row;
        gap: 50px;
    }

    .chat-bottom {
        display: flex;
        flex-direction: "row";
        gap: 10px;
    }

    .chat {
        height: 50vh;
        width: 400px;
        background-color: #d9d9d9;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    #message {
        width: 100%;
    }
</style>

</html>