<?php

namespace TheCodeine\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('the_codeine_page');

        $rootNode
            ->children()
                ->scalarNode('model')->defaultValue('TheCodeine\PageBundle\Entity\Page')->end()
            ->end();

        return $treeBuilder;
    }
}
