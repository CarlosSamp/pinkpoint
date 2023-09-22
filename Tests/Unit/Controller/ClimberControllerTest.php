<?php
namespace Csp\Pinkpoint\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class ClimberControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Controller\ClimberController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Csp\Pinkpoint\Controller\ClimberController::class)
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
    public function showActionAssignsTheGivenClimberToView()
    {
        $climber = new \Csp\Pinkpoint\Domain\Model\Climber();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('climber', $climber);

        $this->subject->showAction($climber);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenClimberToClimberRepository()
    {
        $climber = new \Csp\Pinkpoint\Domain\Model\Climber();

        $climberRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\ClimberRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $climberRepository->expects(self::once())->method('add')->with($climber);
        $this->inject($this->subject, 'climberRepository', $climberRepository);

        $this->subject->createAction($climber);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenClimberToView()
    {
        $climber = new \Csp\Pinkpoint\Domain\Model\Climber();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('climber', $climber);

        $this->subject->editAction($climber);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenClimberInClimberRepository()
    {
        $climber = new \Csp\Pinkpoint\Domain\Model\Climber();

        $climberRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\ClimberRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $climberRepository->expects(self::once())->method('update')->with($climber);
        $this->inject($this->subject, 'climberRepository', $climberRepository);

        $this->subject->updateAction($climber);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenClimberFromClimberRepository()
    {
        $climber = new \Csp\Pinkpoint\Domain\Model\Climber();

        $climberRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\ClimberRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $climberRepository->expects(self::once())->method('remove')->with($climber);
        $this->inject($this->subject, 'climberRepository', $climberRepository);

        $this->subject->deleteAction($climber);
    }
}
