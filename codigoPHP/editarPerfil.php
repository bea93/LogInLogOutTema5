<?php
/**
  @author Bea Merino
  @since 14/04/2021
  @description: Editar Perfil
 */

//Recupera la sesión del Login
session_start();

//Fichero de configuración de la BBDD
require_once '../config/confDB.php';
//Importamos la libreria de validacion
require_once '../core/210322ValidacionFormularios.php';

$entradaOK = true;

//Si no hay una sesión iniciada te manda al Login
if (!isset($_SESSION['usuarioDAW213DBAppLoginLogout'])) {
    header("Location: login.php");
}

//Si pulsas cancelar te devuelve a la ventana de programa
if (isset($_POST["cancelar"])) {
    header('Location: programa.php');
    exit;
}
//Array para almacenar los errores del formulario
$aErrores = [
    'desc' => null
];

try {
    // Datos de la conexión a la base de datos
    $miBD = new PDO(HOST, USER, PASS);
    $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Mostramos todos los datos del usuario logueado
    $resultado = $miBD->query("SELECT * FROM T01_Usuario WHERE T01_CodUsuario = '" . $_SESSION['usuarioDAW213DBAppLoginLogout'] . "';");

    $aObjeto = $resultado->fetchObject();
    $datos = [
        'codigo' => $aObjeto->T01_CodUsuario,
        'descripcion' => $aObjeto->T01_DescUsuario,
        'tipo' => $aObjeto->T01_Perfil,
        'ultConex' => $aObjeto->T01_FechaHoraUltimaConexion,
        'conexiones' => $aObjeto->T01_NumConexiones
    ];
    //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
} catch (PDOException $mensajeError) {
    echo "<h3>Mensaje de ERROR</h3>";
    echo "Error: " . $mensajeError->getMessage() . "<br>";
    echo "Código de error: " . $mensajeError->getCode();
}
//Si se ha pulsado enviar
if (isset($_POST['enviar'])) {
    //La posición del array de errores recibe el mensaje de error si hubiera
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfabetico($_POST['descripcion'], 250, 1, 1);
    //Recorre el array en busca de mensajes de error
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            //Cambia la condición de la variable
            $entradaOK = false;
        }
    }
} else {
    //Cambia el valor de la variable porque no se ha pulsado el botón 
    $entradaOK = false;
}

