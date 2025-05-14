<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Perubahan Kata Sandi</title>
    <link rel="icon" href="<?= base_url('template/assets/img/hipmi/logo1.png') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
        }

        .header img {
            max-width: 100px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 24px;
            color: #333333;
        }

        .content p {
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #999999;
            border-top: 1px solid #dddddd;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- <div class="header">
            <img src="<?= $img_url ?>" alt="Logo">
        </div> -->
        <div class="content">
            <h1>Password Change Confirmation</h1>
            <p>Hello,</p>
            <p>We have received a request to change the password for your account. If you made this request, please confirm the password change by clicking the button below:</p>
            <a href="<?= $reset_link ?>" class="button">Change Password</a>
            <p>If you did not request this password change, please ignore this email. Your current password will remain unchanged until you confirm this request.</p>
            <p>Please note that this password change link is only valid for 24 hours.</p>
            <p>Thank you,<br>The <?= $company_name ?> Support Team</p>

        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> <?= $company_name ?>. All rights reserved.</p>
        </div>
    </div>
</body>

</html>