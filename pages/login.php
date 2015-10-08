<?php
session_start();
if (isset($_SESSION['nombre'])) {
    header("location:index.php");
}
?>
<?php
require("../conection/fun_inicio.php");
$fun = new fun_inicio();
$msg = "";

if (isset($_POST['btnent'])) {
    $log = $_POST['txtusu'];
    $pas = md5($_POST['txtpas']);
    $msg = $fun->validarusuario($log,$pas);
}
if (isset($_GET['error'])) {
    $msg = "DEBE INICIAR SESION PARA ACCEDER";
}
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Acceso </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

        <!-- LanderApp's stylesheets -->
        <link href="../assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

        <!--[if lt IE 9]>
                <script src="assets/javascripts/ie.min.js"></script>
        <![endif]-->


        <!-- $DEMO =========================================================================================
        
                Remove this section on production
        -->
        <style>
            #signin-demo {
                position: fixed;
                right: 0;
                bottom: 0;
                z-index: 10000;
                //background: rgba(0,0,0,.6);
                padding: 6px;
                border-radius: 3px;
            }
            #signin-demo img { cursor: pointer; height: 40px; }
            #signin-demo img:hover { opacity: .5; }
            #signin-demo div {
                color: #fff;
                font-size: 10px;
                font-weight: 600;
                padding-bottom: 6px;
            }
        </style>
        <!-- / $DEMO -->

    </head>


    <!-- 1. $BODY ======================================================================================
            
            Body
    
            Classes:
            * 'theme-{THEME NAME}'
            * 'right-to-left'     - Sets text direction to right-to-left
    -->
    <body class="<?php echo $_SESSION['template'] ?> theme-dust page-signin">

        <script>
            var init = [];
        </script>

        <!-- Page background -->
<!--        <div id="page-signin-bg">
             Background overlay 
            <div class="overlay"></div>
             Replace this with your bg image 
            <img src="../assets/img/fondo.png" alt="">
        </div>-->
        <!-- / Page background -->

        <!-- Container -->
        <div class="signin-container">

            <!-- Left side -->
            <div class="signin-info">
                <a href="" class="logo">
                    Sofnet<span style="font-weight:100;">ERP</span>
                </a> <!-- / .logo -->
<!--                <div class="slogan">
                    Simple. Flexible. Powerful.
                </div>  / .slogan -->
                <ul>
                    <li><i class="fa fa-sitemap signin-icon"></i> contacto@sofnet.cl</li>
<!--                    <li><i class="fa fa-file-text-o signin-icon"></i> Well Commented Source</li>
                    <li><i class="fa fa-outdent signin-icon"></i> RTL direction support</li>
                    <li><i class="fa fa-heart signin-icon"></i> Crafted with love</li>-->
                </ul> <!-- / Info list -->
            </div>
            <!-- / Left side -->

            <!-- Right side -->
            <div class="signin-form">

                <!-- Form -->
                <form class="form-signin"  id="form1" name="form1" method="post" action="login.php">

                    <div class="signin-text">
                        <span>Acceder</span>
                    </div> <!-- / .signin-text -->

                    <div class="form-group w-icon">
                        <input type="text" name="txtusu" id="txtusu" class="form-control input-lg" placeholder="Usuario">
                        <span class="fa fa-user signin-form-icon"></span>
                    </div> <!-- / Username -->

                    <div class="form-group w-icon">
                        <input type="password" name="txtpas" id="txtpas" class="form-control input-lg" placeholder="Clave">
                        <span class="fa fa-lock signin-form-icon"></span>
                    </div> <!-- / Password -->

                    <div class="form-actions">
                        <input type="submit" name="btnent" value="Ingresar" id="btnent" class="signin-btn bg-primary btn-block">
<!--                        <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a>-->
                    </div> <!-- / .form-actions -->
                </form>
               
            </div>
            <!-- Right side -->
        </div>
        <!-- / Container -->
<!--
        <div class="not-a-member">
            Not a member? <a href="pages-signup.html">Sign up now</a>
        </div>-->

        <!-- Get jQuery from Google CDN -->
        <!--[if !IE]> -->
        <script type="text/javascript"> window.jQuery || document.write('<script src="../assets/javascripts/jquery.min.js">' + "<" + "/script>");</script>
        <!-- <![endif]-->
        <!--[if lte IE 9]>
                <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
        <![endif]-->


        <!-- LanderApp's javascripts -->
        <script src="../assets/javascripts/bootstrap.min.js"></script>
        <script src="../assets/javascripts/landerapp.min.js"></script>

        <script type="text/javascript">
            // Resize BG
            init.push(function () {
                var $ph = $('#page-signin-bg'),
                        $img = $ph.find('> img');

                $(window).on('resize', function () {
                    $img.attr('style', '');
                    if ($img.height() < $ph.height()) {
                        $img.css({
                            height: '100%',
                            width: 'auto'
                        });
                    }
                });
            });

            // Show/Hide password reset form on click
            init.push(function () {
                $('#forgot-password-link').click(function () {
                    $('#password-reset-form').fadeIn(400);
                    return false;
                });
                $('#password-reset-form .close').click(function () {
                    $('#password-reset-form').fadeOut(400);
                    return false;
                });
            });

            // Setup Sign In form validation
            init.push(function () {
                $("#signin-form_id").validate({focusInvalid: true, errorPlacement: function () {
                    }});

                // Validate username
                $("#username_id").rules("add", {
                    required: true,
                    minlength: 3
                });

                // Validate password
                $("#password_id").rules("add", {
                    required: true,
                    minlength: 6
                });
            });

            // Setup Password Reset form validation
            init.push(function () {
                $("#password-reset-form_id").validate({focusInvalid: true, errorPlacement: function () {
                    }});

                // Validate email
                $("#p_email_id").rules("add", {
                    required: true,
                    email: true
                });
            });

            window.LanderApp.start(init);
        </script>

    </body>
</html>
