<form class="form-group mb-2" onsubmit="return false;">
    <div class="d-flex gap-3">
        <input type="text" class="form-control" id="inp_msg" placeholder="Viết tin nhắn ở đây">
        <audio controls id="audio_preview" class="flex-grow-1"></audio>
        <div id="count_time_record" class="bg-primary text-white p-2 fw-bold flex-grow-1 text-start">00:00:00</div>

        <button id="btn_expand" class="btn btn-warning" type="button">
            <img src="./assets/images/expand.svg" />
        </button>
        <button id="btn_call" class="btn btn-success" type="button" title="Gọi thoại">
            <img src="./assets/images/call.svg" />
        </button>
        <button id="btn_delete" class="btn btn-danger" type="button" title="Kết thúc nhắn thoại">
            <img src="./assets/images/delete.svg" />
        </button>
        <button id="btn_stop" class="btn btn-danger" type="button" title="Kết thúc nhắn thoại">
            <img src="./assets/images/stop.svg" />
        </button>
        <button id="btn_record" class="btn btn-info" type="button" title="Tin nhắn thoại">
            <img src="./assets/images/mic.svg" />
        </button>

        <button id="btn_send" class="btn btn-primary" type="button">
            <img src="./assets/images/send.svg" />
        </button>
        <button id="btn_send_audio" class="btn btn-primary" type="button">
            <img src="./assets/images/send.svg" />
        </button>
    </div>
</form>