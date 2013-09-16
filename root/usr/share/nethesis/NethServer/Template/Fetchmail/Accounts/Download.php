<?php

$view->requireFlag($view::INSET_DIALOG);

echo $view->header()->setAttribute('template', $T('download_Header'));

echo "<p>";
echo $view->textLabel('download');
echo "</p>";

echo $view->buttonList()
    ->insert($view->button('Close', $view::BUTTON_CANCEL))
;

