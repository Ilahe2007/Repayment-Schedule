Free of Charge Credit – Repayment Schedule

A small PHP web app that builds the monthly repayment schedule for a 0% interest loan. You enter the purchase amount, the initial deposit and the number of monthly payments, and the app shows every payment date, the monthly amount and the remaining balance in an HTML table.

Practical work for Back-End Web Programming 2 (CS-024) at UFAZ.

Live demo: https://ilaha.alwaysdata.net/Back-end/index.html

Repayment schedule screenshot

Features
Web form for the amount, the initial deposit and the number of monthly payments, pre-filled with test values (8699.95 / 1249.90 / 15)
Balance and monthly payment calculated in PHP from the $_POST data
Payment dates generated with a for loop and strtotime()
The last payment absorbs any rounding difference, so the balance always ends at exactly 0.00
Summary cards, a progress bar for each month and a totals row
Input validation: the deposit must be lower than the amount, and there must be at least one month
Responsive layout
How it works
balance         = amount - deposit
monthly payment = balance / number of months

The PHP script loops from 1 to the number of months. For each month it:

computes the payment date with strtotime("+$i month", $today)
subtracts the monthly payment from the remaining balance
writes one <tr> row of the HTML table

Example: amount = 4000, deposit = 1000, 3 months → balance = 3000, so 3 payments of 1000.

Project structure
File	Role
index.html	Web form to enter the initial values
schedule.php	Reads $_POST, does the calculation and generates the schedule table
style.css	Styling for both pages
Run it locally

You need PHP 7.4 or later.

bash
git clone <repository-url>
cd <repository-folder>
php -S localhost:8000

Then open http://localhost:8000/index.html.

You can also copy the files into the web folder of XAMPP, WAMP or MAMP (htdocs or www) and open them through localhost.

Technologies

PHP · HTML5 · CSS3
