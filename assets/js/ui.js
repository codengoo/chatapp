const box_msg2 = document.getElementById("box_msg");

function scrollToBottom() {
    box_msg2.scrollTop = box_msg2.scrollHeight;
}

scrollToBottom();
box_msg2.addEventListener('DOMNodeInserted', scrollToBottom);