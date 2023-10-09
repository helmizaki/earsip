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
    <title>Halaman Login </title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url()?>assets/plugins/dashboard/images/icon.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
    body {
        background-image: url('<?php echo base_url()?>assets/dist/img/background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        padding-top: 40px;
    }

    .form-signin {
        max-width: 430px;
        min-height: 330px;
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
    <style>
    a:link {
        text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    a:active {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    input,
    button,
    select,
    textarea {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        text-align: inherit;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-signin">
            <h2 class="form-signin-heading">Halaman Login <br /> E-ARSIP</h2>
            <?php
		$attributes = array('name' => 'login', 'id' => 'login_frm');
		echo form_open('login/validation_credential',$attributes);
		echo "<table align=center border=0 cellpadding=10><tr align=center>";
			echo "<td rowspan=2>
			<img src='".base_url()."assets/plugins/dashboard/images/profile/pic1.png' alt='Mahkamah Agung'/ height='100px'>
			</td><td valign='bottom' style='padding-bottom: 10px;'>";
			$attributes = array('tabindex' => '1','class' => 'login', 'placeholder' => 'Username', 'name' => 'username','autofocus'   => 'autofocus', 'required'   => '');
			echo form_input($attributes);
			echo "</td>
			<td rowspan=2 style='padding-left: 10px;'>";
			$attributes = array('tabindex' => '3','class' => 'btn btn-primary', 'value' => 'Login');
			echo form_submit($attributes);
			echo "</td>";
		echo "</tr> <tr align=center>";
			echo "<td  valign='top'>";
			$attributes = array('tabindex' => '2','class' => 'login', 'placeholder' => 'Password', 'name' => 'password','required'   => '');
			echo form_password($attributes);
			echo "</td>";
		echo "</tr><tr>
		<td colspan=3 align=center> ";
						if($this->input->get('login')=='gagal'){
						echo 'LOGIN GAGAL<br>Gunakan username dan password Aplikasi SIPP.';
						} 						
		echo "</td>
		</tr>
		</table>";?>
        </div>
    </div>
    <div style="position: fixed; bottom: 3px; right: 10px; font-size: 10px; color: green" align="center">
        Copyright &copy; 2023<br><a href="http://pa-majene.go.id" style="color: green;" target="_blank">Tim IT
            PA-NGAWI</a>
    </div>

</body>

</html>