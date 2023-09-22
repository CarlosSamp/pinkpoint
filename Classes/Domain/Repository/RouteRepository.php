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
 * The repository for Routes
 */
class RouteRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * find Route by Sector, set the direction of the sorting depnding on the current sorting
     *
     * @param $sectorId ID of the Sector
     * @param $sort set the direction for the sorting
     * @param $order get the current sorting
     * @return void
     */
    public function findRouteBySector($sectorId, $sort, $order)
    {

        $query = $this->createQuery();
        if( $sectorId ) {
            $query->matching($query->equals('sector.uid', $sectorId));
        }
        if ($order == "asc") {
            $orderValue = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
        } else {
            $orderValue = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
        }
        $query->setOrderings(
            [
                $sort => $orderValue,
            ]
        );

        return $query->execute();
    }

}
