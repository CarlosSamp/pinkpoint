<?php
namespace Csp\Pinkpoint\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class AscentControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Controller\AscentController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Csp\Pinkpoint\Controller\AscentController::class)
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
    public function listActionFetchesAllAscentsFromRepositoryAndAssignsThemToView()
    {

        $allAscents = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ascentRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\AscentRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $ascentRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAscents));
        $this->inject($this->subject, 'ascentRepository', $ascentRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('ascents', $allAscents);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAscentToView()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('ascent', $ascent);

        $this->subject->showAction($ascent);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAscentToAscentRepository()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();

        $ascentRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\AscentRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $ascentRepository->expects(self::once())->method('add')->with($ascent);
        $this->inject($this->subject, 'ascentRepository', $ascentRepository);

        $this->subject->createAction($ascent);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAscentToView()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('ascent', $ascent);

        $this->subject->editAction($ascent);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAscentInAscentRepository()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();

        $ascentRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\AscentRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $ascentRepository->expects(self::once())->method('update')->with($ascent);
        $this->inject($this->subject, 'ascentRepository', $ascentRepository);

        $this->subject->updateAction($ascent);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAscentFromAscentRepository()
    {
        $ascent = new \Csp\Pinkpoint\Domain\Model\Ascent();

        $ascentRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\AscentRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $ascentRepository->expects(self::once())->method('remove')->with($ascent);
        $this->inject($this->subject, 'ascentRepository', $ascentRepository);

        $this->subject->deleteAction($ascent);
    }
}
