<?php

namespace Etudor\ViewableBundle\Service;

use function count;
use Doctrine\Common\Collections\Collection;
use Etudor\ViewableBundle\Accessor\ViewableAccessorInterface;
use Etudor\ViewableBundle\Exception\NoAccessorTemplateException;
use Etudor\ViewableBundle\Exception\ViewableException;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Twig_Environment;
use Twig_Error;
use Twig_Error_Loader;

class Generator implements GeneratorInterface
{
    const DEFAULT_VIEW = 'base';

    const DEFAULT_OBJECT_NAME       = 'this';
    const DEFAULT_OBJECT_COLLECTION = 'many';

    /**
     * @var ViewableAccessorInterface[]
     */
    protected $accessors = [];

    /**
     * @var Twig_Environment
     */
    protected $templating;

    /**
     * @var string
     */
    private $defaultViewName;

    /**
     * @var string
     */
    protected $objectNameSingle = self::DEFAULT_OBJECT_NAME;

    /**
     * @var string
     */
    protected $objectNameCollection = self::DEFAULT_OBJECT_COLLECTION;

    /**
     * @param Twig_Environment $templating
     * @param string           $defaultViewName
     */
    public function __construct(
        Twig_Environment $templating,
        string $defaultViewName = self::DEFAULT_VIEW
    )
    {
        $this->templating      = $templating;
        $this->defaultViewName = $defaultViewName;
    }

    /**
     * @param        $object
     * @param string $view
     * @param []     $params
     *
     * @return string
     *
     * @throws ViewableException
     */
    public function generate($object, $view = null, $params = []): string
    {
        # pick the default view
        if (null === $view) {
            $view = $this->defaultViewName;
        }

        if (is_array($object) || $object instanceof Collection) {

            if (count($object) == 0) {
                return '';
            }

            $singleTemplate = 'Entity/' . $this->getClassName($object[0]) . '/Listing/' . $view . '.html.twig';

            return $this->load($object, $singleTemplate, $params, $this->objectNameCollection);
        }

        try {
            $template = $this->loadAccessorTemplate($object, $view, $params, $this->objectNameSingle);
        } catch (NoAccessorTemplateException $e) {
            try {
                // fallback
                $viewTemplate = 'Entity/' . $this->getClassName($object) . '/' . $view . '.html.twig';
                $template     = $this->load($object, $viewTemplate, $params, $this->objectNameSingle);
            } catch (Twig_Error $e) {
                throw new ViewableException(
                    $e->getMessage()
                );
            }
        }

        return $template;
    }

    /**
     * @param ViewableAccessorInterface $accessor
     */
    public function registerAccessor(ViewableAccessorInterface $accessor)
    {
        $this->accessors[] = $accessor;
    }

    /**
     * @param $object
     * @param $view
     * @param $params
     *
     * @return string
     */
    protected function load($object, $view, $params, $objectNameInView)
    {
        return $this->templating->render(
            $view,
            array_merge($params, [$objectNameInView => $object])
        );
    }

    /**
     * @param $object
     * @param $view
     * @param $params
     * @param $objectNameInView
     *
     * @return string
     *
     * @throws NoAccessorTemplateException
     */
    protected function loadAccessorTemplate($object, $view, $params, $objectNameInView)
    {
        foreach ($this->accessors as $accessor) {

            $viewTemplate = $this->getClassName($object) . ':' . $view . '_' . $accessor->getAccessor($object);

            try {
                return $this->load($object, $viewTemplate, $params, $objectNameInView);
            } catch (Twig_Error $e) {
                // view does not exists
                return null;
            }

        }

        throw new NoAccessorTemplateException(
            sprintf("The object %s does not match any view accessors for view %s.", $this->getClassName($object), $view)
        );
    }

    /**
     * @param $object
     *
     * @return string
     */
    protected function getClassName($object)
    {
        return (new ReflectionClass($object))->getShortName();
    }
}
