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
 * The repository for Ascents
 */
class AscentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * find Ascent by Route
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @return void
     */
    public function findByRoute($route)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('route', $route)
        );
        $query->setOrderings(
            [
                'ascentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                //'grade' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            ]
        );
        return $query->execute();
    }
}
