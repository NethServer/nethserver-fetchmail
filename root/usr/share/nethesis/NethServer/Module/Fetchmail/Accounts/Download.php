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

/**
 * Check mail for fetchmail accounts
 *
 * @author Giacomo Sanchietti <giacomo.sanchietti@nethesis.it>
 */
class Download extends \Nethgui\Controller\Table\AbstractAction
{
    public function process()
    {
        $this->getPlatform()->exec('/usr/bin/sudo /usr/libexec/nethserver/fetchmail-wakeup');
        parent::process();
    }
 
    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
         $view['download'] = $view->translate("see_log_label"); 
    }
}
