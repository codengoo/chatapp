function settingCallEvent(callInstance, localVideoEl, remoteVideoEl, callBtn, ansBtn, endBtn, rejectBtn) {
    console.log(localVideoEl, remoteVideoEl);
    callInstance.on('addremotestream', function (stream) {
        console.log('addremotestream');
        remoteVideoEl.srcObject = null;
        remoteVideoEl.srcObject = stream;
    });

    callInstance.on('addlocalstream', function (stream) {
        console.log('addlocalstream');
        localVideoEl.srcObject = null;
        localVideoEl.srcObject = stream;
    });

    callInstance.on('signalingstate', function (state) {
        console.log('signalingstate ', state);

        if (state.code === 6 || state.code === 5) {
            callBtn.show();
            endBtn.hide();
            rejectBtn.hide();
            ansBtn.hide();
            localVideoEl.srcObject = null;
            remoteVideoEl.srcObject = null;
            $('#coming_msg').hide();
        }
    });

    callInstance.on('mediastate', function (state) {
        console.log('mediastate ', state);
    });

    callInstance.on('info', function (info) {
        console.log('on info:' + JSON.stringify(info));
    });
}

jQuery(function () {
    try {
        var localVideo = document.getElementById('vid_local');
        var remoteVideo = document.getElementById('vid_remote');

        var callButton = $('#btn_video');
        var answerCallButton = $('#btn_answer');
        var rejectCallButton = $('#btn_reject');
        var endCallButton = $('#btn_end');
        var coming_msg = $('#coming_msg');

        var currentCall = null;
        endCallButton.hide();
        coming_msg.hide();

        var client = new StringeeClient();
        client.connect(token);

        client.on('connect', function () {
            console.log('stringee connected!');
        });

        client.on('authen', function (res) {
            console.log('stringee authenticated: ', res);
        });

        client.on('disconnect', function (res) {
            console.log('stringee disconnected');
        });

        //MAKE CALL
        callButton.on('click', function () {
            currentCall = new StringeeCall(client, callerId, calleeId, true);

            settingCallEvent(
                currentCall, localVideo, remoteVideo,
                callButton, answerCallButton, endCallButton, rejectCallButton
            );

            currentCall.makeCall(function (res) {
                console.log('stringee call callback: ', res);
                if (res.message === 'SUCCESS') {
                    document.dispatchEvent(new Event('connect_ok'));
                }
            });

        });

        //RECEIVE CALL
        client.on('incomingcall', function (incomingcall) {
            $('#coming_msg').show();
            currentCall = incomingcall;
            settingCallEvent(currentCall, localVideo, remoteVideo, callButton, answerCallButton, endCallButton, rejectCallButton);

            callButton.hide();
            answerCallButton.show();
            rejectCallButton.show();
        });

        //Event handler for buttons
        answerCallButton.on('click', function () {
            $('#coming_msg').hide();
            rejectCallButton.hide();
            endCallButton.show();
            callButton.hide();
            console.log('current call ', currentCall, typeof currentCall);
            if (currentCall != null) {
                currentCall.answer(function (res) {
                    console.log('stringee answering call: ', res);
                });
            }
        });

        rejectCallButton.on('click', function () {
            $('#coming_msg').hide();
            if (currentCall != null) {
                currentCall.reject(function (res) {
                    console.log('stringee reject call: ', res);
                });
            }

            callButton.show();
            answerCallButton.hide();
        });

        endCallButton.on('click', function () {
            if (currentCall != null) {
                currentCall.hangup(function (res) {
                    console.log('stringee hangup: ', res);
                });
            }

            callButton.show();
            endCallButton.hide();
        });

        document.addEventListener('connect_ok', function () {
            callButton.hide();
            endCallButton.show();
        });
    } catch (error) {
        alert("Error")
    }
});