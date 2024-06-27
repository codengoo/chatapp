<?php
$clientID = "66764ff19fafb";
$adminID = "66764ff19fcfe";
$roomID = "66764ff19fd02";
?>

<script>
    const clientID = '<?php echo $clientID; ?>';
    const userID = '<?php echo $adminID; ?>';
    const roomID = '<?php echo $roomID; ?>';
</script>

<input type="text" value="admin" hidden id="agent">
<input type="text" value=<?php echo $clientID; ?> hidden id="agent_clientID">
<input type="text" value=<?php echo $adminID; ?> hidden id="agent_adminID">
<input type="text" value=<?php echo $roomID; ?> hidden id="agent_roomID">