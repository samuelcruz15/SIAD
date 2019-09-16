<?php

@session_start();
require_once $_SESSION['PATH'] . 'model/MUsuario.php';

class Usuario extends MUsuario {

    function cadastrar($arrDadosForm = null) {

//Retira espaços em brancos no inicio e fim
        $str_nome = utf8_decode(trim($arrDadosForm['str_nome']));

//Verifica se nome é vazio ou 'Usuário não encontrado'
        if (($arrDadosForm['str_nome'] == 'Usuário não encontrado') || (empty($str_nome))) {
            $this->redirect('9', "usuario/listarUsuario");
        } else {
//Verifica se usuário já esta cadastrado no sistema
            $login = $arrDadosForm['str_login'];
            $result = $this->select_check($arrDadosForm['tabela'], 'str_login', "'$login'");
            if ($result == 0) {
                $result = $this->insert($arrDadosForm);
                $this->redirect('1', "usuario/listarUsuario");
            } else {
                $this->redirect('12', "usuario/listarUsuario");
            }
        }
    }

    function alterar($arrDadosForm) {
        $result = $this->update($arrDadosForm);
        $this->redirect('1', "usuario/listarUsuario");
    }

    function listar($arrDadosForm = null) {
        if (isset($arrDadosForm['idUsuario']) and $arrDadosForm['acao'] == 'ajax') {
            $result = $this->listarUsuario($_POST['idUsuario'], 'str_nome');
            while ($arDados = mysqli_fetch_array($result)) {
                $arr['id'] = $arDados['id_usuario'];
                $arr['nome'] = $arDados['str_nome'];
                $arr['login'] = $arDados['str_login'];
                $arr['situacao'] = $arDados['str_situacao'];
                $arr['perfil'] = $arDados['id_perfil'];
            }
            echo json_encode($arr);
        } else {
            return $this->listarUsuario();
        }
        
    }    
        
       
    
    function listarQuantidade($arrDadosForm = null) {
        
        $resultUsuarioQuant = $this->listaDados("gr_usuario");

        $ativos = 0;
        $inativos = 0;
        $administradores = 0;
        $consultantes = 0;

        while ($arDadosQuant = mysqli_fetch_array($resultUsuarioQuant)) {
            if ($arDadosQuant['str_situacao'] == 'A') {
                $ativos++;
            } else {
                $inativos++;
            }
            if ($arDadosQuant['id_perfil'] == 1 && $arDadosQuant['str_situacao'] == 'A') {
                $administradores++;
            } else if ($arDadosQuant['id_perfil'] == 4 && $arDadosQuant['str_situacao'] == 'A') {
                $consultantes++;
            }
        }
        return array($ativos, $inativos, $administradores, $consultantes);

    }
    
    
    function contarAtivos($arrDadosForm = null) {
        
        
        return $this->contarAtivosMU();

        
        
    }
    
    
    
    
    

    function desativar($arrDadosForm) {
        (($arrDadosForm['str_situacao'] == 'D') ? $arrDadosForm['str_situacao'] = 'A' : $arrDadosForm['str_situacao'] = 'D' );
        $arrDadosForm['str_situacao'];
        $result = $this->update($arrDadosForm);
        $this->redirect('1', "usuario/listarUsuario");
    }

    function listarPerfil() {
        return $this->listaDados('gr_perfil', null, 'str_perfil');
    }

    public function buscaUsuario() {

        $usuario = $_POST['str_login'];

        $conexao = ldap_connect('ldap://10.0.2.253');
        ldap_set_option($conexao, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($conexao, LDAP_OPT_PROTOCOL_VERSION, 3);

        $usuario2 = "dpu\\" . $_SESSION['LOGIN']['str_login'];
        $senha2 = base64_decode($_SESSION['LOGIN']['str_senha']);

        $bind = ldap_bind($conexao, "$usuario2", "$senha2");

//determina base e filtro para consulta LDAP
        $base = "ou=DPGU, dc=dpu, dc=gov, dc=br";
        $filtro = "(&(&(&(objectCategory=person)(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))(samaccountname=$usuario)(|(description=estag*)(description=terc*)(description=colab*)(description=serv*)(description=defe*))))";

//consulta LDAP
        $consulta = ldap_search($conexao, $base, $filtro);
//busca informações do usuário
        $informacoes = ldap_get_entries($conexao, $consulta);
        if (count($informacoes) > 1) {
// echo '<pre>';
// var_dump($informacoes);
            $nome['nome'] = $informacoes[0]['cn'][0];
        } else {
            $nome['nome'] = 'Usuário não encontrado';
        }
        echo json_encode($nome);
    }
    
    
    
    
    

}

$oUsuario = new Usuario();
$classe = 'Usuario';
$oBjeto = $oUsuario;
@include_once '../application/request.php';
?>