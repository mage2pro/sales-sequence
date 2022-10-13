The «[**Sales Documents Numeration**](https://mage2.pro/c/extensions/sales-documents-numeration)» module for Magento 2 allows you to use a custom numeration for the sales documents: orders, invoices, shipments, and credit memos.  
The module is **free** and **open source**.

**Demo video**: https://www.youtube.com/watch?v=alcoJyoby1M

## Screenshots
### 1. Custom order number
![](https://mage2.pro/uploads/default/original/1X/f891d6a5c0255658fab21312ba176db1aabcd7da.png)

![](https://mage2.pro/uploads/default/original/1X/7c382a130198d321401a083e432e59b279bcdcb9.png)

### 2. Custom invoice number
![](https://mage2.pro/uploads/default/original/1X/210dd343c4d53b735b5b10e0852115c52edc004d.png)

### 3. Custom shipment number
![](https://mage2.pro/uploads/default/original/1X/39516735d7f50eb016da67a43a3834fd0b620910.png)

### 4. Custom credit memo number
![](https://mage2.pro/uploads/default/original/1X/0c8ae7bb607e4aa962c77a4e074938ed74368edc.png)

### 5. Extension settings
![](https://mage2.pro/uploads/default/original/1X/2510f608780d4fb4f7c05f18c245f2ec695294b4.png)

## How to install
[Hire me in Upwork](https://www.upwork.com/fl/mage2pro), and I will: 
- install and configure the module properly on your website
- answer your questions
- solve compatiblity problems with third-party checkout, shipping, marketing modules
- implement new features you need 

### 2. Self-installation
```
bin/magento maintenance:enable
rm -f composer.lock
composer clear-cache
composer require mage2pro/sales-sequence:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f en_US <additional locales>
bin/magento maintenance:disable
```

## How to update
```
bin/magento maintenance:enable
composer remove mage2pro/sales-sequence
rm -f composer.lock
composer clear-cache
composer require mage2pro/sales-sequence:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f en_US <additional locales>
bin/magento maintenance:disable
```