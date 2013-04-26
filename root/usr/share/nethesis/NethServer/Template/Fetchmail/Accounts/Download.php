<?php

$view->requireFlag($view::INSET_DIALOG);

echo $view->header()->setAttribute('template', $T('download_Header'));

echo "<pre>";
echo $view->textLabel('download');
echo "</pre>";

echo $view->buttonList()
    ->insert($view->button('Close', $view::BUTTON_CANCEL))
;

