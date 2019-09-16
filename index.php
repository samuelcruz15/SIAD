<?php
#Arquivo de configuração, banco, constantes
require 'application/config.php';
#Tratamento de rotas
require "application/routes.php";
#Tratamento de url
require "application/url.php";
#Controller geral
require_once 'model/Banco.php';
#Controller geral
require_once 'controller/controller.php';
#Instancia model do modulo
//require_once 'model/M'.$modulo.'.php';
#Instancia controller referente ao modulo
require 'controller/' . $modulo . '.php';

/*
 * Valida login
 */
@$registro = $_SESSION['registro'];
@$limite = $_SESSION['limite'];
if ($registro) {// verifica se a session  registro esta ativa
    @$segundos = time() - @$registro;
}
// fim da verificação da session registro

/* verifica o tempo de inatividade
  se ele tiver ficado mais de 1800 segundos sem atividade ele destroi a session
  se não ele renova o tempo e ai é contado mais 1800 segundos */
if (@$segundos > @$limite) {
    session_destroy();
    $ultima_entrada = $_SESSION['ultimo_acesso'];
    die($oController->js_junto("Sua seção expirou 30 minutos, Faça o login novamente.                                Último acesso: $ultima_entrada", RAIZ . 'login/inicio'));
}

if (($modulo != 'login' and $pagina != 'inicio') AND ( $modulo != 'erro' and $pagina != 'inicio') AND ( $modulo != 'erro' and $pagina != 'acessoNegado') AND ( $modulo != 'inicio' and $pagina != 'manual') AND ( $modulo != 'inicio' and $pagina != 'home') AND ( $modulo != 'login' and $pagina != 'manutencao')) {
    $retornoValidaView = $oController->validaLogin($modulo, $pagina);
    if ($retornoValidaView == false) {
        echo "<script>location.href='" . RAIZ . "erro/acessoNegado'; </script>";
        exit;
    }
}
?>

