<?php
namespace Csp\Pinkpoint\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class ClimberTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Domain\Model\Climber
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Csp\Pinkpoint\Domain\Model\Climber();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCountryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCountry()
        );
    }

    /**
     * @test
     */
    public function setCountryForStringSetsCountry()
    {
        $this->subject->setCountry('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'country',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGenderReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getGender()
        );
    }

    /**
     * @test
     */
    public function setGenderForIntSetsGender()
    {
        $this->subject->setGender(12);

        self::assertAttributeEquals(
            12,
            'gender',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAvatarimageReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAvatarimage()
        );
    }

    /**
     * @test
     */
    public function setAvatarimageForStringSetsAvatarimage()
    {
        $this->subject->setAvatarimage('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'avatarimage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUsergroupReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setUsergroupForSetsUsergroup()
    {
    }

    /**
     * @test
     */
    public function getAscentsReturnsInitialValueForAscent()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAscents()
        );
    }

    /**
     * @test
     */
    public function setAscentsForObjectStorageContainingAscentSetsAscents()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();
        $objectStorageHoldingExactlyOneAscents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAscents->attach($ascent);
        $this->subject->setAscents($objectStorageHoldingExactlyOneAscents);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAscents,
            'ascents',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAscentToObjectStorageHoldingAscents()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();
        $ascentsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $ascentsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($ascent));
        $this->inject($this->subject, 'ascents', $ascentsObjectStorageMock);

        $this->subject->addAscent($ascent);
    }

    /**
     * @test
     */
    public function removeAscentFromObjectStorageHoldingAscents()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();
        $ascentsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $ascentsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($ascent));
        $this->inject($this->subject, 'ascents', $ascentsObjectStorageMock);

        $this->subject->removeAscent($ascent);
    }

    /**
     * @test
     */
    public function getRatingsReturnsInitialValueForRouteRating()
    {
        self::assertEquals(
            null,
            $this->subject->getRatings()
        );
    }

    /**
     * @test
     */
    public function setRatingsForRouteRatingSetsRatings()
    {
        $ratingsFixture = new \Csp\Pinkpoint\Domain\Model\RouteRating();
        $this->subject->setRatings($ratingsFixture);

        self::assertAttributeEquals(
            $ratingsFixture,
            'ratings',
            $this->subject
        );
    }
}
