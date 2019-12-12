## About Open Api

​		Through the open interface, developers can easily and quickly access functions such as sending text messages or sending emails.

## Existing features

- Send SMS
- Send email

## How to use?

### Install

```shell
composer repuire bryce/openapi
```

### Send SMS verification code

```php
<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
require_once 'vendor/autoload.php';

$sms = new \Bryce\OpenApi\Sms();

$sms->setClientId('Your client id');
$sms->setClientKey('Your client key');

if ($sms->send('188****1019')) exit('Success');
else exit('Failure');
```

> - You should have permission to send sms
> - Each mobile phone number can only send 1 text message per minute, and up to 5 text messages per day.

## Verify SMS Verification Code

```php
<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
require_once 'vendor/autoload.php';

$mailer = new \Bryce\OpenApi\Sms();

$sms->setClientId('Your client id');
$sms->setClientKey('Your client key');

if ($mailer->verifyCode('188****1019', 434307)) exit('Success');
else exit('Failure');
```



## Send email

```php
<?php
/**
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
require_once 'vendor/autoload.php';

$mailer = new \Bryce\OpenApi\Mailer();

$mailer->setClientId('Your client id');
$mailer->setClientKey('Your client key');

if ($mailer->send('To email', 'subject', 'body')) exit('Success');
else exit('Failure');
```

> - You should have permission to send mail
> - Sending attachments is currently not supported

## How to get Client ID?

[Get client ID now](http://core.lushaoming.site/apply)