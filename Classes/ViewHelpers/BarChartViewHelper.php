<?php
namespace Csp\Pinkpoint\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class BarChartViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;
    protected $escapeChildren = false;

    public function initializeArguments()
    {

        $this->registerArgument('dataset', 'Csp\Pinkpoint\Domain\Model\Sector', 'The data with the categorized X-Axis', false);
        $this->registerArgument('labels', 'Csp\Pinkpoint\Domain\Model\Sector', 'The label on the Y-Axis ', false);
        $this->registerArgument('colors', 'Csp\Pinkpoint\Domain\Model\Sector', 'The label on the Y-Axis ', false);
    }
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {

        foreach ($arguments as $key => $value) {
            if ($value !== null) {
                $sector = $value;
            }
        }

        $counts = substr($counts, 0, -2);
        $counts = $sector->getRouteCountByGrade($grade);
        $labels = '';
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($counts);
        // die();
        foreach ($counts as $key => $value) {

            $colorcode = '';
            $colorcode = self::getColor($key);
            $keyLabel = LocalizationUtility::translate('tx_pinkpoint_domain_model_route.grade.' . $key, 'pinkpoint');
            $labelString .= $keyLabel . ', ';
            $countString .= $value . ', ';
            $colorString .= $colorcode . '; ';

        }
        $labelString = substr($labelString, 0, -2);
        $countString = substr($countString, 0, -2);
        $colorString = substr($colorString, 0, -2);
        $resultCount = '' . $countString . '';


        if ($arguments['labels']) {
            $resultLabel = ''. $labelString . '';

            return $resultLabel;
        } else if ($arguments['dataset']) {

            return $resultCount;
        } else if ($arguments['colors']) {

            $resultColors = ''. $colorString . '';
            return $resultColors;
        }

    }

    public static function getColor($k)
    {
        //Farbe nach Uid bestimmen
        $randomString = md5($k); // like "d73a6ef90dc6a ..."
        $r = rand(0, 255); //1. and 2.
        $g = rand(0, 255); //3. and 4.
        $b = rand(0, 255); //5. and 6.

        //Farbe nach Wunsch bestimmen
        if ($k >= 0 && $k <= 7) {
            $colorcode = '#2FFFFF';
        }
        if ($k >= 8 && $k <= 13) {
            $colorcode = '#E85BFB';
        }
        if ($k >= 13 && $k <= 18) {
            $colorcode = '#16FC16';
        }
        if ($k >= 19 && $k <= 24) {
            $colorcode = '#FFF00D';
        }
        if ($k >= 25 && $k <= 30) {
            $colorcode = '#FB5B5B';
        }
        if ($k >= 31 && cc <= 36) {
            $colorcode = '#5571FF';
        }
        // ab 5. farbe Wieder naach ID
        if ($k > 36) {
            $colorcode = 'rgb(' . $r .','. $g.','. $b . ')';
        }
        return $colorcode;
    }

}
