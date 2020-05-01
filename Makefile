## Show this help
help:
	echo "$(EMOJI_interrobang) Makefile version $(VERSION) help "
	echo ''
	echo 'About this help:'
	echo '  Commands are ${BLUE}blue${RESET}'
	echo '  Targets are ${YELLOW}yellow${RESET}'
	echo '  Descriptions are ${GREEN}green${RESET}'
	echo ''
	echo 'Usage:'
	echo '  ${BLUE}make${RESET} ${YELLOW}<target>${RESET}'
	echo ''
	echo 'Targets:'
	awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")+1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${YELLOW}%-${TARGET_MAX_CHAR_NUM}s${RESET} ${GREEN}%s${RESET}\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Run all Quality Assurance targets
qa-all: qa-lint-all qa-code-sniffer qa-mess-detector
	echo "$(EMOJI_thumbsup) All clear"

## Lint all languages
qa-lint-all: qa-lint-composer qa-lint-php-all

## Validate the composer.json schema
qa-lint-composer:
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/php:7.2-fpm composer validate --strict

## PHP lint for all language levels
qa-lint-php-all: qa-lint-php-7.1 qa-lint-php-7.2 qa-lint-php-7.3 qa-lint-php-7.4

## PHP lint for language level 7.1
qa-lint-php-7.1:
	echo "$(EMOJI_digit_seven)$(EMOJI_digit_one) $(EMOJI_elephant) PHP lint 7.1"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/php-parallel-lint:7.1 parallel-lint Classes/

## PHP lint for language level 7.2
qa-lint-php-7.2:
	echo "$(EMOJI_digit_seven)$(EMOJI_digit_two) $(EMOJI_elephant) PHP lint 7.2"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/php-parallel-lint:7.2 parallel-lint Classes/

## PHP lint for language level 7.3
qa-lint-php-7.3:
	echo "$(EMOJI_digit_seven)$(EMOJI_digit_three) $(EMOJI_elephant) PHP lint 7.3"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/php-parallel-lint:7.3 parallel-lint Classes/

## PHP lint for language level 7.4
qa-lint-php-7.4:
	echo "$(EMOJI_digit_seven)$(EMOJI_digit_four) $(EMOJI_elephant) PHP lint 7.4"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/php-parallel-lint:7.4 parallel-lint Classes/

## PHP code sniffer
qa-code-sniffer:
	echo "$(EMOJI_pig_nose) PHP Code Sniffer"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/phpcs:7.2 phpcs

## PHP
qa-fix-code-sniffer:
	echo "$(EMOJI_broom) PHP Code Beautifier and Fixer"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/phpcs:7.2 phpcbf

## PHP mess detector
qa-mess-detector:
	echo "$(EMOJI_customs) PHP Mess Detector"
	docker run --rm -it -u1000:1000 -v "$$PWD":/app in2code/phpmd:7.2 phpmd Classes ansi .phpmd.xml

# SETTINGS
MAKEFLAGS += --silent
SHELL := /bin/bash
VERSION := 1.0.0

# COLORS
RED  := $(shell tput -Txterm setaf 1)
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
BLUE   := $(shell tput -Txterm setaf 4)
WHITE  := $(shell tput -Txterm setaf 7)
RESET  := $(shell tput -Txterm sgr0)

# EMOJIS (some are padded right with whitespace for text alignment)
EMOJI_interrobang := "⁉️ "
EMOJI_thumbsup := "👍️"
EMOJI_elephant := "🐘️"
EMOJI_broom := "🧹"
EMOJI_digit_one := "1️"
EMOJI_digit_two := "2️"
EMOJI_digit_three := "3️"
EMOJI_digit_four := "4️"
EMOJI_digit_seven := "7️"
EMOJI_pig_nose := "🐽"
EMOJI_customs := "🛃"
