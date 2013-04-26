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
 * Configure port forward
 */
class Accounts extends \Nethgui\Controller\TableController
{
    public function initialize()
    {

        $columns = array(
            'Key',
            'Actions'
        );

        $this
            ->setTableAdapter($this->getPlatform()->getTableAdapter('fetchmail','fetchmail'))
            ->setColumns($columns)
            ->addTableAction(new \NethServer\Module\Fetchmail\Accounts\Modify('create'))            
            ->addTableAction(new \NethServer\Module\Fetchmail\Accounts\Download('Download'))            
            ->addTableAction(new \Nethgui\Controller\Table\Help('Help'))
            ->addRowAction(new \NethServer\Module\Fetchmail\Accounts\ToggleEnable('disable'))
            ->addRowAction(new \NethServer\Module\Fetchmail\Accounts\ToggleEnable('enable'))
            ->addRowAction(new \NethServer\Module\Fetchmail\Accounts\Modify('update'))
            ->addRowAction(new \NethServer\Module\Fetchmail\Accounts\Modify('delete'))
        ;

        parent::initialize();
    }

    public function prepareViewForColumnKey(\Nethgui\Controller\Table\Read $action, \Nethgui\View\ViewInterface $view, $key, $values, &$rowMetadata)
    {
        if (!isset($values['active']) || ($values['active'] == "NO")) {
            $rowMetadata['rowCssClass'] = trim($rowMetadata['rowCssClass'] . ' user-locked');
        }
        return strval($key);
    }

    /**
     * Override prepareViewForColumnActions to hide/show enable/disable actions
     * @param \Nethgui\View\ViewInterface $view
     * @param string $key The data row key
     * @param array $values The data row values
     * @return \Nethgui\View\ViewInterface 
     */
    public function prepareViewForColumnActions(\Nethgui\Controller\Table\Read $action, \Nethgui\View\ViewInterface $view, $key, $values, &$rowMetadata)
    {
        $cellView = $action->prepareViewForColumnActions($view, $key, $values, $rowMetadata);

        $killList = array();

        $state = isset($values['active']) ? $values['active'] : 'YES';

        switch ($state) {
            case 'YES':
                $remove = 'enable';
                break;
            case 'NO';
                $remove = 'disable';
                break;
            default:
                break;
        }

        unset($cellView[$remove]);

        return $cellView;
    }
        
}

