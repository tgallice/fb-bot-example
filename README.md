#Facebook messenger bot example

This is an example of how to used the `tgallice/fb-messenger-sdk`. It is a really simple bot that will repeat what the user tells him.
It based on the [silex][1] micro framework and this **should not** be used in production.


## How to install:
```bash
$ git clone git@github.com:tgallice/fb-bot-example.git
$ cd fb-bot-example
$ composer install
$ cp app/config.php.dist app/config.php
```

### Configure

Open `app/config.php` file and used your custom values. Theses values are provided by facebook when you create an application.
See https://developers.facebook.com/docs/messenger-platform/guides/quick-start for more details.

### Callback URL

You need to setup your server to use `/web` as root folder.
Then your callback url will be: https://your-domain.com/index.php/webhook/

**NB: You must have a secure callback url (https)**

[1]: http://silex.sensiolabs.org/
