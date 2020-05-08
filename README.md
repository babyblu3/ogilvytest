# Ogilvy Software developer technical exercise

To assist Ogilvy in their selection process for the Technical Lead (Drupal) role candidates is invited to complete a practical technical exercise.

## Story

As a bank customer, I want a web page to output a name and monetary value in cheque format.

## Functional description

We need a web page that will allow users to enter the payee name and monetary value in dollars and cents and covert that to cheque format.

## Technical documentation

The cheque conversion format algrorithm was developed in **PHP**: 
* The numeric value cheque conversion was simply done using the PHP built-in money_format function
http://php.net/manual/en/function.money-format.php
* The grammer english (word) conversion functionality as an Object by a custom class named 'NumbersToWords'
* The logic of the algorthm is based on being the fact that currency format uses comma to separate the number into thousands (3 digits long each). Each comma in the number is represented as 2 additional levels, the left and right side of the comma. The translation is done from left to right (i.e. the most significant biggest number to the smallest). Furthermore the theory of the logic is based on knowing the name of the place where each digit is place:
http://mathforum.org/library/drmath/view/57113.html
* For completeness on cheque format the amount in grammically correct english, it finishes with 'only', no dollar or cent amount displayed if zero amount
* The result of the number conversion done by PHP is returned back as a JSON format

There are some alternative ways to writing numbers into words as referenced below, but i followed the example in your brief:
https://www.thebalance.com/write-numbers-using-words-4083198

The **Bootscrap 4 / JQuery / HTML5** based validation was triggered manually in order to process the fetch a **JSON** requests and return the results on the same page without refreshing
https://stackoverflow.com/questions/18634106/manually-trigger-html5-validation-on-button-click
* Payee name allows letters, spaces, and additional characters such as hyphen (-) and single quote (') only as its common in people names any other symbols are excluded
* Form validation is triggered manually in order to call an AJAX Javascript HTTP POST request to the PHP file (process.php) to do the currency format conversion

During my local development / testing i used **Docker** container, by creating a localised centos image with PHP for my local development environment. Once the project files has been downloaded and assumed docker is already installed, simply run the following command in the root directory of the project folder to have the environment up and running:
```
$ docker-compose up
```

The **wwwroot folder** or web root folder is located in **htdocs** folder in the project folder

## References

* Regular Expressions Cheatsheet
https://gist.github.com/vitorbritto/9ff58ef998100b8f19a0
* Number-to-Word Conversion with PHP
https://pageconfig.com/post/number-to-word-conversion-with-php
* How can I implode an array while skipping empty array items?
https://stackoverflow.com/questions/5985401/how-can-i-implode-an-array-while-skipping-empty-array-items
* AJAX - Send a Request To a Server
https://www.w3schools.com/js/js_ajax_http_send.asp
* HTML DOM removeChild() Method
https://www.w3schools.com/jsref/met_node_removechild.asp
* Send POST data using XMLHttpRequest
https://stackoverflow.com/questions/9713058/send-post-data-using-xmlhttprequest
* Manually trigger html5 validation on button click
https://stackoverflow.com/questions/18634106/manually-trigger-html5-validation-on-button-click
* How to send a JSON object using html form data [closed]
https://stackoverflow.com/questions/22195065/how-to-send-a-json-object-using-html-form-data
* AJAX PHP Example
https://www.w3schools.com/js/js_ajax_php.asp

