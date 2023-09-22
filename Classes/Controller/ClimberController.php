<?php
namespace Csp\Pinkpoint\Controller;

use TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Core\Page\PageRenderer;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * ClimberController
 */
class ClimberController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * climberRepository
     *
     * @var \Csp\Pinkpoint\Domain\Repository\ClimberRepository
     * @inject
     */
    protected $climberRepository = null;

    /**
     * @var \SJBR\StaticInfoTables\Domain\Repository\CountryRepository
     * @inject
     */
    protected $countryRepository = null;

    /**
     * frontendUserRepository
     *
     * @var TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $userGroupRepository = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * action welcome CLimber after the Registration
     *
     * @return void
     */
    public function welcomeAction()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/pinkpoint.js');
        $climbers = $this->climberRepository->findAll();
        $pageUid = $this->settings['includePageUid'];
        $this->view->assign('pageUid', $pageUid);
        $this->view->assign('climbers', $climbers);
    }

    /**
     * action show Climber
     *
     *
     * @return void
     */
    public function showAction()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/Chart.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/stackedBarChart.js');

        $stackedData = [
            'labels' => [],
            '' => '',
            '' => '',
        ];
        $labels = [];
        $user = $GLOBALS['TSFE']->fe_user->user;
        $climber = $this->climberRepository->findByUid($user['uid']);
        $ascents = $climber->getAscents();

        foreach ($ascents as $key => $ascent) {
            if ($ascent->getRoute()) {
                $gradeName = $ascent->getRoute()->getGrade();
                array_push($labels, $gradeName);
            }
        }

        $this->view->assign('labels', $labels);
        $this->view->assign('climber', $climber);
    }

    /**
     * action show Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     * @return void
     */
    public function publicShowAction(\Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFile('EXT:pinkpoint/Resources/Public/JSLibrarys/Chart.js');
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/stackedBarChart.js');

        $stackedData = [
            'labels' => [],
            '' => '',
            '' => '',
        ];
        $labels = [];

        $ascents = $climber->getAscents();

        foreach ($ascents as $key => $ascent) {
            if ($ascent->getRoute()) {
                $gradeName = $ascent->getRoute()->getGrade();
                array_push($labels, $gradeName);
            }
        }

        $this->view->assign('labels', $labels);
        $this->view->assign('climber', $climber);
    }

    /**
     * action new Climber
     *
     * @return void
     */
    public function newAction()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/avatar.js');
        $countries = $this->countryRepository->findAll();
        $this->view->assign('countries', $countries);
    }

    /**
     * action create Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $newClimber
     * @return void
     */
    public function createAction()
    {
        $arguments = $this->request->getArguments();

        $hashInstance = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory::class)->getDefaultHashInstance('FE');
        $hashedPassword = $hashInstance->getHashedPassword($arguments['password']);
        $newClimber = new \Csp\Pinkpoint\Domain\Model\Climber();
        // check if username allready exists
        if (count($this->climberRepository->findByUsername($arguments['username'])) < 1) {
            $newClimber->setUsername($arguments['username']);

        } else {
            $this->addFlashMessage(LocalizationUtility::translate('username_exists', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
            $this->redirect('new', 'Climber', null, null);
        }
        $newClimber->setPassword($hashedPassword);
        $newClimber->setFirstName($arguments['firstName']);
        $newClimber->setLastName($arguments['lastName']);
        $newClimber->setEmail($arguments['email']);
        $newClimber->setGender($arguments['gender']);
        // reason why not the climber property used frontend, same with the group
        $country = $this->countryRepository->findByUid($arguments['country']);
        $newClimber->setCountry($country);
        $userPid = $this->settings['includePid'];
        $newClimber->setPid($userPid);
        $extKey = key($_FILES);
        $attrName = key($_FILES[$extKey]['name']);
        if ($_FILES[$extKey]['name'][$attrName] !== '') {
            $newFile = \Csp\Pinkpoint\Utility\UploadUtility::updateFile($newClimber->getFirstName() . $newClimber->getLastName(), 'images/pp_user_images');
            $newClimber->setAvatarimage($newFile);
        }
        $this->climberRepository->add($newClimber);
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
        $frontendUser = $this->frontendUserRepository->findByUid($newClimber->getUid());
        $groupId = $pageUid = $this->settings['includeGroupId'];
        $userGroup = $this->userGroupRepository->findByUid(6);
        $frontendUser->addUsergroup($userGroup);
        $this->frontendUserRepository->update($frontendUser);
        $persistenceManager->persistAll();
        $this->addFlashMessage(LocalizationUtility::translate('climber_create', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->redirect('welcome', null, null, null, null);
    }

    /**
     * action edit Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     * @ignorevalidation $climber
     * @return void
     */
    public function editAction(\Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterFile('EXT:pinkpoint/Resources/Public/JavaScript/avatar.js');
        $countries = $this->countryRepository->findAll();
        $this->view->assign('climber', $climber);
        $this->view->assign('countries', $countries);

    }

    /**
     * action update Climber
     *
     *
     * @return void
     */
    public function updateAction()
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        $climber = $this->climberRepository->findByUid($user['uid']);
        $arguments = $this->request->getArguments();
        // check if username exists or if its the same
        if (count($this->climberRepository->findByUsername($arguments['username'])) < 1 && $arguments['username'] !== $climber->getUsername()) {
            $climber->setUsername($arguments['username']);

        } elseif ($arguments['username'] == $climber->getUsername()) {

        } else {

            $this->addFlashMessage(LocalizationUtility::translate('username_exists', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
            $this->redirect('edit', 'Climber', null, ['climber' => $climber]);
        }

        $country = $this->countryRepository->findByUid($arguments['country']);
        $climber->setCountry($country);
        $climber->setFirstName($arguments['firstName']);
        $climber->setLastName($arguments['lastName']);
        $climber->setEmail($arguments['email']);
        $climber->setGender($arguments['gender']);
        // reason why no climber property in frontend
        $country = $this->countryRepository->findByUid($arguments['country']);
        $climber->setCountry($country);

        if (!empty($_FILES)) {
            $extKey = key($_FILES);
            $attrName = key($_FILES[$extKey]['name']);
            if ($_FILES[$extKey]['name'][$attrName] !== '') {
                if ($climber->getAvatarimage()) {
                    // Code 227-230 from Daniel Abplanalp
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
                    $result = $queryBuilder->delete('sys_file_reference')->where(
                        $queryBuilder->expr()->eq('uid', (int) $climber->getAvatarimage()->getUid())
                    )->execute();
                }
                $newFile = \Csp\Pinkpoint\Utility\UploadUtility::updateFile($climber->getFirstName() . $climber->getLastName(), 'images/pp_user_images');
                $climber->setAvatarimage($newFile);
            }
        }

        $this->climberRepository->update($climber);
        $this->addFlashMessage(LocalizationUtility::translate('climber_update', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->redirect('show', 'Climber', null, ['climber' => $climber]);
    }

    /**
     * action delete Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     * @return void
     */
    public function deleteAction(\Csp\Pinkpoint\Domain\Model\Climber $climber)
    {
        $this->addFlashMessage(LocalizationUtility::translate('climber_deleted', 'pinkpoint'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->climberRepository->remove($climber);
        $this->redirect('list', 'Sector', null, null);
    }

}
