CENTER OFFICE PROJECT - 20/12/2015  
--------

=======================================================================

Center office is developed base on Yii 2 framework.

The project includes three tiers: 
work, common, and console, hrm, kpi, cron each of which
is a separate Yii application.

=======================================================================


GETTING STARTED
---------------
After you clone code from git and config on server you must install some following application.

1. install bower, nodejs and composer. You can refer them from web.
2. Set virtual host for server to path/to/<project folder>. For the best, host should be centeroffice.dev .
3. You can refer information about configuration from CONFIG file.
4. You should use netbean because that editor can supply you all necessary tool to develop,
 and change indent for 4 whitespace.

CODING STANDARD
-------
To ensure consistency throughout the source code, keep these rules in mind as you are working.

1. Coding style should write as Yii standard.
2. Each function not to much code line. It should divide in callable function to call from.
3. Use try catch in each section of code for catching error.
4. No write php code logic in view template.
5. When having any change for database, ex: add columns, add key, add default, you should
write code in yii2 MIGRATION to deploy app afterward.

PERFORMANCE 
-----
Yii2 framwork supported very strong technique about cache in many methods. 
So, you should use appropriate cache for data if that data change rarely and big data to 
improve system performance.

LANGUAGE
-----
1. Both Vietnamese and English language with file language.
2. Common message for all package(and common package) that's in common/messages folder. 
3. Message for each module it's in messages folder of that module.
4. Camel at the first char of each phrase in language file.
5. Message for package is in <package>/messages. Ex: work/messages.

 JAVASCRIPT FRAMWORK
-----
We use anglarjs framework. In case we can not use angular js, we can use jquery framework.

ASSET FILES.
-----
You should install git and bower on your local computer.
1. Common javascrip, css, fonts, plugin is in common/web/<type_asset>. Ex: common/web/css
2. Javascript, css, fonts... of each package must in each package.
3. Library javascript from vendor must be in vendor/bower and install by bower software.

YII2 VENDOR PHP
------------
Must install by composer and in vendor/yiisoft/...

CONFIG YII2
------------
Top-down level common -> package. It means common package will contain all of common configuration 
and source code for all package. In each package, it should be same as package -> module.
 
YII2 PHP COMMON SOURCE
------------
1. With common source code for all package must write in in common/components/<type>, with types they 
contain behavior, event, filter, helpers, class, ....
2. With common source code for corresponding package, we must write in <package>/components/<type>. 
With types are behavior, filter, event, class, service locator.

TESTING
-------
Test with chrome, internet explorer, firefox, opera browser and all case in the specification.

DATABASE DIAGRAM
-------
They're in scheme database folder.
1. You can use visual paradigm community to read vpp file and change something from scheme.
2. You can view from image file directly in 