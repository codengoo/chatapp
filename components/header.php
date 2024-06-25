<?php
function renderHeader($text) {
    return <<<HTML
    <h1 class="text-white bg-primary text-center p-3">{$text} Chat</h1>
    HTML;
}
