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
* SectorController
*/
class SectorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
    * sectorRepository
    *
    * @var \Csp\Pinkpoint\Domain\Repository\SectorRepository
    * @inject
    */
    protected $sectorRepository = null;

    /**
    * routeRepository
    *
    * @var \Csp\Pinkpoint\Domain\Repository\RouteRepository
    * @inject
    */
    protected $routeRepository = null;

    /**
    * climberRepository
    *
    * @var \Csp\Pinkpoint\Domain\Repository\ClimberRepository
    * @inject
    */
    protected $climberRepository = null;

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
    * @var \SJBR\StaticInfoTables\Domain\Repository\CountryRepository
    * @inject
    */
    protected $countryRepository = null;

    /**
    * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
    * @inject
    */
    protected $frontendUserRepository = null;

    /**
    * frontendUserRepository
    *
    * @var TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
    * @inject
    */
    protected $userGroupRepository = null;

    /**
    * initialize, convert all date fields to database format
    *
    * @return void
    */
    public function initializeAction()
    {
        // Zeile 78 bis 95 Internetgalerie wiki
        if (isset($this->arguments['ascent']) || isset($this->arguments['newAscent'])) {
            if (isset($this->arguments['ascent'])) {
                $ascent = $this->arguments['ascent'];
            } else {
                $ascent = $this->arguments['newAscent'];
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
    * action list Sector
    *
    * @return void
    */
    public function listAction()
    {
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/map.js');
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/Chart.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/barChart.js');

        $order = [
            'sortBy' => 'name',
            'dir' => 'asc',
            'label' => '',
        ];
        $keyword = '';
        function getVisIpAddr() {

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                return $_SERVER['HTTP_CLIENT_IP'];
            }
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else {
                return $_SERVER['REMOTE_ADDR'];
            }
        }
        // Store the IP address
        $vis_ip = getVisIPAddr();

        $ipdat = @json_decode(
            file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip)
        );
        $countries = $this->countryRepository->findAll();
        $this->view->assign('countries', $countries);

        if ($this->request->hasArgument('order')) {
            $order = $this->request->getArgument('order');
        }
        if ($this->request->hasArgument('keyword')) {
            $keyword = $this->request->getArgument('keyword');
        }

        if ($GLOBALS['TSFE']->fe_user->user) {
            $user = $GLOBALS['TSFE']->fe_user->user;
            $climber = $this->climberRepository->findByUid($user['uid']);
            $this->view->assign('climber', $climber);

        }

        if ($this->request->hasArgument('country')) {
            $countryNameEn = $this->request->getArgument('country');
            $countryTemp = $this->countryRepository->findByShortNameEn($this->request->getArgument('country'));
            $countrySearch = $countryTemp[0];
        }elseif($climber) {
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($climber);
            $countryNameEn = $climber->getCountry()->getShortNameEn();
        }else {
            $countryNameEn = $ipdat->geoplugin_countryName;
        }

        $this->view->assign('countrySearch', $countrySearch);
        $this->view->assign('countryEn', $countryNameEn);
        $sectors = $this->sectorRepository->findSector($keyword, $order['sortBy'], $order['dir'], $countryNameEn);
        $this->view->assign('keyword', $keyword);
        
        $sectors = $this->sectorRepository->findAll();
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($sectors);
        // pass the current order to the request
        $this->view->assign('order', $order);
        $this->view->assign('sectors', $sectors);

        // recognozie language automaticly from visitor
        $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $this->view->assign('lang', $lang);
    }

    /**
    * action show Sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @return void
    */
    public function showAction(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/fabric.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/sectorcanvas.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JSLibrarys/jquery.datetimepicker.full.min.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/datetime.js');
        $pageRenderer->addCssFile('EXT:pinkpoint/Resources/Public/Css/jquery.datetimepicker.min.css');
        $GLOBALS['TSFE']->altPageTitle = $sector->getName();
        if ($sector->getRoutes()) {
            $order = [
                'sortBy' => 'name',
                'dir' => 'asc',
                'label' => '',
            ];
            if ($this->request->hasArgument('order')) {
                $order = $this->request->getArgument('order');
            }


            $routes = $this->routeRepository->findRouteBySector($sector->getUid(), $order['sortBy'], $order['dir']);


            $user = $GLOBALS['TSFE']->fe_user->user;
            $climber = $this->climberRepository->findByUid($user['uid']);

            if ($climber) {
                $sectorAdmins = $sector->getSectorAdmins();
                foreach ($sectorAdmins as $key => $admin) {
                    if ($admin->getUid() == $climber->getUid()) {
                        $isAdmin = true;

                    }
                }
            }else {
                $isAdmin = false;
            }
            $this->view->assign('isAdmin', $isAdmin);
            // pass the current order to the request
            $this->view->assign('order', $order);
            for($i=0;$i<=10;$i++){
                $ratingOptions[$i] = $i/2;
            }
            $this->view->assign('ratingOptions', $ratingOptions);
        }

        $today = date("d.m.Y");
        $this->view->assignMultiple(['sector' => $sector, 'routes' => $routes, 'today' => $today, 'climber'=>$climber]);
    }

    /**
    * action new Sector
    *
    * @return void
    */
    public function newAction()
    {
    }

    /**
    * action create
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $newSector
    * @return void
    */
    public function createAction(\Csp\Pinkpoint\Domain\Model\Sector $newSector)
    {
        // create not implemented in frontend
        $this->addFlashMessage('Sector created', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sectorRepository->add($newSector);
        $this->redirect('list');
    }

    /**
    * action edit Sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @ignorevalidation $sector
    * @return void
    */
    public function editAction(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/map.js');
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/fabric.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/sectorcanvas.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/avatar.js');
        $countries = $this->countryRepository->findAll();
        $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $user = $GLOBALS['TSFE']->fe_user->user;
        $climber = $this->climberRepository->findByUid($user['uid']);
        $this->view->assign('climber', $climber);
        $this->view->assign('lang', $lang);
        $this->view->assign('countries', $countries);
        $this->view->assign('sector', $sector);
    }

    /**
    * action update Sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @return void
    */
    public function updateAction(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $extKey = key($_FILES);
        $fieldKey = key($_FILES[$extKey]['name']);
        if ($_FILES[$extKey]['name'][$fieldKey] !== '') {

            if ($sector->getImage()) {
                $sector->getImage()->getOriginalResource()->getoriginalFile()->delete();
            }
            $newFile = \Csp\Pinkpoint\Utility\UploadUtility::updateFile($sector->getname(), 'images/pp_sector_images');
            $sector->setImage($newFile);
        }

        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
        $arguments = $this->request->getArguments();
        $this->addFlashMessage(LocalizationUtility::translate('sector_update', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sectorRepository->update($sector);
        $this->redirect('show', null, null, ['sector' => $sector]);
    }

    /**
    * action delete Sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @return void
    */
    public function deleteAction(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $this->addFlashMessage('deleted', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->sectorRepository->remove($sector);
        $this->redirect('list');
    }

    /**
    * action request admin rights for the sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
    * @return void
    */
    public function requestAction(\Csp\Pinkpoint\Domain\Model\Sector $sector, \Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $mailTo = $this->settings['includeReleaseMail'];

        $this->addFlashMessage(LocalizationUtility::translate('request_sent', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $mail = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mail
        ->setSubject('Sector Admin Anfrage')
        ->setFrom([$climber->getEmail() => 'Pinkpoint Extension'])
        ->setTo([$mailTo =>'Release']);

        $variables=['sector' => $sector, 'climber' => $climber];

        $emailHtmlBody = $this->renderFluid('Mail/AdminRequest.html', $variables);
        $mail->setBody($emailHtmlBody, 'text/html');
        $mail->send();
        $this->redirect('show', 'Sector', null, ['sector' => $sector]);
    }


    /**
    * action release admin rights for user on the actual sector
    *
    * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
    * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
    * @return void
    */
    public function releaseAction(\Csp\Pinkpoint\Domain\Model\Sector $sector, \Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $frontendUser = $this->frontendUserRepository->findByUid($climber->getUid());
        $userGroup = $this->userGroupRepository->findByUid(5);

        $climber->addSector($sector);
        $frontendUser->addUsergroup($userGroup);
        $this->climberRepository->update($frontendUser);
        $this->addFlashMessage($climber->getFullname().' '.LocalizationUtility::translate('released', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->frontendUserRepository->update($frontendUser);
        $this->redirect('show', 'Sector', null, ['sector' => $sector]);
    }

    /**
    * renders fluid template
    *
    * @param array $parameter key=>value pairs, where key is fluid placeholder {key} in the template
    * @return string rendered (html-format) template
    */
    private function renderFluid($templateFile, $parameter)
    {
        //Erstellt ein Objekt View = new..
        $fluidView = $this->objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);
        $extensionName = $this->request->getControllerExtensionName();
        $fluidView->getRequest()->setControllerExtensionName($extensionName);

        //$fluidView->setControllerContext($this->controllerContext);
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        // Holt die Pfade der setup.typoscript, somit ist E-Mail gemäss Backend Pfad. setup.typoscript zwingend!
        $fluidView->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
        $fluidView->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
        $fluidView->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);
        $fluidView->setTemplate($templateFile);

        $fluidView->assignMultiple($parameter);

        return $fluidView->render();
    }
}
