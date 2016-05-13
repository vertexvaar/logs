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
./typo3/cli_dispatch.phpsh extbase extension:install typo3booster
```

Other way:

C'mon...
Please stick to composer. But you can still activate the extensions via
the TYPO3 extension manager.

If you don't want to do cool stuff with composer you can download this
extension as ZIP. Quick links for downloads:

* [Branch: master](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/master.zip)
* [Tag: 1.0.0](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/1.0.0.zip)

## In depth

The logging API exists for a long time, but there is no nice way to read
those logs if the user has no direct access to the database or files.

Problem solved, backend module created.

The ConjunctionReader creates an instance of `Reader` for each `Writer`,
which read from the specific location where the writer writes the log
entries. Therefore it's possible to read and filter logs accross all log
destinations (tables, files, etc.)

## Found a bug? Feedback?

Please report any bug or negative side effects, as well as your feedback
 here [Issues](https://github.com/vertexvaar/VerteXVaaR.Logs/issues)

## Other stuff

Copyright & Author: Oliver Eglseder <php@vxvr.de>
License: GPL-2.0+
