# VerteXVaaR.Logs

## Introduction

Finally a backend module to read from the TYPO3 logging API.

Notice: Currently only log tables are supported for reading.
If you need a special log reader (e.g. file or syslog) feel free
to contact me or create a pull request with your proposal ;)

## Basic Usage

### Install via composer

1) Install it via CLI:

    ```bash
    composer require vertexvaar/logs
    ```

2) Activate via CLI

    ```bash
    ./vendor/bin/typo3 extension:activate logs
    ```
   
Alternatively you can switch to the TYPO3 Extension Manager and activate it there

### Install via ExtensionManager

You should really use composer, just sayin'.  ;-)

But you can still install the extensions via the TER and the TYPO3 extension manager.
Don't forget to activate it afterwards.

### Use a download

If you don't want to do cool stuff with composer, you can download this extension as ZIP.
Quick links for downloads:

* [Branch: master](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/master.zip)
* [Tag: 1.1.0](https://github.com/vertexvaar/VerteXVaaR.Logs/archive/1.1.0.zip)

Unzip it in the extension directory and activate it via cli or the TYPO3 Extension Manager.

## In depth

The logging API exists for a long time, but there is no nice way to read
those logs if the user has no direct access to the database or files.

Backend module created - problem solved!

The ConjunctionReader creates an instance of `Reader` for each `Writer`,
which reads from the specific location where the writer writes the log
entries. Therefore it's possible to read and filter logs accross all log
destinations (tables, files, etc.)

## TYPO3 & PHP compatibility

The current major version 3.0 requires PHP 7.0 or higher and support TYPO3 version 9 and 10.

For versions supporting older PHP and / or TYPO3 versions please use the previous tags. But keep in mind, that these are not actively supported and you should strongly consider upgrading your TYPO3 installation.

## TODO

* Register as devlog
* Ensure log sources are processed only once
* Identify and fix that one bug that sometimes won't delete a log entry
* Add a log writer filter (to deselect log readers/erasers) #4

## Found a bug? Feedback?

Please report any bug or negative side effects, as well as your feedback here: [Issues](https://github.com/vertexvaar/VerteXVaaR.Logs/issues)

## Other stuff

Copyright & Author: Oliver Eglseder <php@vxvr.de>
License: GPL-2.0+
