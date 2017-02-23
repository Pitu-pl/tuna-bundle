<?php

namespace TheCodeine\PageBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TheCodeine\PageBundle\Service\PageManager;
use TunaCMS\PageComponent\Model\PageInterface;

class PageParamConverter implements ParamConverterInterface
{
    const PARAM_CONVERTER_NAME = 'page';
    const PARAM_CONVERTER_CLASS = 'TunaCMS\PageComponent\Model\AbstractPage';

    /**
     * @var PageManager
     */
    private $pageManager;

    /**
     * @param PageManager $pageManager
     */
    public function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    /**
     * @inheritdoc
     */
    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getName() !== self::PARAM_CONVERTER_NAME) {
            return false;
        }

        if ($configuration->getClass() !== self::PARAM_CONVERTER_CLASS) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $page = $this->pageManager->find($request->get('id'));

        if (null === $page || !($page instanceof PageInterface)) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $configuration->getClass()));
        }

        $request->attributes->set($configuration->getName(), $page);
    }
}