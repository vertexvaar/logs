<?php
namespace VerteXVaaR\Logs\ViewHelpers\Format;

use Closure;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Class MicrotimeViewHelper
 */
class MicrotimeViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * @param float $microTime
     * @param string $format
     * @return string
     */
    public function render($microTime, $format = 'Y-m-d H:i:s.u')
    {
        return static::renderStatic(
            [
                'microTime' => $microTime,
                'format' => $format,
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $microTime = $arguments['microTime'];
        $format = $arguments['format'];

        if (false !== strpos($microTime, '.')) {
            $dateTime = \DateTime::createFromFormat('U.u', $microTime);
        } elseif (false !== strpos(' ', $microTime)) {
            $dateTime = \DateTime::createFromFormat('u U', $microTime);
        } else {
            $dateTime = \DateTime::createFromFormat('U', (int)$microTime);
        }

        return $dateTime->format($format);
    }
}
