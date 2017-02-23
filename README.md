Tuna CMS TunaBundle

[![Build Status](https://travis-ci.org/Tuna-CMS/tuna-bundle.svg?branch=master)](https://travis-ci.org/Tuna-CMS/tuna-bundle)
[![Latest Stable Version](https://poser.pugx.org/tuna-cms/tuna-bundle/v/stable)](https://packagist.org/packages/tuna-cms/tuna-bundle)
[![Total Downloads](https://poser.pugx.org/tuna-cms/tuna-bundle/downloads)](https://packagist.org/packages/tuna-cms/tuna-bundle)
[![License](https://poser.pugx.org/tuna-cms/tuna-bundle/license)](https://packagist.org/packages/tuna-cms/tuna-bundle)

## Installation:
1. Require module

        composer require "tuna-cms/tuna-bundle": "^1.0.0"

2. Add following line to `AppKernel::registerBundles()`

        TheCodeine\AdminBundle\BundleDependencyRegisterer::register($bundles);

3. Import Tuna config:

        imports:
            - { resource: '@TheCodeineAdminBundle/Resources/config/config.yml' }

4. Migrate db

        doctrine:migrations:diff && doctrine:migrations:migrate

5. Add routing

        # app/config/routing.yml

        the_codeine_tuna_admin:
            resource: "@TheCodeineAdminBundle/Resources/config/routing.yml"

6. Change editor config to (will be changed in next releases)

        the_codeine_admin:
            components:
                editor:
                    wysiwyg_style_dir: '%kernel.root_dir%/../vendor/tuna-cms/tuna-bundle/Resources/public/sass/editor'

7. Override config

Tuna injects some basic configs, but feel free to override them (be aware that you can break some of functionalities by this).
For newest config defaults check [Resources/config/config.yml](Resources/config/config.yml). This file also includes
[Resources/config/security.yml](Resources/config/security.yml), so be sure to clear your security.yml file, or override some parts.

You can also fine tune Tuna by changing bundle config.
Here is full option config with defaults:

    the_codeine_admin:
        paths:
            admin_logo: bundles/thecodeineadmin/images/logo.png
            editor_config: bundles/tunacmseditor/js/editorConfig.js
        
        host: null
        
        menu_builder: TheCodeine\AdminBundle\Menu\Builder
        
        locale: en
        
        locales:
            - en
            - pl
        
        components:
            pages:
                enabled: true
                create: true
                delete: true
            
            editor:
                wysiwyg_style_dir: %kernel.root_dir%/../vendor/tuna-cms/tuna-bundle/Resources/public/sass/editor
            
            menu:
                enabled: true
                default_template: 'TheCodeineMenuBundle:Menu:render_menu.html.twig'
            
            security:
                enabled: true
                use_access_control: true
            
            news:
                enabled: true
            
            events:
                enabled: false
            
            translations:
                enabled: true
            
            categories:
                enabled: false



## Documentation

You can find documentation [here](docs/index.md)
