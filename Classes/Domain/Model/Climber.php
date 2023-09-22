<?php
namespace Csp\Pinkpoint\Domain\Model;

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
 * Climber
 */
class Climber extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * country
     *
     * @var \SJBR\StaticInfoTables\Domain\Model\Country
     */
    protected $country = null;

    /**
     * gender
     *
     * @var int
     */
    protected $gender = null;

    /**
     * avatarimage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $avatarimage = '';

    /**
     * ascents
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Ascent>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $ascents = null;

    /**
     * rating
     *
     * @var \Csp\Pinkpoint\Domain\Model\RouteRating
     */
    protected $rating = null;

    /**
     * rating
     *
     * @var \Csp\FeMessage\Domain\Model\FeUserMessageBox
     */
    protected $messageBox = null;

    /**
     * sectorAdmins
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Sector>
     */
    protected $sectors = null;

    /**
     * usergroup
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup>
     */
    protected $usergroup= null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->ascents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->usergroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->sectors = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the country
     *
     * @return \SJBR\StaticInfoTables\Domain\Model\Country $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Returns the fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * Sets the country
     *
     * @param \SJBR\StaticInfoTables\Domain\Model\Country $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns the gender
     *
     * @return int $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the gender
     *
     * @param int $gender
     * @return void
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Returns the avatarimage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $avatarimage
     */
    public function getAvatarimage()
    {
        return $this->avatarimage;
    }

    /**
     * Sets the avatarimage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $avatarimage
     * @return void
     */
    public function setAvatarimage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $avatarimage)
    {
        $this->avatarimage = $avatarimage;
    }

    /**
     * Adds a Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $ascent
     * @return void
     */
    public function addAscent(\Csp\Pinkpoint\Domain\Model\Ascent $ascent)
    {
        $this->ascents->attach($ascent);
    }

    /**
     * Removes a Ascent
     *
     * @param \Csp\Pinkpoint\Domain\Model\Ascent $ascentToRemove The Ascent to be removed
     * @return void
     */
    public function removeAscent(\Csp\Pinkpoint\Domain\Model\Ascent $ascentToRemove)
    {
        $this->ascents->detach($ascentToRemove);
    }

    /**
     * Returns the ascents
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Ascent> $ascents
     */
    public function getAscents()
    {
        return $this->ascents;
    }

    /**
     * Sets the ascents
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Ascent> $ascents
     * @return void
     */
    public function setAscents(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ascents)
    {
        $this->ascents = $ascents;
    }

    /**
     * Returns the rating
     *
     * @return \Csp\Pinkpoint\Domain\Model\RouteRating $rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Sets the rating
     *
     * @param \Csp\Pinkpoint\Domain\Model\RouteRating $rating
     * @return void
     */
    public function setRating(\Csp\Pinkpoint\Domain\Model\RouteRating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get the value of sectorAdmins
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Sector>
     */
    public function getSectors()
    {
        return $this->sectors;
    }

    /**
     * Set the value of sectorAdmins
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Csp\Pinkpoint\Domain\Model\Sector> $sectors
     *
     * @return self
     */
    public function setSectors(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sectors)
    {
        $this->sectors = $sectors;

        return $this;
    }

    /**
     * Adds a Sector
     *
     * @param \Csp\Pinkpoint\Domain\Model\Sector $sector
     * @return void
     */
    public function addSector(\Csp\Pinkpoint\Domain\Model\Sector $sector)
    {
        $this->sectors->attach($sector);
    }

    /**
     * Removes a Secotr
     *
     * @param \Csp\Pinkpoint\Domain\Model\Sector $sectorToRemove The Sector to be removed
     * @return void
     */
    public function removeSector(\Csp\Pinkpoint\Domain\Model\Sector $sectorToRemove)
    {
        $this->sectors->detach($sectorToRemove);
    }

    /**
     * Count Ascents by grade and and ascent art
     *
     * @param int $grade
     * @param int $art
     * @return int $count
     */
    public function getCountByGradeAndArt($grade, $art)
    {
        $count = 0;
        foreach ($this->ascents as $k => $v) {
            if ($v->getRoute()) {
            if ($v->getAscentArt() == $art && $v->getRoute()->getGrade() == $grade) {
                $count++;
            }
        }
        }
        return $count;
    }

    /**
     * Count Ascents by grade
     *
     * @param int $grade
     * @return int $count
     */
    public function countByGrade($grade)
    {
        $count;
        foreach ($this->ascents as $k => $v) {
            if ($v->getRoute()->getGrade() == $grade) {
                $count++;
            }
        }
        return $count;
    }


    /**
     * Get the value of rating
     *
     * @return \Csp\FeMessage\Domain\Model\FeUserMessageBox
     */
    public function getMessageBox()
    {
        return $this->messageBox;
    }

    /**
     * Set the value of rating
     *
     * @param \Csp\FeMessage\Domain\Model\FeUserMessageBox $messageBox
     *
     * @return self
     */
    public function setMessageBox(\Csp\FeMessage\Domain\Model\FeUserMessageBox $messageBox)
    {
        $this->messageBox = $messageBox;

        return $this;
    }

}
