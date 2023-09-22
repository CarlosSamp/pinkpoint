<?php
namespace Csp\Pinkpoint\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class AscentTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Domain\Model\Ascent
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Csp\Pinkpoint\Domain\Model\Ascent();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAscentDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getAscentDate()
        );
    }

    /**
     * @test
     */
    public function setAscentDateForDateTimeSetsAscentDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setAscentDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'ascentDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAscentArtReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getAscentArt()
        );
    }

    /**
     * @test
     */
    public function setAscentArtForIntSetsAscentArt()
    {
        $this->subject->setAscentArt(12);

        self::assertAttributeEquals(
            12,
            'ascentArt',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPublicVisibleReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getPublicVisible()
        );
    }

    /**
     * @test
     */
    public function setPublicVisibleForBoolSetsPublicVisible()
    {
        $this->subject->setPublicVisible(true);

        self::assertAttributeEquals(
            true,
            'publicVisible',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCommentReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getComment()
        );
    }

    /**
     * @test
     */
    public function setCommentForStringSetsComment()
    {
        $this->subject->setComment('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'comment',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRouteReturnsInitialValueForRoute()
    {
        self::assertEquals(
            null,
            $this->subject->getRoute()
        );
    }

    /**
     * @test
     */
    public function setRouteForRouteSetsRoute()
    {
        $routeFixture = new \Csp\Pinkpoint\Domain\Model\Route();
        $this->subject->setRoute($routeFixture);

        self::assertAttributeEquals(
            $routeFixture,
            'route',
            $this->subject
        );
    }
}
