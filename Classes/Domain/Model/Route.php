<?php
namespace Csp\Pinkpoint\Domain\Model;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * Route
 */
class Route extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * grade
     *
     * @var int
     */
    protected $grade = 0;

    /**
     * length
     *
     * @var int
     */
    protected $length = 0;

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * sectorCount
     *
     * @var int
     */
    protected $sectorCount = 0;

    /**
     * sector
     *
     * @var \Csp\Pinkpoint\Domain\Model\Sector
     */
    protected $sector = null;

    /**
     * ratings
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\RouteRating>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $ratings = null;

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the grade
     *
     * @return int $grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Get all Grades
     *
     * @return Array of all the available Grade labels
     */
    public function getAllGrades()
    {
        $grades = [];

        for ($i = 0; $i <= 30; $i++) {
            $grade = new \stdClass(); // initialisierung ein PHP Object
            $grade->key = LocalizationUtility::translate('tx_pinkpoint_domain_model_route.grade.' . $i, 'pinkpoint');
            $grade->value = $i;
            $grades[] = $grade;
        }

        return $grades;
    }

    /**
     * Sets the grade
     *
     * @param int $grade
     * @return void
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * Returns the length
     *
     * @return int $length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Sets the length
     *
     * @param int $length
     * @return void
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the sectorCount
     *
     * @return int $sectorCount
     */
    public function getSectorCount()
    {
        return $this->sectorCount;
    }

    /**
     * Sets the sectorCount
     *
     * @param int $sectorCount
     * @return void
     */
    public function setSectorCount($sectorCount)
    {
        $this->sectorCount = $sectorCount;
    }

    /**
     * Returns the sector
     *
     * @return \Csp\Pinkpoint\Domain\Model\Sector $sector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Sets the sector
     *
     * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
     * @return void
     */
    public function setSector(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $this->sector = $sector;
    }

    /**
     * Adds a Route Rating
     *
     * @param \Csp\Pinkpoint\Domain\Model\RouteRating $routeRating
     * @return void
     */
    public function addRouteRating(\Csp\Pinkpoint\Domain\Model\RouteRating $routeRating)
    {
        $this->ratings->attach($routeRating);
    }

    /**
     * Removes a RouteRating
     *
     * @param \Csp\Pinkpoint\Domain\Model\RouteRating $routeToRemove The Route rating to be removed
     * @return void
     */
    public function removeRouteRating(\Csp\Pinkpoint\Domain\Model\RouteRating $routeRatingToRemove)
    {
        $this->ratings->detach($routeRatingToRemove);
    }

    /**
     * Returns the ratings
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\RouteRating> $ratings
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Sets the ratings
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\RouteRating> $ratings
     * @return void
     */
    public function setRatings(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ratings)
    {
        $this->ratings = $ratings;
    }

    /**
     * Get the value of routeRatings
     *
     * @return int avarage of the Ratings for the Route
     */
    public function getRatingsAverage()
    {
        if ($this->ratings->count() > 0) {
            $count = $this->ratings->count();
            foreach ($this->ratings as $key => $rating) {
                $total += $rating->getRating();
            }
            $average = $total / $count;
        }else {
            $average = 0;
        }

        return round($average, 1);
    }

    /**
     * Get the value of routeRatings
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\RouteRating> by the Climber
     */
    public function getRatingByClimber()
    {

        if (count($this->ratings) > 0) {
            foreach ($this->ratings as $key => $rating) {
                
                if ($rating->getClimber()) {
                    $climber = $rating->getClimber();
                    $uid = $climber->getUid();
                    if ($uid == $GLOBALS['TSFE']->fe_user->user['uid']) {
                        $ratingByClimber = $rating->getRating();
                    }
                }

            }

        }
        else {
            $ratingByClimber = 0;
        }
        return $ratingByClimber;

    }

    /**
     * Get the value of routeRatings
     *
     * @return int $count of the Ratings on the Route
     */
    public function getCountRatings()
    {
        if ($this->ratings) {
            $count = $this->ratings->count();
        }else {
            $count = 0;
        }


        return $count;
    }
}
