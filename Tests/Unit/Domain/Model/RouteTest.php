<?php
namespace Csp\Pinkpoint\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class RouteTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Domain\Model\Route
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Csp\Pinkpoint\Domain\Model\Route();
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
    public function getGradeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getGrade()
        );
    }

    /**
     * @test
     */
    public function setGradeForIntSetsGrade()
    {
        $this->subject->setGrade(12);

        self::assertAttributeEquals(
            12,
            'grade',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLengthReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getLength()
        );
    }

    /**
     * @test
     */
    public function setLengthForIntSetsLength()
    {
        $this->subject->setLength(12);

        self::assertAttributeEquals(
            12,
            'length',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectorCountReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getSectorCount()
        );
    }

    /**
     * @test
     */
    public function setSectorCountForIntSetsSectorCount()
    {
        $this->subject->setSectorCount(12);

        self::assertAttributeEquals(
            12,
            'sectorCount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSectorReturnsInitialValueForSector()
    {
        self::assertEquals(
            null,
            $this->subject->getSector()
        );
    }

    /**
     * @test
     */
    public function setSectorForSectorSetsSector()
    {
        $sectorFixture = new \Csp\Pinkpoint\Domain\Model\Sector();
        $this->subject->setSector($sectorFixture);

        self::assertAttributeEquals(
            $sectorFixture,
            'sector',
            $this->subject
        );
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
