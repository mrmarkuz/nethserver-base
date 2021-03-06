<?php

namespace NethServer\Module\FirstConfigWiz;

/*
 * Copyright (C) 2014  Nethesis S.r.l.
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
 * TODO: add component description here
 *
 * @author Davide Principi <davide.principi@nethesis.it>
 * @since 1.6
 */
class Cover extends \Nethgui\Controller\AbstractController {

    public $wizardPosition = 0;

    public function process() {
        parent::process();
        if ($this->getRequest()->hasParameter('skip')) {
            $sessDb = $this->getPlatform()->getDatabase('SESSION');
            $sessDb->deleteKey(get_class($this->getParent()));
            $sessDb->setType(get_class($this->getParent()), array());
        }
    }

    public function nextPath() {
        if ($this->getRequest()->hasParameter('skip')) {
            $successor = $this->getParent()->getSuccessor($this);
            return $successor ? $successor->getIdentifier() : 'Review';
        }
        return parent::nextPath();
    }

    public function prepareView(\Nethgui\View\ViewInterface $view) {
        parent::prepareView($view);
        $view->copyFrom($this->getPlatform()->getDatabase('configuration')->getKey('sysconfig'));
    }

}
