<?php
namespace Csp\Pinkpoint\Controller;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/***
 *
 * This file is part of the "Pinkpoint" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Carlos Sampaio Peredo <csp@internetgalerie.ch>, Internetgalerie
 *
 ***/
/**
 * RouteController
 */
class RouteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * routeRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\RouteRepository
     * @inject
     */
    protected $routeRepository = null;

    /**
     * sectorRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\SectorRepository
     * @inject
     */
    protected $sectorRepository = null;

    /**
     * routeRatingRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\RouteRatingRepository
     * @inject
     */
    protected $routeRatingRepository = null;

    /**
     * ascentRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\AscentRepository
     * @inject
     */
    protected $ascentRepository = null;

    /**
     * action show Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function showAction(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $ascentsByRoute = $this->ascentRepository->findByRoute($route);
        $this->view->assign('ascentsByRoute', $ascentsByRoute);
        $this->view->assign('route', $route);
        $GLOBALS['TSFE']->altPageTitle = $route->getSector()->getName().' - '.$route->getName();
    }

    /**
     * action new Route
     *
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * action create Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $newRoute
     * @return void
     */
    public function createAction(\Csp\Pinkpoint\Domain\Model\Route $newRoute)
    {
        $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_route.create', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->routeRepository->add($newRoute);
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
        $this->redirect('edit', 'Route', null, ['route' => $newRoute]);
    }

    /**
     * action edit Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @ignorevalidation $route
     * @return void
     */
    public function editAction(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/fabric.js');
        $pageRenderer->addJsFooterLibrary('jquery-te-1.4.0', 'EXT:pinkpoint/Resources/Public/JSLibrarys/jquery-te-1.4.0.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/sectorcanvas.js');
        $pageRenderer->addCssFile('EXT:pinkpoint/Resources/Public/Css/jquery-te-1.4.0.css');
        $this->view->assign('route', $route);
    }

    /**
     * action update Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function updateAction(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $arguments = $this->request->getArguments();
        $route = $this->routeRepository->findByUid($arguments['routes']['__identity']);
        $route->setGrade($arguments['grade']);
        $route->setName($arguments['name']);
        $route->setLength($arguments['length']);
        $route->setDescription($arguments['description']);
        $sector = $route->getSector();
        $sector->setSectorcanvas($arguments['sectorcanvas']);
        $this->sectorRepository->update($sector);
        $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_route.update', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->routeRepository->update($route);
        $this->redirect('show', 'Sector', null, ['sector' => $sector]);
    }

    /**
     * action delete Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function deleteAction(\Csp\Pinkpoint\Domain\Model\Route $route)
    {
        $ascentsByRoute = $this->ascentRepository->findByRoute($route);
        if (count($ascentsByRoute) > 0) {
            $this->addFlashMessage(LocalizationUtility::translate('delete_not_possible', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
            $this->redirect('edit', 'Route', null, ['route' => $route]);
        }else {
            $arguments = $this->request->getArguments();
            $sector = $route->getSector();
            $sector->setSectorcanvas($arguments['sectorcanvas']);
            $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_route.delete', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
            $this->routeRepository->remove($route);
            $this->sectorRepository->update($sector);
            $this->redirect('show', 'Sector', null, ['sector' => $sector]);
        }
    }
}
