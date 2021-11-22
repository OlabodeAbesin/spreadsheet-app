# Spreadsheet App

This application is a command-line program (built on symfony) that processes a local or remote XML file and pushes the data of that XML file to a Google Spreadsheet via the
Google Sheets API

## Dependencies
You should be running PHP 8.0+, the latest version of composer and available to use command line on your machine for any commands listed below. How you run PHP is up to you!

## Phar file

Delivered as a phar file, phar file name is `spreadsheet.phar` located in root of the folder


## Local setup

**1. Run composer install:**
To set up the dependencies run `composer install` the within project's root directory.
```bash
composer install
```

**2. Run application:**
To run the app, use:

```bash
php bin/console process-sheet
```
If you have a remote file, pass it like this

```bash
php bin/console process-sheet -f file_url
```
The Google authentication keys are in `configs\google_api_service_account\credentials.json` file. They are configurable/can be switched.
Sample output from consle: https://docs.google.com/spreadsheets/d/1gXmGtX3FXTOZ7JW5icbpfivs2XfiAqI6d_z5n2ZVFlw/edit#gid=0
## Testing

**Run tests:**

Run `./vendor/bin/phpunit`

