<?php
namespace Csp\Pinkpoint\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Carlos Sampaio Peredo <csp@internetgalerie.ch>
 */
class SectorControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Csp\Pinkpoint\Controller\SectorController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Csp\Pinkpoint\Controller\SectorController::class)
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
    public function listActionFetchesAllSectorsFromRepositoryAndAssignsThemToView()
    {

        $allSectors = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sectorRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\SectorRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $sectorRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSectors));
        $this->inject($this->subject, 'sectorRepository', $sectorRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('sectors', $allSectors);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenSectorToView()
    {
        $sector = new \Csp\Pinkpoint\Domain\Model\Sector();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('sector', $sector);

        $this->subject->showAction($sector);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSectorToSectorRepository()
    {
        $sector = new \Csp\Pinkpoint\Domain\Model\Sector();

        $sectorRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\SectorRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectorRepository->expects(self::once())->method('add')->with($sector);
        $this->inject($this->subject, 'sectorRepository', $sectorRepository);

        $this->subject->createAction($sector);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenSectorToView()
    {
        $sector = new \Csp\Pinkpoint\Domain\Model\Sector();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('sector', $sector);

        $this->subject->editAction($sector);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenSectorInSectorRepository()
    {
        $sector = new \Csp\Pinkpoint\Domain\Model\Sector();

        $sectorRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\SectorRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectorRepository->expects(self::once())->method('update')->with($sector);
        $this->inject($this->subject, 'sectorRepository', $sectorRepository);

        $this->subject->updateAction($sector);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSectorFromSectorRepository()
    {
        $sector = new \Csp\Pinkpoint\Domain\Model\Sector();

        $sectorRepository = $this->getMockBuilder(\Csp\Pinkpoint\Domain\Repository\SectorRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $sectorRepository->expects(self::once())->method('remove')->with($sector);
        $this->inject($this->subject, 'sectorRepository', $sectorRepository);

        $this->subject->deleteAction($sector);
    }
}
