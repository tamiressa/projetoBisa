<?php
require '../model/tipo_entrada_model.php';

class Tipos_entrada
{
    private $tipoModel;
    public function __construct()
    {
        $this->tipoModel = new TipoEntradasModel();
    }
    public function salvarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $nomeTipo = $data['nome'];

        if (trim($nomeTipo) == null) {
            echo  'error nulo';
        } else if (is_numeric($nomeTipo)) {
            echo 'e numeros';
        } else if (strlen($nomeTipo) > 15) {
            echo 'error';
        } else {
            $resposta = $this->tipoModel->salvar_dados_entradas($nomeTipo);
            $arrayz['nome'] = $data['nome'];
            $arrayz['id'] = $resposta;
            echo json_encode($arrayz);
        }

        
    }
    public function listarTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            echo 'Metodo invalido';
            return;
        }
        $tipos = $this->tipoModel->listar_dados_entradas();
        echo json_encode($tipos);
    }
    public function delet()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        if (trim($id == null)) {
            echo 'O id e nulo';
            return;
        } else if (is_string($id)) {
            echo 'O tipo string não e aceito';
            return;
        }
        $del = $this->tipoModel->deletar_dados_entradas($id);
        $arrayz['id'] = $data['id'];
        $arrayz['status'] = $del;
        $arrayz['msg'] = "DELETEI";
        echo json_encode($arrayz);
    }
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $nome = $data['nome'];

        if (trim($id == null)) {
            echo 'O id e nulo';
            return;
        } else if (is_string($id)) {
            echo 'O tipo string não e aceito';
            return;
        }
        if (trim($nome == null)) {
            echo 'O nome e nulo';
            return;
        } else if (is_numeric($nome)) {
            echo 'O tipo numero não e aceito';
            return;
        }
        $resposta = $this->tipoModel->editar_dados_entradas($nome, $id);
        $arrayz['id'] = $data['id'];
        $arrayz['nome'] = $data['nome'];
        echo json_encode($arrayz);
    }
}
$funcao = $_GET['funcao'];
$classe = new Tipos_entrada();

$classe->$funcao();