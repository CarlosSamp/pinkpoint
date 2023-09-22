<?php
namespace Csp\Pinkpoint\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class StackedDataViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;
    protected $escapeChildren = false;

    public function initializeArguments()
    {

        $this->registerArgument('dataset', 'Csp\Pinkpoint\Domain\Model\Climber', 'The data with the categorized X-Axis', false);
        $this->registerArgument('labels', 'Csp\Pinkpoint\Domain\Model\Climber', 'The label on the Y-Axis ', false);
        $this->registerArgument('count-grades', 'Csp\Pinkpoint\Domain\Model\Climber', 'The label on the Y-Axis ', false);
    }

    /**
     * prepare Data for the stackedChart
     *
     * @param $argumetens all arguments passed to the ViewHelper
     * @param $renderChildreClosure
     * @param $renderingContext
     * @return string $ascents Gradelabels, $result the count of the Ascents or $height of the Chart
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {

        $ascents = [
            'grades' => [],
            'gradeLabels' => '',
            'arts' => [],
            'artLabels' => [],
            'ascents' => [],
            'sortedGrades' => [],
        ];
        foreach ($arguments as $key => $value) {

            if ($value !== null) {
                $climber = $value;

                foreach ($value->getAscents() as $i => $ascent) {
                    if ($ascent->getRoute()) {
                        array_push($ascents['ascents'], $ascent);
                        $grade = $ascent->getRoute()->getGrade();
                        $art = $ascent->getAscentArt();

                        // filter grades
                        if (!in_array($grade, $ascents['grades']) && $grade) {
                            array_push($ascents['grades'], $grade);

                        }
                        // filter ascentsArts
                        if (!in_array($art, $ascents['arts'])) {
                            array_push($ascents['arts'], $art);

                        }
                    }
                }
            }
        }

        //
        sort($ascents['arts']);
        foreach ($ascents['arts'] as $key => $art) {
            $artLabel = LocalizationUtility::translate('tx_pinkpoint_domain_model_ascent.ascent_art.' . $art, 'pinkpoint');
            array_push($ascents['artLabels'], $artLabel);
            $artlabels .= '\'' . $artLabel . '\'' . ', ';
        }

        rsort($ascents['grades']);

        $counts = substr($counts, 0, -2);

        // count per ascentArt and write in string
        foreach ($ascents['arts'] as $k => $art) {

            // initialize values
            $countString = '';
            $count = 0;
            $vorkat = [];
            $colorcode = '';
            $colorcode = self::getColor($art);

            foreach ($ascents['grades'] as $key => $grade) {
                // count each Y-Axis when matching with ascentArt
                $count = $climber->getCountByGradeAndArt($grade, $art);
                if ($count > 0) {
                    $countString .= $count . ', ';
                } else {
                    $countString .= 0 . ', ';
                }
            }

            $countString = substr($countString, 0, -2);

            // endresult -> for each AscentArt will be a sum to the corresponding X-Axis(Grade)
            $result .= '{"label": "' . $ascents['artLabels'][$k] . '", "data":[' . $countString . '],"backgroundColor":"' . $colorcode . '"}; ';
        }

        // remove the comma at the end
        $result = substr($result, 0, -2);

        if ($arguments['labels']) {
            // set Labels to sorting of grades
            foreach ($ascents['grades'] as $key => $grade) {
                $gradeLabel = LocalizationUtility::translate('tx_pinkpoint_domain_model_route.grade.' . $grade, 'pinkpoint');
                $gradelabels .= '' . $gradeLabel . '' . ', ';
            }
            $gradeLabels = substr($gradelabels, 0, -2);
            $ascents['gradeLabels'] = $gradeLabels;

            return $ascents['gradeLabels'];
        } else if ($arguments['dataset']) {
            return $result;
        } else if ($arguments['count-grades']) {
            $height = 50 * count($ascents['grades']);
            return $height;
        }

    }

    /**
     * prepare Data for the stackedChart
     *
     * @param $k key for the ascentArt
     * @return string $colorcode RGB String of the colorcode
     */
    public static function getColor($k)
    {
        //Farbe nach Uid bestimmen
        $randomString = md5($k); // like "d73a6ef90dc6a ..."
        $r = substr($randomString, 0, 2); //1. and 2.
        $g = substr($randomString, 2, 2); //3. and 4.
        $b = substr($randomString, 4, 2); //5. and 6.

        //Farbe nach Wunsch bestimmen
        if ($k == 0) { // None
            $colorcode = '#666'; // black
        }
        if ($k == 1) { // OnSight
            $colorcode = '#000';
        }
        if ($k == 2) { // Flash
            $colorcode = '#CDD700'; // yellow
        }
        if ($k == 3) { // Redpoint
            $colorcode = '#B00000'; // red
        }
        if ($k == 4) { // AllFree
            $colorcode = '#D307CC'; // pink
        }
        if ($k == 5) {
            $colorcode = '#4252FF'; // blue
        }
        // ab 5. farbe Wieder naach ID
        if ($k > 5) {
            $colorcode = '\'#' . $r . $g . $b . '\'';
        }
        return $colorcode;
    }

}
