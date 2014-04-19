<?php

namespace Volleyball\UtilityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('volleyball_utility');

        $rootNode->
            children()
                ->scalarNode("breadcrumbs_separator")
                    ->defaultValue("/")
                    ->end()
                ->scalarNode("breadcrumbs_separatorClass")
                    ->defaultValue("separator")
                    ->end()
                ->scalarNode("breadcrumbs_listId")
                    ->defaultValue("volleyball-breadcrumbs")
                    ->end()
                ->scalarNode("breadcrumbs_listClass")
                    ->defaultValue("breadcrumb")
                    ->end()
                ->scalarNode("breadcrumbs_itemClass")
                    ->defaultValue("")
                    ->end()
                ->scalarNode("breadcrumbs_linkRel")
                    ->defaultValue("")
                    ->end()
                ->scalarNode("breadcrumbs_locale")
                    ->defaultNull()
                    ->end()
                ->scalarNode("breadcrumbs_translation_domain")
                    ->defaultNull()
                    ->end()
                ->scalarNode("breadcrumbs_viewTemplate")
                    ->defaultValue("VolleyballUtilityBundle:Base:breadcrumbs.html.twig")
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
