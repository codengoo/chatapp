<div class="form-group mb-5">
    <label class="mb-1" for="room">Gửi link này cho người dùng: </label>
    <div class="d-flex gap-3">
        <input type="text" class="form-control" id="link_chat" disabled>
        <button id="btn_copy" class="btn btn-primary" type="button">Copy</button>
    </div>
</div>

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
    
    addLinkChat(roomID, clientID)
</script>