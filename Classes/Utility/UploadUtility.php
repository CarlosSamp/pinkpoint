<?php
namespace Csp\Pinkpoint\Utility;

use \TYPO3\CMS\Core\Resource\ResourceFactory;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use \TYPO3\CMS\Extbase\Object\ObjectManager;

class UploadUtility
{
    /**
     * build a File Reference for one File
     *
     * @param $filename Name of the File
     * @param $folder Folder to save
     * @return \TYPO3\CMS\Core\Resource\FileReference $fileReference
     */
    public static function updateFile($fileName, $folder)
    {

        $uploadedFile = $_FILES;
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $fileReference = $objectManager->get(\TYPO3\CMS\Extbase\Domain\Model\FileReference::class);
        $storage = $resourceFactory->getDefaultStorage();

        $folder = $storage->getFolder($folder);
        $extKey = key($uploadedFile);
        $attributeName = key($uploadedFile[$extKey]['name']);

        $path = pathinfo($uploadedFile[$extKey]['name'][$attributeName]);
        $fileName .= time() .'.' . $path['extension'];

        $uploadedFile = $storage->addFile(
            $uploadedFile[$extKey]['tmp_name'][$attributeName],
            $folder,
            $fileName, \TYPO3\CMS\Core\Resource\DuplicationBehavior::REPLACE
        );

        $originalResource = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileReference::class, array('uid_local' => $uploadedFile->getUid(), 'uid_foreign' => uniqid('NEW_')));

        $fileReference->setOriginalResource($originalResource);

        return $fileReference;
    }

}
