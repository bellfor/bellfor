0.6.4
------
- Create category tree table on install
- Fill category tree table on install
- HTML decode OpenCart descriptions
- Delete delivery note as it is just compatible with OpenCart Openbay
- Fix product and group prices
- Add db folder to write access check

0.6.3
------
- Add support for block pricing
- Update image path
- Fix payment error
- Fix vat for customer order items
- Adapt name of OpenCart specific archive

0.6.2
------
- Refactor source code 
    - reduce duplication
    - make code better readable
    - make code better testable
- Update tests
- Document code
- Fix not saved checksums
- Remove logs directory
- Set log path to opencart log directory
- Log Db classes queryOne method calls in database.log
- Remove config.json
- Fix connector version in identify call

0.6.1
------
- Add id to cross sellings
- Change connector version storage
- Hotfix missing bootstrap file
- Move CHANGELOG and README files
- Write tests for mapper and utility
- Make code more decoupled for testing

0.6.0
------
- Support VAT number, salutation and title by using custom fields
- Add title tag für category
- Partial product update: product price and stock level
- Refactor all tests
- Add missing tests for global data
- Decide between different opencart versions from 2.0.0.0 to newest
- Add missing product attribute i18n controller
- Add top product flag in pull
- Add checks for sqlite and zipping extension in opencart modules

- Fix shipping method taken from language file
- Fix image mapping
- Fix order brutto to netto
- Change decimals which are floats
- Change endpoint id null checks to empty checks
- Fix attributes with missing language not respected

0.5.0
------
- Add delivery note support
- Add payment support e.g. Paypal Express
- Add support for Measurement Units
- Add "is_default" support for currency, language, customer group
- Fix multiple tax rates per tax class issue
- Fix HTML encoding of names and descriptions
- Refactor gerneric pulls in image, order item and payment
- Remove all constant expression to work with PHP version 5.4
- Delete obsolete options after push
- Fix currency update
- Fix measurement unit update
- Fix issue that global options with less values overwrites the one with more values
- Remove complicate image folder structure to reduce complexity
- Change language iso 2 letter to 3 letter
- Refactor product variation types
- Fix system independent directory separator issue
- Automatic password generation of connector

0.3.0
------
- Add top products support
- Add support for specifics
- Make variations global
- Use sku as article number instead of model
- Show requirements of the connector in the modules page
- Fix existing image pull issue
- Implement tax zone and tax zone country
- Implement file upload
- Implement product checksum
- Finish and integrate build process with phar
- Add currency pull support

0.2.0
------
- Update the payment status of an order
- Fix the deletion of images and articles before every sync
- Fix null reference of items without a language identification
- Fix hardcoded database credentials error
- type checks