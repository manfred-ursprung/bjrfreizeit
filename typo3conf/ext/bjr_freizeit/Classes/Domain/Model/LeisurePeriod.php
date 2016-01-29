<?php
namespace MUM\BjrFreizeit\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * LeisurePeriod
 */
class LeisurePeriod extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * startPeriod
     *
     * @var string
     */
    protected $startPeriod = '';
    
    /**
     * endPeriod
     *
     * @var string
     */
    protected $endPeriod = '';
    
    /**
     * Returns the startPeriod
     *
     * @return string $startPeriod
     */
    public function getStartPeriod()
    {
        return $this->startPeriod;
    }
    
    /**
     * Sets the startPeriod
     *
     * @param string $startPeriod
     * @return void
     */
    public function setStartPeriod($startPeriod)
    {
        $this->startPeriod = $startPeriod;
    }
    
    /**
     * Returns the endPeriod
     *
     * @return string $endPeriod
     */
    public function getEndPeriod()
    {
        return $this->endPeriod;
    }
    
    /**
     * Sets the endPeriod
     *
     * @param string $endPeriod
     * @return void
     */
    public function setEndPeriod($endPeriod)
    {
        $this->endPeriod = $endPeriod;
    }

}