<!-- VALIDAÇÃO DE LOGIN -->
<?php if (@$_SESSION['VALID'] and ( $modulo != 'login' )) { ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html lang="br">
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

            <title> Siad </title>
            <meta name="description" content="Descrição do Sistema"/>
            <meta name="author" content="Coordenação de Sistemas - STI"/>

            <!-- BEGIN GLOBAL MANDATORY STYLES -->
            <link href="<?php echo CSS; ?>global-mandatory/font-awesome.css" rel="stylesheet" type="text/css" />            <!-- Icones -->
            <link href="<?php echo CSS; ?>global-mandatory/simple-line-icons.css" rel="stylesheet" type="text/css" />       <!-- Icones -->
            <link href="<?php echo CSS; ?>global-mandatory/bootstrap.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo CSS; ?>global-mandatory/bootstrap-switch.css" rel="stylesheet" type="text/css" />
            <!-- END GLOBAL MANDATORY STYLES -->

            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <link href="<?php echo CSS; ?>page-level-plugins/datatables.min.css" rel="stylesheet" type="text/css" />        <!-- Tabelas -->
            <link href="<?php echo CSS; ?>page-level-plugins/datatables.bootstrap.css" rel="stylesheet" type="text/css" />  <!-- Tabelas -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-select.css" rel="stylesheet" type="text/css" />      <!-- Formulário - Select com campo de pesquisa -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" /><!-- Data Picker -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" /><!-- Data Picker -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css" /><!-- Data Picker -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" /><!-- Data Picker -->
            <link href="<?php echo CSS; ?>page-level-plugins/bootstrap-daterangepicker/clockface.css" rel="stylesheet" type="text/css" /><!-- Data Picker -->
            <!-- END PAGE LEVEL PLUGINS -->

            <!-- BEGIN THEME GLOBAL STYLES -->
            <link href="<?php echo CSS; ?>theme-global/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" />    <!-- components.css: Border-radius: 0px  -->
            <link href="<?php echo CSS; ?>theme-global/plugins.css" rel="stylesheet" type="text/css" />
            <!-- END THEME GLOBAL STYLES -->

            <!-- BEGIN PAGE LEVEL STYLES -->
            <link href="<?php echo CSS; ?>page-level-styles/error.css" rel="stylesheet" type="text/css" />                  <!-- Página de Erro -->
            <!-- END PAGE LEVEL STYLES -->

            <!-- BEGIN THEME LAYOUT STYLES -->
            <link href="<?php echo CSS; ?>theme-layout/layout.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo CSS; ?>theme-layout/grey.css" rel="stylesheet" type="text/css" id="style_color" />       <!-- Cores do template: blue.css, light.css, grey.css, dark.css  -->
            <link href="<?php echo CSS; ?>theme-layout/customizar.css" rel="stylesheet" type="text/css" />
            <!-- END THEME LAYOUT STYLES -->

            <link rel="shortcut icon" href="<?php echo CSS; ?>img/favicon.ico" />




            <!-- BEGIN CORE PLUGINS -->
            <script src="<?php echo JS; ?>core-plugins/jquery.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>core-plugins/bootstrap.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>core-plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>core-plugins/jquery.slimscroll.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>core-plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>core-plugins/bootstrap-switch.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->

            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="<?php echo JS; ?>page-level-plugins/jquery.validate.js" type="text/javascript"></script>               <!-- Pag. login | Jquery - [Editar, Pesquisar Estagiário...] -->
            <script src="<?php echo JS; ?>page-level-plugins/datatable.js" type="text/javascript"></script>                     <!-- Tabelas -->
            <script src="<?php echo JS; ?>page-level-plugins/datatables.js" type="text/javascript"></script>                    <!-- Tabelas -->
            <script src="<?php echo JS; ?>page-level-plugins/datatables.bootstrap.js" type="text/javascript"></script>          <!-- Tabelas -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-confirmation.js" type="text/javascript"></script>        <!-- Botão de Confirmação -->
            <script src="<?php echo JS; ?>page-level-plugins/jquery.pulsate.js" type="text/javascript"></script>                <!-- Pulsante -->
            <!-- OBS: Pulsante-> Em cada página que queira chamar deve colocar o código ( UIGeneral.init(); ) dentro do ( $(document).ready(function () ) -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-select.js" type="text/javascript"></script>              <!-- Formulário - Select com campo de pesquisa -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script><!-- Data Picker -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-datepicker.js" type="text/javascript"></script><!-- Data Picker -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-timepicker.js" type="text/javascript"></script><!-- Data Picker -->
            <script src="<?php echo JS; ?>page-level-plugins/bootstrap-daterangepicker/bootstrap-datetimepicker.js" type="text/javascript"></script><!-- Data Picker -->
            <!-- END PAGE LEVEL PLUGINS -->

            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="<?php echo JS; ?>theme-global/app.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->

            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="<?php echo JS; ?>page-level-scripts/table-datatables-responsive.js" type="text/javascript"></script>   <!-- Tabelas -->
            <script src="<?php echo JS; ?>page-level-scripts/ui-confirmations.js" type="text/javascript"></script>              <!-- Botão de Confirmação -->
            <script src="<?php echo JS; ?>page-level-scripts/ui-general.js" type="text/javascript"></script>                    <!-- Pulsante -->
            <!-- OBS: Pulsante-> Em cada página que queira chamar deve colocar o código ( UIGeneral.init(); ) dentro do ( $(document).ready(function () ) -->
            <script src="<?php echo JS; ?>page-level-scripts/components-bootstrap-select.js" type="text/javascript"></script>   <!-- Formulário - Select com campo de pesquisa -->
            <script src="<?php echo JS; ?>page-level-scripts/components-date-time-pickers.js" type="text/javascript"></script>  <!-- Data Picker -->
            <!-- END PAGE LEVEL SCRIPTS -->

            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="<?php echo JS; ?>theme-layout/layout.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>theme-layout/demo.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>theme-layout/quick-sidebar.js" type="text/javascript"></script>
            <script src="<?php echo JS; ?>theme-layout/quick-nav.js" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->




            <!-- OUTROS JS e CSS | FORA DO AMBIENTE METRONIC -->
            <!-- GRAFICOS -->
            <link href="<?php echo PUBLICO; ?>graficos/estilografico.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo PUBLICO; ?>graficos/ammap.js "></script>
            <script src="<?php echo PUBLICO; ?>graficos/pie.js "></script>
            <script src="<?php echo PUBLICO; ?>graficos/brazilLow.js "></script>
            <!-- FIM GRAFICOS -->
            <!-- FIM OUTROS JS e CSS | FORA DO AMBIENTE METRONIC -->

        </head>

        <body class="page-sidebar-closed-hide-logo page-container-bg-solid">
            <div class="page-header navbar navbar-static-top">

                <?php require_once 'application/helper/header.php'; ?>

            </div>
            <div class="clearfix"> </div>
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->

                <?php require_once 'application/helper/menu-lateral.php'; ?>

                <!-- END SIDEBAR -->
                <div class="page-content-wrapper">
                    <div class="page-content" style="min-height: 930px;">
                        <!-- BEGIN CONTENT BODY -->
                        <?php require_once $urlRedirect; ?>
                        <!-- END CONTENT BODY -->
                    </div>
                </div>
            </div>

            <?php require_once 'application/helper/rodape.php'; ?>

        </body>
    </html>

<?php } else if ($modulo == 'inicio') { ?>
    <html lang="br">
        <head>
            <?php require_once 'view/login/scripts.php'; ?>
        </head>
        <body class="page-sidebar-closed-hide-logo page-container-bg-solid">
            <div class="clearfix"> </div>
            <div class="page-container">
                <div class="page-content-wrapper" >
                    <div class="page-content" style="min-height: 930px; margin-left: 0px;">
                        <!-- BEGIN CONTENT BODY -->
                        <?php
                        if ($modulo == 'inicio' && $pagina == 'home') {
                            require_once 'view/inicio/home.php';
                        } else if ($modulo == 'inicio' && $pagina == 'manual') {
                            require_once 'view/inicio/manual.php';
                        }
                        ?>
                        <!-- END BEGIN CONTENT BODY -->
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
} else if ($modulo == 'login' && $pagina == 'manutencao') {
    //Página de Manutenção do Sistema - Fora do Ar
    require_once 'view/login/manutencao.php';
} else {
    //require_once $urlRedirect;
    //verificar tem que somente carregar a página de login quando não encontrar
    require_once 'view/login/inicio.php';
}
?>
<!-- FIM VALIDAÇÃO DE LOGIN -->