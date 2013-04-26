<?php

if ($view->getModule()->getIdentifier() == 'update') {
    $headerText = 'update_header_label';
} else {
    $headerText = 'create_header_label';
}

echo $view->header()->setAttribute('template',$T($headerText));

echo $view->panel()
    ->insert($view->textInput('mail'))
    ->insert($view->textInput('popserver'))
    ->insert($view->textInput('username'))
    ->insert($view->textInput('password'))
    ->insert($view->selector('account',  $view::SELECTOR_DROPDOWN))
    ->insert($view->selector('ssl'))
    ->insert($view->selector('nokeep'));

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_CANCEL | $view::BUTTON_HELP);

