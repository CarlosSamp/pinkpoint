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
 * Ascent
 */
class Ascent extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * ascentDate
     *
     * @var \DateTime
     */
    protected $ascentDate = null;

    /**
     * ascentArt
     *
     * @var int
     */
    protected $ascentArt = 0;

    /**
     * publicVisible
     *
     * @var bool
     */
    protected $publicVisible = false;

    /**
     * comment
     *
     * @var string
     */
    protected $comment = '';

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
     * Returns the ascentDate
     *
     * @return \DateTime $ascentDate
     */
    public function getAscentDate()
    {
        return $this->ascentDate;
    }

    /**
     * Sets the ascentDate
     *
     * @param \DateTime $ascentDate
     * @return void
     */
    public function setAscentDate(\DateTime $ascentDate)
    {
        $this->ascentDate = $ascentDate;
    }

    /**
     * Returns the ascentArt
     *
     * @return int $ascentArt
     */
    public function getAscentArt()
    {
        return $this->ascentArt;
    }

    /**
     * Sets the ascentArt
     *
     * @param int $ascentArt
     * @return void
     */
    public function setAscentArt($ascentArt)
    {
        $this->ascentArt = $ascentArt;
    }

    /**
     * Returns the publicVisible
     *
     * @return bool $publicVisible
     */
    public function getPublicVisible()
    {
        return $this->publicVisible;
    }

    /**
     * Sets the publicVisible
     *
     * @param bool $publicVisible
     * @return void
     */
    public function setPublicVisible($publicVisible)
    {
        $this->publicVisible = $publicVisible;
    }

    /**
     * Returns the boolean state of publicVisible
     *
     * @return bool
     */
    public function isPublicVisible()
    {
        return $this->publicVisible;
    }

    /**
     * Returns the comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Returns the route
     *
     * @return \Csp\Pinkpoint\Domain\Model\Route $route
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
    public function setRoute(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $this->route = $route;
    }

    /**
     * Get the Climber
     *
     * @return \Csp\Pinkpoint\Domain\Model\Climber
     */
    public function getClimber()
    {
        return $this->climber;
    }

    /**
     * Set the Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     *
     * @return self
     */
    public function setClimber(\Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $this->climber = $climber;

        return $this;
    }

}
