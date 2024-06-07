export function render(msgList, userID) {
    // console.log(data);
    const chat_box = document.getElementById('chat_box');
    chat_box.innerHTML = '';

    msgList.forEach(msg => {
        const message = msg.data.message;
        const messageUser = msg.data.user;
        const content = document.createElement('div');

        if (message === '<calling>') {
            if (userID !== messageUser) {
                const btnJoin = document.createElement('a');

                content.innerHTML = userIDinDoc + ' is calling you';
                btnJoin.innerText = 'Join';
                btnJoin.classList.add('btn_join')
                btnJoin.href = doc.data.link
                btnJoin.target = '_blank';

                content.appendChild(btnJoin);
            } else {
                content.innerHTML = 'you are calling everyone';
            }
        } else {
            content.innerHTML = message;
        }

        content.classList.add('block', userID === messageUser ? 'my' : 'your')
        chat_box.appendChild(content)
    })
}

export function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\\[\\]]/g, '\\\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    const results = regex.exec(url);
    if (!results) return null;
    return results[2] || '';
}