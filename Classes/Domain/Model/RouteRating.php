<?php
namespace Csp\Pinkpoint\Domain\Model;

/***
 *
 * This file is part of the "Pinkpoint" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Carlos Sampaio Peredo <csp@internetgalerie.ch>, Internetgalerie
 *
 ***/
/**
 * RouteRating
 */
class RouteRating extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * rating
     *
     * @var int
     */
    protected $rating = 0;

    /**
     * route
     *
     * @var \Csp\Pinkpoint\Domain\Model\Route
     */
    protected $route = null;

    /**
     * climber
     *
     * @var \Csp\Pinkpoint\Domain\Model\Climber
     */
    protected $climber = null;

    /**
     * Returns the rating
     *
     * @return int $rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Sets the rating
     *
     * @param int $rating
     * @return void
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Returns the route
     *
     * @return $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Sets the route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * Get the value of climber
     *
     * @return \Csp\Pinkpoint\Domain\Model\Climber
     */
    public function getClimber()
    {
        return $this->climber;
    }

    /**
     * Set the value of climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     *
     * @return self
     */
    public function setClimber(\Csp\Pinkpoint\Domain\Model\climber $climber)
    {
        $this->climber = $climber;

        return $this;
    }
}
