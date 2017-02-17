<?php

namespace TheCodeine\AdminBundle;

class BundleDependencyRegisterer
{
    static public function register(array &$bundles)
    {
        $dependencies = array(
            new \TheCodeine\AdminBundle\TheCodeineAdminBundle(),
            new \TheCodeine\CategoryBundle\TheCodeineCategoryBundle(),
            new \TunaCMS\EditorBundle\TunaCMSEditorBundle(),
            new \TheCodeine\FileBundle\TheCodeineFileBundle(),
            new \TheCodeine\PageBundle\TheCodeinePageBundle(),
            new \TheCodeine\VideoBundle\TheCodeineVideoBundle(),
            new \TheCodeine\GalleryBundle\TheCodeineGalleryBundle(),
            new \TheCodeine\TagBundle\TheCodeineTagBundle(),
            new \TheCodeine\NewsBundle\TheCodeineNewsBundle(),
            new \TheCodeine\MenuBundle\TheCodeineMenuBundle(),
            new \TheCodeine\UserBundle\TheCodeineUserBundle(),
            new \TheCodeine\TranslationBundle\TheCodeineTranslationBundle(),
            new \Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),
            new \Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \FOS\RestBundle\FOSRestBundle(),
            new \FOS\UserBundle\FOSUserBundle(),
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new \JMS\TranslationBundle\JMSTranslationBundle(),
            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new \Lexik\Bundle\TranslationBundle\LexikTranslationBundle(),
            new \Liip\ImagineBundle\LiipImagineBundle(),
            new \SmartCore\Bundle\AcceleratorCacheBundle\AcceleratorCacheBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Vich\UploaderBundle\VichUploaderBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \winzou\Bundle\StateMachineBundle\winzouStateMachineBundle(),
            new \A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new \Scheb\TwoFactorBundle\SchebTwoFactorBundle(),
        );

        foreach ($bundles as $bundle) {
            foreach ($dependencies as $k => $dependency) {
                if ($bundle instanceof $dependency) {
                    unset($dependencies[$k]);
                }
            }
        }

        $bundles = array_merge($bundles, $dependencies);
    }
}