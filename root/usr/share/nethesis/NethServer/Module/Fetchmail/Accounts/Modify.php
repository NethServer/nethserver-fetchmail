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
            array('account', Validate::USERNAME, \Nethgui\Controller\Table\Modify::FIELD),
            array('nokeep', $ynv, \Nethgui\Controller\Table\Modify::FIELD),
            array('password', Validate::ANYTHING, \Nethgui\Controller\Table\Modify::FIELD),
            array('popserver', Validate::HOSTADDRESS, \Nethgui\Controller\Table\Modify::FIELD),
            array('username', Validate::USERNAME, \Nethgui\Controller\Table\Modify::FIELD),
            array('ssl', $ynv, \Nethgui\Controller\Table\Modify::FIELD),
        );

        $this->setSchema($parameterSchema);
        $this->setDefaultValue('nokeep', 'YES');
        $this->setDefaultValue('active', 'YES');
        $this->setDefaultValue('ssl', 'NO');

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
        
        $view['accountDatasource'] = new \NethServer\Module\Pseudonym\AccountDatasource($this, $view->getTranslator(), $view['Account']);
        $ynds = array(array('YES',$view->translate('YES_label')),array('NO',$view->translate('NO_label')));
        $view['nokeepDatasource'] = $ynds;
        $view['sslDatasource'] = $ynds;
 
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
        $this->getPlatform()->signalEvent('nethserver-fetchmail-save@post-process');
    }

}
