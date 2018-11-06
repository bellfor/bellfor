2.2.1
-----
- Improve HHVM compatibility by add @ReadOnly annotation to the core DataModel class

2.2.0
-----
- Introduce new constant LOG_DIR that controls the log directory used by Monolog

2.1.1
-----
- Added id to crossselling entity
- Added identity linker crossselling id mapping

2.1.0
-----
- Changed protocol version to 7 due to product image masterkill sorting
- Use stable version of doctrine/collections

2.0.1
-----
- Removed class controller helper
- Changed seo method noDiacritics to replaceDiacritics and makes it public
- Fixed logger force writing flag

2.0.0
-----
- Added initial config "developer_logging" flag
- Removed base connector get and set config

1.0.1
-----
- Changed monolog stream handler to rotate handler

1.0.0
-----
- Added property ean to product variation value
- Change jms serializer version to 1.0
