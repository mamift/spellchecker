<?php
/*
 * Most of these constants should be self-explanatory.
 */

define('COMMAND_NO_MESSAGE_SET',    '(no message has been set)');
define('GENERIC_SUCCESS',           'Command succeeded.');
define('GENERIC_FAIL',              'Command failed.');
define('GENERIC_HELP',              'Please view the documentation on how to use this API.');
define('GENERIC_404',               'Invalid URL.');
define('NEW_WORD_CREATED_SUCCESS',  'Success! New word created: ');
define('NEW_WORD_ALREADY_EXISTS',   'Failure! Word already exists! ');
define('SPELLCHECK_NO_SUGGESTIONS', 'Failure! No suggestions.');
define('SPELLCHECK_KNOWN_WORD',     'Failure! This word is already in the dictionary.');
define('SPELLCHECK_NOALLCAPS',      'Spellchecker ignores all words in UPPERCASE.');
define('SPELLCHECK_SUCCESS',        'Spellcheck complete.');
define('GENERIC_INCOMPLETE',        'API not live; incomplete implementation.');
define('GENERIC_NOID',              'Must provide ID.');
define('GENERIC_INVALIDID',         'Invalid ID.');
define('GENERIC_NOCONTENT',         'There is no body content in the request.');
define('GENERIC_CHLIMEXCEEDED',     'Character limit exceeded!');
define('DICTIONARY_SERIALISED',     'Dictionary has been serialised.');
define('INVALID_CSRF_TOKEN',        'Invalid CSRF token.');
define('INVALID_APIKEY',            'Invalid API key.');

define('DATABASE_ERROR',            'Some obscene database error occurred. Abandon ship!');

define('DELEGATION_ERROR_NOCLASS',  'Class does not exist!');
define('DELEGATION_ERROR_NOMETHOD', 'Method on the speicified class does not exist.');
define('DELEGATION_ERROR_METHODER', 'Method on the speicified class failed to execute.');
define('DELEGATION_NOT_A_COMMAND',  'Specified class is not of the App\\Commands\\ namespace.');

define('TBL_APIKEYS',               'apikeys');
define('TBL_ABBREVIATIONS',         'abbreviations');
define('TBL_WORDS',                 'words');
define('TBL_DICTIONARYENUM',        'dictionaries');
define('TBL_USERS',                 'users');
define('TBL_PASSWORDRESETS',        'passwordresets');

define('DEFAULT_DATETIMEFORMAT',    "Y-m-d H:i:s");

/*
 * @var the relative path to the words.txt file (to be used to fill the database)
 */
define('DB_WORDS_FILE',             'database' . DIRECTORY_SEPARATOR . 'words.txt');
