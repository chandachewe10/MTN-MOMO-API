# MTN MOMO API FOR COLLECTING PAYMENTS FROM CUSTOMERS - cURL PHP
Mtn Money Developer API using cURL in PHP For Collections.

Documentation and official resources can be found at MTN Developer Portal sandbox: https://momodeveloper.mtn.com/

## Prerequisites
1. You have Signed Up at: https://momodeveloper.mtn.com/signin?ReturnUrl=%2F

2. You have registered for the collections product on sandbox :https://momodeveloper.mtn.com/products

3. You possess the two primary keys for the collection widget*


## Getting Started
1. After cloning or downloading this repo, open the index.php file using your text editor.

2. Open the index.php, navigate to `subscriptionKey` and put one of your subscription keys there. On your sandbox you are given two subscription keys to use, only choose one to put here.

3. You can make further changes to `providerCallbackHost` and `X-Callback-Url` as you wish, This is where they will send any response provided a certain request and/or transaction has been succcessfull.

4. You can now open your localhost (using xampp/wampp) and run the index.php file using localhost in your browser. For testing purposes in sandbox do not change the currency from EUR and always avoid starting with zero for testing numbers
5. This repository is not affliated with MTN.