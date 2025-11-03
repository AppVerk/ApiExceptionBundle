<?php

namespace AppVerk\ApiExceptionBundle\DependencyInjection;

use AppVerk\ApiExceptionBundle\Factory\ApiProblemResponseFactory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('app_verk_app_user');
        $rootNode = $treeBuilder->getRootNode();;

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('response_factory')
                    ->defaultValue(ApiProblemResponseFactory::class)
                ->end()
                ->scalarNode('enabled')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('paths_excluded')
                    ->beforeNormalization()->ifString()->then(function ($v) { return array($v); })->end()
                    ->prototype('scalar')->end()
                    ->defaultValue(array('/admin/'))->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
