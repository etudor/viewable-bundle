<?php

namespace Etudor\ViewableBundle\Service;

use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use ReflectionClass;
use Twig_Environment;
use Twig_Error;
use Twig_Error_Loader;

class Generator implements GeneratorInterface
{
    /**
     * @var Twig_Environment
     */
    protected $templating;

    public function __construct(Twig_Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param $object
     * @param string $view
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function generate($object, $view = 'base', $params = []) : string
    {
        if (is_array($object) && empty($object)) {
            return '';
        }

        if (is_array($object) || $object instanceof Collection) {
            $singleTemplate = 'Entity/' . $this->getClassName($object[0]) . '/Listing/' . $view . '.html.twig';

            try {
                return $this->templating->render(
                    $singleTemplate,
                    array_merge($params, ['many' => $object])
                );
            } catch (Twig_Error_Loader $e) {

                $paths = $this->templating->getLoader()->getPaths();

//                touch($paths . $this->templating->getLoader()->);

                return '';
            }
        }

        try {
            $singleTemplate = 'Entity/' . $this->getClassName($object) . ':' . $view . $object->getId() . '.html.twig'; // TODO add multiple variation types

            return $this->templating->render(
                $singleTemplate,
                array_merge($params, ['this' => $object])
            );
        } catch (Twig_Error $e) {
            // TODO do something when error
        }

        $generateTemplate = 'Entity/' . $this->getClassName($object) . '/' . $view . '.html.twig';

        return $this->templating->render(
            $generateTemplate,
            array_merge($params, ['this' => $object])
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
