newsletter
==========
newsletter

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tikarj21/yii2-newsletter "*"
```

or add

```
"tikarj21/newsletter": "*"
```

to the require section of your `composer.json` file.

Usage
-----config.php

      'modules' => [
		---
         
        'newsletter' => [
            'class' => 'tikaraj21\newsletter\Newsletter',
        ],
         ----
	],

	and for mail sending use
	'components' => [

            ...

            'email' => 'tikaraj21\newsletter\mailer\Mail',
            
            ...

    ],
	
To use menu manager (optional). Execute yii migration here:
```
yii migrate --migrationPath=@tikaraj21/newsletter/migrations	
	
	1. __BaseUrl__/newsletter/group/index
	2. __BaseUrl__/newsletter/mergefields
	3. __BaseUrl__/newsletter/email-templates
	4. __BaseUrl__/newsletter/main/mailcreate
	5. __BaseUrl__/newsletter/main/sending
	6. __BaseUrl__/newsletter/setting/index
	
Once the extension is installed, simply use it in your code by  :

```php
