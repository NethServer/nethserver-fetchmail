<?php
namespace NethServer\Module\Fetchmail;

/*
 * Copyright (C) 2011 Nethesis S.r.l.
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

/**
 * Change the system time settings
 *
 * @author Giacomo Sanchietti <giacomo.sanchietti@nethesis.i>
 */
class General extends \Nethgui\Controller\AbstractController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->declareParameter('status', Validate::SERVICESTATUS, array('configuration', 'fetchmail', 'status'));        
        $this->declareParameter('externalFreq', Validate::POSITIVE_INTEGER, array('configuration', 'fetchmail', 'externalFreq'));        

    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);

        $view['statusDatasource'] = array(array('enabled',$view->translate('enabled_label')),array('disabled',$view->translate('disabled_label')));
        $view['externalFreqDatasource'] =  array_map(function($fmt) use ($view) {
            return array($fmt, $view->translate($fmt . '_label'));
        }, array(5, 10, 15, 30, 60));

    }


    protected function onParametersSaved($changedParameters)
    {
        $this->getPlatform()->signalEvent('nethserver-fetchmail-save@post-process');
    }

}
