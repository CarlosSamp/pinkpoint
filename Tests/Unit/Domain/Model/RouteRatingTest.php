<?php
namespace Csp\Pinkpoint\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class RouteRatingTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Domain\Model\RouteRating
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Csp\Pinkpoint\Domain\Model\RouteRating();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getRatingReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getRating()
        );
    }

    /**
     * @test
     */
    public function setRatingForIntSetsRating()
    {
        $this->subject->setRating(12);

        self::assertAttributeEquals(
            12,
            'rating',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRouteReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setRouteForSetsRoute()
    {
    }
}
