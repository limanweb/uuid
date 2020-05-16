# limanweb/uuid

## Description

Package provides any functions to generate and analyze UUID.

There used custom algorithm to generate UUID with next structure:

	SSSSSSSS-UUUU-UAAA-EEEE-RRRRRRRRRRRR

 - `S` - 8 hex digits with seconds value of UUID generating timestamp
 - `U` - 5 hex digits with microseconds value of UUID generating timestamp
 - `A` - 3 hex digits with custom application code
 - `E` - 4 hex digits with custom entity code
 - `R` - 12 hex digits whith random value
	

## Installation

Run command to install a package into you project

	composer require limanweb/uuid

## Common Functions

### genUuid()

Syntax:

	genUuid(int $entityCode = null, int $appCode = null) : string
	
Returns UUID-string.

Params:

* `$entityCode` - custom integer code of entity
* `$appCode` - custom integer code of application

Returns UUID string.

Example:

	$uuid = \Limanweb\Support\Uuid::genUuid(256, 15);
	
	echo $uuid; // '5ec004c4-0db2-0010-0100-a08cc1dd9a2b'


### getUuidTimestamp()

Syntax:

	getUuidTimestamp(string $uuid, string $format = 'Carbon') : mixed
	
Exclude timestamp from UUID generated by genUuid(). 

Params:

* `$uuid` - analyzed UUID;
* `$format` - format of returning timestamp value. You can use one of tree variants:
  * `Carbon` (default) to get timestamp as \Carbon\Carbon object;
  * `DateTime` to get timestamp as \DateTime object;
  * date format string used for `format()` to get timestamp as formatted string. For example: `'Y-m-d H:i:s.u'`

	