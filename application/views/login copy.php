<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="admin, dashboard">
<meta name="author" content="DexignZone">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Dompet : Payment Admin Template">
<meta property="og:title" content="Dompet : Payment Admin Template">
<meta property="og:description" content="Dompet : Payment Admin Template">
<meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
<meta name="format-detection" content="telephone=no">
<html>

<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
    body {
        background-image: url('<?php echo base_url()?>assets/dist/img/background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        padding-top: 40px;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 5px;
    }

    .form-signin .form-signin-heading {
        margin-bottom: 20px;
        text-align: center;
    }

    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        margin-bottom: 10px;
    }

    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        border-radius: 3px;
    }

    .form-signin button[type="submit"] {
        border-radius: 3px;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-signin">
            <h2 class="form-signin-heading">Halaman Login</h2>
            <?php
        // Tampilkan pesan error jika ada
        if ($this->session->flashdata('error_msg')) {
            echo '<div class="alert alert-danger">' . $this->session->flashdata('error_msg') . '</div>';
        }
        if ($this->session->flashdata('success_msg')) {
            echo '<div class="alert alert-success">' . $this->session->flashdata('success_msg') . '</div>';
        }
        ?>

            <?php echo form_open('login/process_login'); ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            <?php echo form_close(); ?>
        </div>
    </div>

</body>

</html>