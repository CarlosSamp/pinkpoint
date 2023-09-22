<?php
namespace Csp\Pinkpoint\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class RouteControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Controller\RouteController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Csp\Pinkpoint\Controller\RouteController::class)
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
    public function listActionFetchesAllRoutesFromRepositoryAndAssignsThemToView()
    {

        $allRoutes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $routeRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\RouteRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $routeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allRoutes));
        $this->inject($this->subject, 'routeRepository', $routeRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('routes', $allRoutes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenRouteToView()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('route', $route);

        $this->subject->showAction($route);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenRouteToRouteRepository()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();

        $routeRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\RouteRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $routeRepository->expects(self::once())->method('add')->with($route);
        $this->inject($this->subject, 'routeRepository', $routeRepository);

        $this->subject->createAction($route);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenRouteToView()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('route', $route);

        $this->subject->editAction($route);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenRouteInRouteRepository()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();

        $routeRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\RouteRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $routeRepository->expects(self::once())->method('update')->with($route);
        $this->inject($this->subject, 'routeRepository', $routeRepository);

        $this->subject->updateAction($route);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenRouteFromRouteRepository()
    {
        $route = new \Csp\Pinkpoint\Domain\Model\Route();

        $routeRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\RouteRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $routeRepository->expects(self::once())->method('remove')->with($route);
        $this->inject($this->subject, 'routeRepository', $routeRepository);

        $this->subject->deleteAction($route);
    }
}