if ($entradaOK) {
    //Actualiza el usuario con la nueva descripción
    $sentenciaSQL = "UPDATE T01_Usuario SET T01_DescUsuario = :descripcion WHERE T01_CodUsuario = :codigo;";
    $resultadoSQL = $miBD->prepare($sentenciaSQL);
    $resultadoSQL->execute(array(':codigo' => $_SESSION['usuarioDAW213DBAppLoginLogout'], ':descripcion' => $_POST['descripcion']));
    $_SESSION['descUser213'] = $_POST['descripcion'];
    //Una vez ejecutada la sentencia se redirige a programa.php
    header("Location: programa.php");
} else {
    ?>
    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!-->
    <html class="no-js">
        <!--<![endif]-->
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Bea Merino</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Free HTML5 Website Template by FreeHTML5.co" />
            <meta name="keywords"
                  content="free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
            <meta name="author" content="FreeHTML5.co" />

            <!-- 
                //////////////////////////////////////////////////////
        
                FREE HTML5 TEMPLATE 
                DESIGNED & DEVELOPED by FreeHTML5.co
                        
                Website: 		http://freehtml5.co/
                Email: 			info@freehtml5.co
                Twitter: 		http://twitter.com/fh5co
                Facebook: 		https://www.facebook.com/fh5co
        
                //////////////////////////////////////////////////////
            -->

            <!-- Facebook and Twitter integration -->
            <meta property="og:title" content="" />
            <meta property="og:image" content="" />
            <meta property="og:url" content="" />
            <meta property="og:site_name" content="" />
            <meta property="og:description" content="" />
            <meta name="twitter:title" content="" />
            <meta name="twitter:image" content="" />
            <meta name="twitter:url" content="" />
            <meta name="twitter:card" content="" />

            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
            <link rel="shortcut icon" href="webroot/images/favicon.png">

            <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic,700' rel='stylesheet'
                  type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

            <!-- Animate.css -->
            <link rel="stylesheet" href="../webroot/css/animate.css">
            <!-- Icomoon Icon Fonts-->
            <link rel="stylesheet" href="../webroot/css/icomoon.css">
            <!-- Bootstrap  -->
            <link rel="stylesheet" href="../webroot/css/bootstrap.css">
            <!-- Owl Carousel -->
            <link rel="stylesheet" href="../webroot/css/owl.carousel.min.css">
            <link rel="stylesheet" href="../webroot/css/owl.theme.default.min.css">
            <!-- Theme style  -->
            <link rel="stylesheet" href="../webroot/css/style.css">

            <!-- Modernizr JS -->
            <script src="../webroot/js/modernizr-2.6.2.min.js"></script>
            <!-- FOR IE9 below -->
            <!--[if lt IE 9]>
                <script src="webroot/js/respond.min.js"></script>
                <![endif]-->

        </head>
        <body>
            <div id="fh5co-page">
                <aside id="fh5co-aside" role="complementary" class="border js-fullheight">
                    <h1 id="fh5co-logo"><a href="../../proyectoDWES/indexProyectoDWES.html"><img src="../webroot/images/logo.png"
                                                                        alt="Free HTML5 Bootstrap Website Template"></a></h1>
                    <nav id="fh5co-main-menu" role="navigation">
                        <ul>
                            <li class="fh5co-active" style="color: #1512da">Log in Log out Tema 5</li>
                            <li><a href="https://github.com/bea93/LogInLogOutTema5/tree/Developer" target="_blank">GitHub</a></li>
                        </ul>
                    </nav>
                    <div class="fh5co-footer">
                        <p style="font-size: 1.5em"><a style="text-decoration: none; color: black" href="https://github.com/bea93/LogInLogOutTema5/tree/Developer" target="_blank">GitHub</a></p>
                        <p><a href="../../index.html" style=" text-decoration: none; color: black">&copy; 2021 Beatriz Merino Macía.</a></p>
                    </div>
                </aside>
                <div id="fh5co-main">
                    <div class="fh5co-narrow-content">
                        <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft"></h2>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <fieldset>
                                <div class="obligatorio">
                                    <strong>Nombre del Usuario:</strong>
                                    <input type="text" id="nombre" style="border: 1px solid black" name="nombre" 
                                           value="<?php echo $datos['codigo']; ?>" disabled><br><br> 
                                </div>
                                <div class="obligatorio">
                                    <strong>Descripción del Usuario:</strong>
                                    <input type="text" id="descripcion" style="border: 1px solid black" name="descripcion" 
                                           value="<?php echo $datos['descripcion']; ?>"><br> <br>   
                                </div>
                                <div class="obligatorio">
                                    <strong>Tipo de Usuario:</strong>
                                    <input type="text" id="tipo" style="border: 1px solid black" name="tipo" 
                                           value="<?php echo $datos['tipo']; ?>" disabled><br>   <br> 
                                </div>
                                <div class="obligatorio">
                                    <strong>Número de conexiones:</strong>
                                    <input type="text" id="conexiones" style="border: 1px solid black" name="conexiones" 
                                           value="<?php echo $datos['conexiones']; ?>" disabled><br>  <br>  
                                </div>
                                <div class="obligatorio">
                                    <strong>Última conexión:</strong>
                                    <input type="text" id="ultConex" style="border: 1px solid black" name="ultConex" 
                                           value="<?php echo date('d/m/Y - H:i:s', $datos['ultConex']) ?>" disabled><br>  <br>  
                                </div>
                                <div class="obligatorio">
                                    <input type="submit" name="enviar" value="ACEPTAR">
                                    <input type="submit" name="cancelar" value="CANCELAR">
                                </div>
                            </fieldset>
                        </form>
                    <?php } ?>

                </div> 
            </div> 
            <!-- jQuery -->
            <script src="../webroot/js/jquery.min.js"></script>
            <!-- jQuery Easing -->
            <script src="../webroot/js/jquery.easing.1.3.js"></script>
            <!-- Bootstrap -->
            <script src="../webroot/js/bootstrap.min.js"></script>
            <!-- Carousel -->
            <script src="../webroot/js/owl.carousel.min.js"></script>
            <!-- Stellar -->
            <script src="../webroot/js/jquery.stellar.min.js"></script>
            <!-- Waypoints -->
            <script src="../webroot/js/jquery.waypoints.min.js"></script>
            <!-- Counters -->
            <script src="../webroot/js/jquery.countTo.js"></script>
            <!-- MAIN JS -->
            <script src="../webroot/js/main.js"></script>
    </body>
</html>
