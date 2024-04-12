<?php

// API endpoint
$url = 'https://ttc.com.ge/api/passengers';

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

// Execute cURL session
$response = curl_exec($ch);

// Check for errors
if ($response === FALSE) {
    // Handle cURL error
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode JSON response
    $data = json_decode($response, TRUE);

    // Check if decoding was successful
    if ($data === NULL) {
        echo 'Error decoding JSON: ' . json_last_error_msg();
    } else {
        // Sort data by count in descending order
        arsort($data['transactionsByTransportTypes']);

        // Output the data in HTML table with CSS styles
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>მგზავრთა რაოდენობა <?php echo date("d.m.Y"); ?></title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                }

                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #f4f4f4;
                }

                .card {
                    background-color: #fff;
                    border-radius: 12px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                    margin-bottom: 20px;
                }

                h2 {
                    margin-bottom: 20px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 10px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                tr:nth-child(odd) {
                    background-color: #f2f2f2;
                }
            </style>
        </head>

        <body>
            <div class="card">
                <h2>მგზავრთა რაოდენობა <?php echo date("d.m.Y"); ?></h2>
                <table>
                    <?php foreach ($data['transactionsByTransportTypes'] as $transportType => $passengerCount) {
                        if ($passengerCount > 0) { ?>
                            <tr>
                                <td><?php echo $transportType; ?></td>
                                <td><?php echo $passengerCount; ?></td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
        </body>

        </html>
        <?php
    }
}

// Close cURL session
curl_close($ch);

?>