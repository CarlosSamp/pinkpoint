<?php
namespace Csp\Pinkpoint\Domain\Repository;

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
 * The repository for Climbers
 */
class ClimberRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * find Climber by Username
     *
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     * @return void
     */
    public function findByUsername($climber)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('username', $climber)

        );

        return $query->execute();
    }
}
