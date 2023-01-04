## MTN MOMO API FOR COLLECTING PAYMENTS FROM CUSTOMERS - cURL PHP
Mtn Money Developer API using cURL in PHP For Collections.

Documentation and official resources can be found at MTN Developer Portal sandbox: https://momodeveloper.mtn.com/

## Prerequisites
1. You have Signed Up at: https://momodeveloper.mtn.com/signin?ReturnUrl=%2F

2. You have registered for the collections product and disbursement product on the sandbox :https://momodeveloper.mtn.com/products

3. You possess the two subscription keys for collections product and two subscription keys for disbursements product


## Getting Started
1. After cloning or downloading this repo, open the `collections.php` file using your text editor.

2. Do the same for `disbursements.php` file.

3. Navigate to `subscriptionKey` and put one of your subscription keys there. On your sandbox you are given two subscription keys to use, only choose one to put here. One of the subscriptions key
for collections products should go in `collections.php` and one of the subscriptions keys for disbursements product should go in `disbursements.php` file. 

4. You can make further changes to `providerCallbackHost` and `X-Callback-Url` as you wish, This is where they will send any response provided a certain request and/or transaction has been succcessfull.

5. You can now open your localhost (using xampp/wampp) and run the `collections.php` file for collections testing or `disbursements.php` file for disbursements testing using localhost in your browser. For testing purposes in sandbox do not change the currency from `EUR` and always 
use testing numbers as provided in the sandbox on use cases.

6. This repository is not affliated with MTN.
