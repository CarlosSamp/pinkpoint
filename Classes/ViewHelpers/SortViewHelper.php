<?php
namespace Csp\Pinkpoint\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class SortViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $tagName = 'a';
    protected $escapeOutput = false;
    protected $escapeChildren = false;

    public function initializeArguments()
    {
        $this->registerArgument('object', '\Csp\Pinkpoint\Domain\Model\Sector', 'Attributes', false);
        $this->registerArgument('queryResult', 'TYPO3\CMS\Extbase\Persistence\Generic\QueryResult', 'Attributes', false);
        $this->registerArgument('sortby', 'string', 'Sortby', false);
        $this->registerArgument('view', 'string', 'Action', false);
        $this->registerArgument('order', 'string', 'Asc or Desc', false);
        $this->registerArgument('keyword', 'string', 'Keyword', false);
    }

    /**
     * Build a link to set the sorting
     *
     * @param $argumetens all arguments passed to the ViewHelper
     * @param $renderChildreClosure
     * @param $renderingContext
     * @return string $uri link with sorting attributte and direction
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $uriBuilder = $objectManager->get(UriBuilder::class);
        $sortBy = $arguments['sortby'];
        $object = $arguments['object'];
    //    $objects = $arguments['queryResult'];
        $view = $arguments['view'];
        $order = $arguments['order'];
        $keyword = $arguments['keyword'];
        // set the arrow depending on Ascending or Descending
        if ($order['sortBy'] == $sortBy) {
            // pass the direction to build the link in the ViewHelper
            // if now is ascending the the link will give the option descending
            if ( $order['dir'] == "asc" ) {
                $order['dir'] = "desc";
            } else {
                $order['dir'] = "asc";
            }
            $order['label'] = '<span class="icon-markup"><img src="typo3conf/ext/pinkpoint/Resources/Public/Icons/' . $order['dir'] . '.svg" width="16" height="16"></span>';

        } else {
            $order['label'] = '';
            $order['dir'] = "asc";
        }

        $order['sortBy'] = $sortBy;
        // the link with the arguments for the Controller
        $arguments = [ 'order' => $order, 'keyword' => $keyword];
        if (!empty($object)) {
            $arguments['sector']=$object;
        }
        $link = $uriBuilder->uriFor($view, $arguments, 'Sector', 'Pinkpoint', 'Pinkpoint');
        $text = $renderChildrenClosure();

        $uri = '<a href="' . $link . '#open_here" >' . $text . $order['label'] . '</a>';

        return $uri;
    }
}
