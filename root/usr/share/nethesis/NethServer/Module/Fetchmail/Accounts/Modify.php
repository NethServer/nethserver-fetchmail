<?php
namespace NethServer\Module\Fetchmail\Accounts;

/*
 * Copyright (C) 2012 Nethesis S.r.l.
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use Nethgui\System\PlatformInterface as Validate;
use Nethgui\Controller\Table\Modify as Table;

/**
 * Modify domain
 *
 * Generic class to create/update/delete fetchmail accounts
 * 
 * @author Giacomo Sanchietti <giacomo.sanchietti@nethesis.it>
 */
class Modify extends \Nethgui\Controller\Table\Modify
{

    public function initialize()
    {
        $ynv = $this->createValidator()->memberOf(array('YES','NO'));
        $parameterSchema = array(
            array('mail', Validate::EMAIL, \Nethgui\Controller\Table\Modify::KEY),
            array('account', Validate::ANYTHING, \Nethgui\Controller\Table\Modify::FIELD),
            array('nokeep', $ynv, \Nethgui\Controller\Table\Modify::FIELD),
            array('password', Validate::ANYTHING, \Nethgui\Controller\Table\Modify::FIELD),
            array('popserver', Validate::HOSTADDRESS, \Nethgui\Controller\Table\Modify::FIELD),
            array('username', Validate::ANYTHING, \Nethgui\Controller\Table\Modify::FIELD),
            array('ssl', $ynv, \Nethgui\Controller\Table\Modify::FIELD),
            array('proto',  $this->createValidator()->memberOf(array('pop3','imap')), \Nethgui\Controller\Table\Modify::FIELD),
            array('active', $ynv, \Nethgui\Controller\Table\Modify::FIELD),
        );

        $this->setSchema($parameterSchema);
        $this->setDefaultValue('nokeep', 'YES');
        $this->setDefaultValue('active', 'YES');
        $this->setDefaultValue('ssl', 'NO');
        $this->setDefaultValue('proto', 'pop3');

        parent::initialize();
    }


    public function bind(\Nethgui\Controller\RequestInterface $request)
    {
        parent::bind($request);
        if ($this->getRequest()->isMutation()) {
            $this->parameters['active'] = 'YES';
        }
    }

 
    public function process()
    {
        parent::process();
    }


    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);
        $templates = array(
            'create' => 'NethServer\Template\Fetchmail\Accounts\Modify',
            'update' => 'NethServer\Template\Fetchmail\Accounts\Modify',
            'delete' => 'Nethgui\Template\Table\Delete',
        );
        $view->setTemplate($templates[$this->getIdentifier()]);

        $ynds = array(array('YES',$view->translate('YES_label')),array('NO',$view->translate('NO_label')));
        $view['nokeepDatasource'] = $ynds;
        $view['sslDatasource'] = $ynds;
        $view['protoDatasource'] = array(array('pop3',$view->translate('pop3_label')),array('imap',$view->translate('imap_label')));

        if($this->getRequest()->isValidated()) {
            $view['accountDatasource'] = $this->getAccounts($view);
        }
    }

    private function getAccounts(\Nethgui\View\ViewInterface $view)
    {
        static $ds;

        if(isset($ds)) {
            return $ds;
        }

        $data = json_decode($this->getPlatform()->exec("/usr/bin/sudo /usr/libexec/nethserver/read-mail-accounts")->getOutput(), TRUE);

        $users = \Nethgui\Widget\XhtmlWidget::hashToDatasource($data['users'], TRUE);
        $groups = \Nethgui\Widget\XhtmlWidget::hashToDatasource($data['groups'], TRUE);

        $ds = array();

        if ($users) {
            $ds[] = array($users, $view->translate('Users_label'));
        }

        if ($groups) {
            $ds[] = array($groups, $view->translate('Groups_label'));
        }

        return $ds;
    }

    /**
     * Delete the record after the event has been successfully completed
     * @param string $key
     */
    protected function processDelete($key)
    {
        parent::processDelete($key);
    }

    protected function onParametersSaved($changedParameters)
    {
        $this->getPlatform()->signalEvent('nethserver-fetchmail-save');
    }

}
