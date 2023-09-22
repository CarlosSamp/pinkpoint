<?php
namespace Csp\Pinkpoint\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class RouteRatingControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Controller\RouteRatingController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Csp\Pinkpoint\Controller\RouteRatingController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllRouteRatingsFromRepositoryAndAssignsThemToView()
    {

        $allRouteRatings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $routeRatingRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\RouteRatingRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $routeRatingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allRouteRatings));
        $this->inject($this->subject, 'routeRatingRepository', $routeRatingRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('routeRatings', $allRouteRatings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
