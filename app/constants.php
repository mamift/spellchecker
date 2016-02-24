<?php
/*
 * Most of these constants should be self-explanatory.
 */

define('NOT_HTTPS',                   'All requests must be over HTTPS!');
define('CORSPREFLIGHT',               'CORSPREFLIGHT badness happened!');

define('COMMAND_NO_MESSAGE_SET',      '(no message has been set)');
define('GENERIC_SUCCESS',             'Command succeeded.');
define('GENERIC_FAIL',                'Command failed.');
define('GENERIC_HELP',                'Please view the documentation on how to use this API. Link should be in \'data\' property.');
define('GENERIC_404',                 'Invalid URL.');
define('NEW_WORD_CREATED_SUCCESS',    'Success! New word created: ');
define('NEW_WORD_ALREADY_EXISTS',     'Failure! Word already exists! ');
define('SPELLCHECK_NO_SUGGESTIONS',   'Failure! No suggestions.');
define('SPELLCHECK_KNOWN_WORD',       'Failure! This word is already in the dictionary.');
define('SPELLCHECK_NO_TEXT',          'Failure! Nothing to check.');
define('SPELLCHECK_NO_UNKNOWN_WORDs', 'No unknown words');
define('SPELLCHECK_NOALLCAPS',        'Spellchecker ignores all words in UPPERCASE.');
define('SPELLCHECK_SUCCESS',          'Spellcheck complete.');
define('GENERIC_INCOMPLETE',          'API not live; incomplete implementation.');
define('GENERIC_NOID',                'Must provide ID.');
define('GENERIC_INVALIDID',           'Invalid ID.');
define('GENERIC_NOCONTENT',           'There is no body content in the request.');
define('GENERIC_CHLIMEXCEEDED',       'Character limit exceeded!');
define('DICTIONARY_SERIALISED',       'Dictionary has been serialised.');
define('INVALID_CSRF_TOKEN',          'Invalid CSRF token. Did you forget to shake hands first?');
define('INVALID_APIKEY',              'Invalid API key.');
define('INVALID_REQUEST',             'Invalid request.');
define('INVALID_PREFLIGHT',           'Invalid preflight request.');
define('INVALID_ORIGIN',              'Invalid request origin.');

define('DATABASE_ERROR',              'Some obscene database error occurred. Abandon ship!');

define('DELEGATION_ERROR_NOCLASS',    'Class does not exist!');
define('DELEGATION_ERROR_NOMETHOD',   'Method on the specified class does not exist.');
define('DELEGATION_ERROR_METHODER',   'Method on the specified class failed to execute.');
define('DELEGATION_NOT_A_COMMAND',    'Specified class is not a command class.');
define('DELEGATION_NOHANDLER_SET',    'No handler method set for this delegate.');

define('TBL_APIKEYS',                 'apikeys');
define('TBL_ABBREVIATIONS',           'abbreviations');
define('TBL_WORDS',                   'words');
define('TBL_DICTIONARYENUM',          'dictionaries');
define('TBL_USERS',                   'users');
define('TBL_PASSWORDRESETS',          'passwordresets');
define('TBL_SCATTEMPTS',              'spellcheckattempts');

define('DEFAULT_DATETIMEFORMAT',      "Y-m-d H:i:s");

define('AUTHORISED_REFERRAL_FQDN',    'survey6.spss-asp.com');
define('AUTHORISED_REFERRAL_SLDN',    'spss-asp.com');

define('MAX_TEXT_LENGTH',             16384);

define('V1_API_PREFIX',              'api/v1');

/*
 * @var the relative path to the words.txt file (to be used to fill the database)
 */
define('DB_WORDS_FILE',             'database' . DIRECTORY_SEPARATOR . 'words.txt');
