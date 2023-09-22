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
* The repository for Sectors
*/
class SectorRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
    * sorting sector in the Sector List View, set the direction of the sorting depnding on the current sorting
    *
    * @param $sort set the direction for the sorting
    * @param $order get the current sorting
    * @return void
    */
    public function sortBy($sort, $order)
    {
        $query = $this->createQuery();
        //$query->matching($query->equals('sector.name', $name));

        return $query->execute();
    }

    /**
    * search bar in the Sector List View and keep the sorting
    *
    * @param $keyword wich keyword to search for
    * @param $sort set the direction for the sorting
    * @param $order get the current sorting
    * @return void
    */
    public function findSector($keyword, $sort, $order, $country)
    {
        $query = $this->createQuery();
        $constraints = [];
        if ($keyword) {
            $constraints = $query->logicalOr(
                $query->like('name', "%" . $keyword . "%"),
                $query->like('location', "%" . $keyword . "%")

            );
        }
        if ($country != '') {
            $constraints = $query->equals('country.shortNameEn', $country);
        }

        $query->matching($constraints);
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

        $query->setLimit(200);

        return $query->execute();
    }


}
