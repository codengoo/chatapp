var IS_FIRST_LOAD = true;

export function render(el, msgList, userID) {
    if (IS_FIRST_LOAD) {
        msgList.forEach(msg => buildContent(el, msg, userID));
        IS_FIRST_LOAD = false;
    } else if (msgList.length > 0) {
        buildContent(el, msgList[msgList.length - 1], userID);
    }
}

export function buildContent(el, msg, userID) {
    const content = document.createElement('div');
    const message = msg.data.message;
    const messageUser = msg.data.user;
    const type = msg.data.type;
    const agent = document.getElementById("agent").value;
    const myAvatar = agent === "admin" ? "./assets/images/admin.png" : "./assets/images/client.jpg";
    const yourAvatar = agent === "admin" ? "./assets/images/client.jpg" : "./assets/images/admin.png";


    content.innerHTML = userID === messageUser
        ? renderMyMessage(1, message, type, myAvatar)
        : renderYourMessage(1, message, type, yourAvatar);

    el.appendChild(content)
}

function renderText(message, type) {
    if (type === "my") {
        return (
            `<p class="m-0 p-2 flex-grow-1 bg-primary text-right">${message}</p>`
        )
    } else {
        return (
            `<p class="m-0 p-2 flex-grow-1 bg-dark text-left">${message}</p>`
        )
    }
}

function renderAudio(url) {
    return (
        `<audio controls class="flex-grow-1" src="${url}"></audio>`
    )
}

function renderAvatar(url) {
    return (
        `<img class="rounded-circle image" src="${url}" alt="avatar">`
    )
}

export function renderMyMessage(time, message, type, avatar) {
    return (
        `<div class="d-flex justify-content-end">
            <div class="d-flex justify-content-between w-75 text-white text-right gap-2 ">
                ${type === 'audio' ? renderAudio(message) : renderText(message, "my")}
                ${renderAvatar(avatar)}
            </div>
        </div>`
    )
}

export function renderYourMessage(time, message, type, avatar) {
    return (
        `<div class="d-flex justify-content-start">
            <div class="d-flex justify-content-between w-75 text-white text-right gap-2 ">
                ${renderAvatar(avatar)}
                ${type === 'audio' ? renderAudio(message) : renderText(message, "your")}
            </div>
        </div>`
    )
}

export function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\\[\\]]/g, '\\\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    const results = regex.exec(url);
    if (!results) return null;
    return results[2] || '';
}