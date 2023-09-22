<?php
namespace Csp\Pinkpoint\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class SectorTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Domain\Model\Sector
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Csp\Pinkpoint\Domain\Model\Sector();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLocationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLocation()
        );
    }

    /**
     * @test
     */
    public function setLocationForStringSetsLocation()
    {
        $this->subject->setLocation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'location',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCountryReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getCountry()
        );
    }

    /**
     * @test
     */
    public function setCountryForIntSetsCountry()
    {
        $this->subject->setCountry(12);

        self::assertAttributeEquals(
            12,
            'country',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLatitudeReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getLatitude()
        );
    }

    /**
     * @test
     */
    public function setLatitudeForFloatSetsLatitude()
    {
        $this->subject->setLatitude(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'latitude',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getLongitudeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLongitude()
        );
    }

    /**
     * @test
     */
    public function setLongitudeForStringSetsLongitude()
    {
        $this->subject->setLongitude('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'longitude',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectorcanvasReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSectorcanvas()
        );
    }

    /**
     * @test
     */
    public function setSectorcanvasForStringSetsSectorcanvas()
    {
        $this->subject->setSectorcanvas('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'sectorcanvas',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectorAdminsReturnsInitialValueForClimber()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSectorAdmins()
        );
    }

    /**
     * @test
     */
    public function setSectorAdminsForObjectStorageContainingClimberSetsSectorAdmins()
    {
        $sectorAdmin = new \Csp\Pinkpoint\Domain\Model\Climber();
        $objectStorageHoldingExactlyOneSectorAdmins = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSectorAdmins->attach($sectorAdmin);
        $this->subject->setSectorAdmins($objectStorageHoldingExactlyOneSectorAdmins);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneSectorAdmins,
            'sectorAdmins',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addSectorAdminToObjectStorageHoldingSectorAdmins()
    {
        $sectorAdmin = new \Csp\Pinkpoint\Domain\Model\Climber();
        $sectorAdminsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectorAdminsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($sectorAdmin));
        $this->inject($this->subject, 'sectorAdmins', $sectorAdminsObjectStorageMock);

        $this->subject->addSectorAdmin($sectorAdmin);
    }

    /**
     * @test
     */
    public function removeSectorAdminFromObjectStorageHoldingSectorAdmins()
    {
        $sectorAdmin = new \Csp\Pinkpoint\Domain\Model\Climber();
        $sectorAdminsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectorAdminsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($sectorAdmin));
        $this->inject($this->subject, 'sectorAdmins', $sectorAdminsObjectStorageMock);

        $this->subject->removeSectorAdmin($sectorAdmin);
    }

    /**
     * @test
     */
    public function getRoutesReturnsInitialValueForRoute()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getRoutes()
        );
    }

    /**
     * @test
     */
    public function setRoutesForObjectStorageContainingRouteSetsRoutes()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();
        $objectStorageHoldingExactlyOneRoutes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneRoutes->attach($route);
        $this->subject->setRoutes($objectStorageHoldingExactlyOneRoutes);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneRoutes,
            'routes',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addRouteToObjectStorageHoldingRoutes()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();
        $routesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $routesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($route));
        $this->inject($this->subject, 'routes', $routesObjectStorageMock);

        $this->subject->addRoute($route);
    }

    /**
     * @test
     */
    public function removeRouteFromObjectStorageHoldingRoutes()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();
        $routesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $routesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($route));
        $this->inject($this->subject, 'routes', $routesObjectStorageMock);

        $this->subject->removeRoute($route);
    }
}
