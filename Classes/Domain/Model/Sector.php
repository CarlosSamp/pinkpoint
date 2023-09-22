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
 * Sector
 */
class Sector extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * location
     *
     * @var string
     */
    protected $location = '';

    /**
     * country
     *
     * @var \SJBR\StaticInfoTables\Domain\Model\Country
     */
    protected $country = null;

    /**
     * latitude
     *
     * @var float
     */
    protected $latitude = 0.0;

    /**
     * longitude
     *
     * @var float
     */
    protected $longitude = 0.0;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * sectorcanvas
     *
     * @var string
     */
    protected $sectorcanvas = '';

    /**
     * sectorAdmins
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Climber>
     */
    protected $sectorAdmins = null;

    /**
     * routes
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Route>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $routes = null;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->sectorAdmins = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->routes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
     * Returns the location
     *
     * @return string $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param string $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Returns the country
     *
     * @return int $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param int $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the latitude
     *
     * @return float $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the sectorcanvas
     *
     * @return string $sectorcanvas
     */
    public function getSectorcanvas()
    {
        return $this->sectorcanvas;
    }

    /**
     * Sets the sectorcanvas
     *
     * @param string $sectorcanvas
     * @return void
     */
    public function setSectorcanvas($sectorcanvas)
    {
        $this->sectorcanvas = $sectorcanvas;
    }

    /**
     * Adds a Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $sectorAdmin
     * @return void
     */
    public function addSectorAdmin(\Csp\Pinkpoint\Domain\Model\Climber $sectorAdmin)
    {
        $this->sectorAdmins->attach($sectorAdmin);
    }

    /**
     * Removes a Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $sectorAdminToRemove The Climber to be removed
     * @return void
     */
    public function removeSectorAdmin(\Csp\Pinkpoint\Domain\Model\Climber $sectorAdminToRemove)
    {
        $this->sectorAdmins->detach($sectorAdminToRemove);
    }

    /**
     * Returns the sectorAdmins
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Climber> $sectorAdmins
     */
    public function getSectorAdmins()
    {
        return $this->sectorAdmins;
    }

    /**
     * Sets the sectorAdmins
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Climber> $sectorAdmins
     * @return void
     */
    public function setSectorAdmins(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sectorAdmins)
    {
        $this->sectorAdmins = $sectorAdmins;
    }

    /**
     * Adds a Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function addRoute(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $this->routes->attach($route);
    }

    /**
     * Removes a Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $routeToRemove The Route to be removed
     * @return void
     */
    public function removeRoute(\Csp\Pinkpoint\Domain\Model\Route $routeToRemove)
    {
        $this->routes->detach($routeToRemove);
    }

    /**
     * Returns the routes
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Route> $routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Sets the routes
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Route> $routes
     * @return void
     */
    public function setRoutes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Get all Grades
     *
     * @return Array of all the available Grade labels
     */
    public function getAllGrades()
    {
        $grades = [];

        for ($i=0; $i <= 30; $i++) {
        $grade = new \stdClass(); // initialisierung ein PHP Object
        $grade->key = LocalizationUtility::translate('tx_pinkpoint_domain_model_route.grade.'.$i, 'pinkpoint');
        $grade->value = $i;
        $grades[] = $grade;
        }

        return $grades;
    }

    /**
     * Get the count by Grade
     *
     * @return Array count of Routes sorted by Grade
     */
    public function getRouteCountByGrade()
    {
        $routes = [];
        foreach ($this->routes as $key => $route) {

            // generate array with grades no duplicate
            if (!array_key_exists($route->getGrade(), $routes)) {
                $routes += [$route->getGrade() =>0];
            }
            // count Routes
            foreach ($routes as $key => $value) {
                if ($key == $route->getGrade()) {
                    $routes[$key] ++;
                }
            }

        }
        ksort($routes);
        return $routes;
    }
}
