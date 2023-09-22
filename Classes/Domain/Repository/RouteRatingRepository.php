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
 * The repository for RouteRatings
 */
class RouteRatingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * find Rating by Route and Climber
     *
     * @param \Csp\Pinkpoint\Domain\Model\Route $route
     * @param \Csp\Pinkpoint\Domain\Model\Climber $climber
     * @return void
     */
    public function getByRouteAndClimber($route, $climber)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('climber.uid', $climber->getUid()),
                    $query->equals('route.uid', $route->getUid()),

                ]
            )
        );

        return $query->execute();
    }

}
