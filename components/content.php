<div class="flex-1 flex-grow-1 overflow-hidden row">
    <div class="col d-flex flex-column h-100 col-12 col-xl-6 order-1" id="chat_call">
        <?php include_once("incoming_message.php"); ?>
        <?php include_once("input.php"); ?>
    </div>

    <div class="col d-flex flex-column h-100 col-12 col-xl-6 order-2" id="box_call">
        <?php include_once("video.php"); ?>
        <?php include_once("video_control.php"); ?>
    </div>
</div>