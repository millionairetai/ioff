 CENTER OFFICE PROJECT - 20/12/2015                                                                           
=====================================

Center office is developed base on Yii 2 framework

The project includes three tiers: work, common, and console, hrm, kpi, cron each of which
is a separate Yii application.

======================================


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. install bower components
	* cd path/to/your-project(ex: c:\xampp\htdocs\centeroffice)
	* npm bower install (or "npm bower update" to update)
2. Set virtual host for server to path/to/<project folder>. Ex: 
3. Set up migration
    - run command: yii migration/up
4. Install (combine) css
    - we are using [less](http://lesscss.org/)
    - to combine css go to frontend/css then run this command: find ./ -name '*.less' -exec lessc -x {} \; > combined.css

Coding standard
-------

Code write as Yii standard.

To ensure consistency throughout the source code, keep these rules in mind as you are working:
All features or bug fixes must be tested by one or more specs.
All public API methods must be documented with phpdpcs/jsdoc
Variable/Properties (of mongoDB, class) must follow camelCase rule

With the exceptions listed below, we follow the rules contained in Idiomatic JavaScript:
Wrap all code at 100 characters.
We're not using comma first convention.
We use whitespace rule in section 2.D instead of 2.A, which means we don't put extra spaces inside of parentheses.
Instead of complex inheritance hierarchies, we prefer simple objects. We use prototypical inheritance only when absolutely necessary.

We love functions and closures and, whenever possible, prefer them over objects.
To write concise code that can be better minified, internally we use aliases that map to the external API.
We don't go crazy with type annotations for private internal APIs unless it's an internal API that is used throughout the project. The best guidance is to do what makes the most sense.

Each function not to much code line, no greater than 50 line. Should divide in callable function to call from.

Use try catch in each section of code for catching error.

LANGUAGE.
-----
1. Both Vietnamese and English language with file language.
2. Common message for all package(and common package) that's in common/messages folder. 
3. Message for each module it's in message folder of that module.
4. Camel at the first char of each phrase in language file.
5. Message for package is in <package>/messages. Ex: work/messages.


FRAMWORK JAVASCRIPT
-----
Only use anglar js. In case we can not use angular js, we can use jquery framework.

ASSET FILES.
-----
Common javascrip, css, fonts, plugin is in common/web/<type_asset>. Ex: common/web/css
Javascript, css, fonts... of each package must in each package.
Library javascript from vendor must be in vendor/bower and install by bower software.

Yii2 vendor php
------------
Must install by composer and in vendor/yiisoft/...

CONFIG YII2
------------
Top level common -> package.
 
YII2 PHP COMMON SOURCE
------------
1. With common source code for all package must write in in common/components/<type>, with types they contain behavior, event,
filter, helpers, class, ....

2. With common source code for corresponding package, we must write in <package>/components/<type>. With types are behavior, filter, event, class, service locator.

TESTING
-------
We use [codeception](http://codeception.com/) for testing
Test with chrome, internet explorer, firefox, opera browser.

//.....


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend

console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime

work
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
kpi
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets

hrm
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets

cron/                    contains dependent items for cron packages

vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```