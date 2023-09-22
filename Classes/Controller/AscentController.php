<?php
namespace Csp\Pinkpoint\Controller;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * AscentController
 */
class AscentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * ascentRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\AscentRepository
     * @inject
     */
protected $ascentRepository = null;

    /**
     * routeRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\RouteRepository
     * @inject
     */
    protected $routeRepository = null;

    /**
     * routeRatingRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\RouteRatingRepository
     * @inject
     */
    protected $routeRatingRepository = null;

    /**
     * climberRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\ClimberRepository
     * @inject
     */
    protected $climberRepository = null;

    /**
     * sectorRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\SectorRepository
     * @inject
     */
    protected $sectorRepository = null;

    /**
     * initialize, convert all date fields to database format
     *
     * @return void
     */
    public function initializeAction()
    {

        if (isset($this->arguments['ascent']) || isset($this->arguments['newAscent']) || isset($this->arguments['ascentEdit'])) {
            if (isset($this->arguments['ascent'])) {
                $ascent = $this->arguments['ascent'];
            } elseif (isset($this->arguments['newAscent'])) {
                $ascent = $this->arguments['newAscent'];
            } elseif (isset($this->arguments['ascent'])) {
                $ascent = $this->arguments['ascent'];
            }
            // Set date format of date fields
            foreach (['ascentDate'] as $dateField) {
        $ascent->getPropertyMappingConfiguration()
                    ->forProperty($dateField)
                    ->setTypeConverterOption(
                        'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                        \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                        'd.m.Y'
                    );
            }
        }
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
    $ascents = $this->ascentRepository->findAll();
        $this->view->assign('ascents', $ascents);
    }

    /**
     * action new Ascent. Climber can only have 1 rating per route.
     *
     * @return void
     */
    public function newAction()
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        $climber = $this->climberRepository->findByUid($user['uid']);
        $ascentsPid = (int)$this->settings['ascentsPid'];

        $sector = $this->sectorRepository->findByUid((int)$this->request->getArgument('sector'));
        $logCount = 0;
        if ($this->request->hasArgument('ascent')) {
            $ascents = $this->request->getArgument('ascent');

            foreach ($ascents as $key => $value) {
                if ($value['routeUid'] !== '') {
                    $logCount ++;
                    $count = 0;
                    $route = $this->routeRepository->findByUid((int) $value['routeUid']);
                    $newRating = new \Csp\Pinkpoint\Domain\Model\RouteRating();
                    $newAscent = new \Csp\Pinkpoint\Domain\Model\Ascent();
                    $newAscent->setAscentDate(new \DateTime($value['ascentDate']));
                    $newAscent->setAscentArt((int) $value['art']);
                    $newAscent->setRoute($route);
                    $newAscent->setPid($ascentsPid);
                    $newAscent->setPublicVisible((int) $value['publicVisible']);

                    $newAscent->setComment($value['comment']);
                    $climber->addAscent($newAscent);

                    $newRating->setRating($value['rating']);
                    $newRating->setClimber($climber);
                    $newRating->setRoute($route);
                    $newRating->setPid($ascentsPid);

                    // Check if climber allready rated the route
                    $ratingByClimber = $this->routeRatingRepository->getByRouteAndClimber($route, $climber);
                    if (count($ratingByClimber) > 0) {

                        if ((int) $newRating->getRating() !== (int) $ratingByClimber[0]->getRating()) {
                            $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.update', 'pinkpoint') . $route->getName(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                            $ratingByClimber[0]->setRating($newRating->getRating());
                        } else {
                            // do nothing if rating exist and the same
                            $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.save', 'pinkpoint') . $route->getName(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                        }

                        $this->routeRatingRepository->update($ratingByClimber[0]);
                    } else {
                        // add new rating if no rating available
                        $this->routeRatingRepository->add($newRating);
                        $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.create', 'pinkpoint') . $route->getName(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                    }

                    $this->ascentRepository->add($newAscent);
                }
            }
            $this->view->assign('ascents', $ascents);
        }
        if ($logCount < 1) {
            $this->addFlashMessage('no routes selected to log', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

        }
        $this->climberRepository->update($climber);

        $this->redirect('show', 'Sector', null, ['sector' => $sector]);
    }

    /**
     * action create Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $newAscent
     * @return void
     */
    public function createAction(\Csp\Pinkpoint\Domain\Model\Ascent $newAscent)
    {
        $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.update', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ascentRepository->add($newAscent);
        $this->redirect('list');
    }

    /**
     * action edit Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $ascent
     * @ignorevalidation $ascent
     * @return void
     */
    public function editAction(\Csp\Pinkpoint\Domain\Model\Ascent $ascent)
    {
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JSLibrarys/jquery.datetimepicker.full.min.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/datetime.js');
        $pageRenderer->addCssFile('EXT:pinkpoint/Resources/Public/Css/jquery.datetimepicker.min.css');
        $this->view->assign('ascent', $ascent);
    }

    /**
     * action update Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $ascentEdit
     * @return void
     */
    public function updateAction(\Csp\Pinkpoint\Domain\Model\Ascent $ascent)
    {
        $this->addFlashMessage(LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.create', 'pinkpoint').' '.$ascent->getRoute()->getName(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ascentRepository->update($ascent);
        $this->redirect('list', 'Sector', null, null);
    }

    /**
     * action delete Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $ascent
     * @return void
     */
    public function deleteAction(\Csp\Pinkpoint\Domain\Model\Ascent $ascent)
    {
        $this->addFlashMessage(LocalizationUtility::translate('deleted', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->ascentRepository->remove($ascent);
        $this->redirect('list', 'Sector', null, null);
    }

}
