VerteXVaaR.Logs
===============

## Introduction

Finally a backend module to read from the TYPO3 logging API.

Notice: Currently only log tables are supported for reading.
If you need a special log reader (e.g. file or syslog) feel free
to contact me or create a pull request with your proposal ;)

## Basic Usage

Relax and install via composer:

CLI walkthrough:

```
composer require vertexvaar/logs
```

Activate cia CLI or Extension Manager.

Other way (EM):

You should really use composer, just sayin'. But you can still install the extensions via the TYPO3 extension manager.
Don't forget to activate it afterwards.

Last way (DL):

If you don't want to do cool stuff with composer you can download this extension as ZIP.
Quick links for downloads:

* [Branch: master](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/master.zip)
* [Tag: 1.1.0](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/1.1.0.zip)

## In depth

The logging API exists for a long time, but there is no nice way to read
those logs if the user has no direct access to the database or files.

Problem solved, backend module created.

The ConjunctionReader creates an instance of `Reader` for each `Writer`,
which read from the specific location where the writer writes the log
entries. Therefore it's possible to read and filter logs accross all log
destinations (tables, files, etc.)

## TYPO3 & PHP compatibility

PHP 5.3 reached its end of life and TYPO3 6.2 will end in 31 March 2017. There is no point in supporting those two anymore.
PHP 5.4 and 5.5 are no longer supported by the PHP group, but they are still widely used.
I want to encourage you to upgrade to at least PHP 5.6, but if you are tied to it then you can still go with the v1 branch of logs.
The v2 branch is is based on Doctrine DBAL, therefore requires TYPO3 v8 or higher.

## TODO

* Register as devlog
* ~~Also read from sys_log (maybe some adapter thingy?)~~
* Ensure log sources are processed only once
* Identify and fix that one bug that sometimes won't delete a log entry
* Save the current filter in the user data so it still applies after reopening the module or deletion of an entry

## Found a bug? Feedback?

Please report any bug or negative side effects, as well as your feedback here: [Issues](https://github.com/vertexvaar/VerteXVaaR.Logs/issues)

## Other stuff

Copyright & Author: Oliver Eglseder <php@vxvr.de>
License: GPL-2.0+
