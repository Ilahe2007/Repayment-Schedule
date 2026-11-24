<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repayment schedule</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="banner">
        <span class="badge">0% interest</span>
        <h1>Repayment schedule</h1>
        <p>Your free of charge credit, month by month.</p>
    </header>

    <main class="card wide">
<?php


$amount  = isset($_POST['amount'])  ? (float) $_POST['amount']  : 0;
$deposit = isset($_POST['deposit']) ? (float) $_POST['deposit'] : 0;
$months  = isset($_POST['months'])  ? (int) $_POST['months']    : 0;

// Basic checks on the entered values
$errors = [];
if ($amount <= 0) {
    $errors[] = "The amount must be greater than 0.";
}
if ($deposit < 0 || $deposit >= $amount) {
    $errors[] = "The deposit must be positive and smaller than the amount.";
}
if ($months < 1) {
    $errors[] = "The number of monthly payments must be at least 1.";
}

if (count($errors) > 0) {
    echo "<h2>Invalid data</h2>";
    echo "<ul class=\"errors\">";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
} else {
    // Calculated values
    $balance = $amount - $deposit;                  // amount to be reimbursed
    $monthlyPayment = round($balance / $months, 2); // monthly payment, rounded to cents
    $today = time();                                // timestamp of the day of purchase
    $lastDate = strtotime("+$months month", $today);
?>
        <section class="stats">
            <div class="stat">
                <span class="label">Amount</span>
                <span class="value"><?php echo number_format($amount, 2); ?></span>
            </div>
            <div class="stat">
                <span class="label">Initial deposit</span>
                <span class="value"><?php echo number_format($deposit, 2); ?></span>
            </div>
            <div class="stat">
                <span class="label">Balance to reimburse</span>
                <span class="value"><?php echo number_format($balance, 2); ?></span>
            </div>
            <div class="stat highlight">
                <span class="label"><?php echo $months; ?> monthly payments of</span>
                <span class="value"><?php echo number_format($monthlyPayment, 2); ?></span>
            </div>
        </section>

        <p class="period">
            From <strong><?php echo date("d/m/Y", $today); ?></strong>
            to <strong><?php echo date("d/m/Y", $lastDate); ?></strong>
        </p>

        <table class="schedule">
            <thead>
                <tr>
                    <th>No:</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Remaining balance</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
<?php

    // Row 0: the initial deposit, paid on the day of purchase
    echo "<tr class=\"deposit\">";
    echo "<td>0</td>";
    echo "<td>" . date("d/m/Y", $today) . "</td>";
    echo "<td>" . number_format($deposit, 2) . " <span class=\"tag\">deposit</span></td>";
    echo "<td>" . number_format($balance, 2) . "</td>";
    echo "<td><div class=\"bar\"><span style=\"width: 0%\"></span></div><span class=\"percent\">0%</span></td>";
    echo "</tr>";

    // One row per monthly payment
    $remaining = $balance;
    for ($i = 1; $i <= $months; $i++) {
        $date = strtotime("+$i month", $today);

        if ($i == $months) {
            $payment = round($remaining, 2);
        } else {
            $payment = $monthlyPayment;
        }
        $remaining = round($remaining - $payment, 2);

        // Share of the balance already reimbursed
        $percent = round(($balance - $remaining) / $balance * 100);

        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>" . date("d/m/Y", $date) . "</td>";
        echo "<td>" . number_format($payment, 2) . "</td>";
        echo "<td>" . number_format($remaining, 2) . "</td>";
        echo "<td><div class=\"bar\"><span style=\"width: $percent%\"></span></div><span class=\"percent\">$percent%</span></td>";
        echo "</tr>";
    }
?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total paid</td>
                    <td><?php echo number_format($amount, 2); ?></td>
                    <td colspan="2">Interest: 0.00</td>
                </tr>
            </tfoot>
        </table>
<?php
}
?>
        <a class="back" href="index.html">&larr; New calculation</a>
    </main>

    <footer>Back-End Web Programming &middot; UFAZ</footer>
</body>
</html>
