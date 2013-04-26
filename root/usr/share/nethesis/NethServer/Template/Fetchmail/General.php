<?php

echo $view->header()->setAttribute('template', 'Fetchmail');

echo $view->selector('status');
echo $view->selector('externalFreq', $view::SELECTOR_DROPDOWN);

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_HELP);
