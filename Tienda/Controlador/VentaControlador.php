<?php

header('Content-Type: application/json');
require_once '../Modelo/VentasModel.php';

class VentaControlador
{
    private $ventasModel;

    public function __construct()
    {
        $this->ventasModel = new VentasModel();
    }

    public function processRequest()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => true, 'message' => 'Error en la decodificación JSON: ' . json_last_error_msg()]);
            return;
        }

        if (isset($input['action'])) {
            switch ($input['action']) {
                case 'create':
                    $this->createVenta($input);
                    break;

                case 'getAll':
                    $this->getAllVentas();
                    break;

                case 'getById':
                    if (isset($input['id_venta'])) {
                        $this->getVentaById($input['id_venta']);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'ID de venta no proporcionado.']);
                    }
                    break;

                case 'getAllByEmpresa':
                    if (isset($input['id_empresa'])) {
                        $this->getAllVentasByEmpresa($input['id_empresa']);
                    } else {
                        echo json_encode(['error' => true, 'message' => 'ID de empresa no proporcionado.']);
                    }
                    break;

                default:
                    echo json_encode(['error' => true, 'message' => 'Acción no válida.']);
                    break;
            }
        } else {
            echo json_encode(['error' => true, 'message' => 'Acción no especificada.']);
        }
    } else {
        echo json_encode(['error' => true, 'message' => 'Método no permitido.']);
    }
}

public function getAllVentasByEmpresa($id_empresa): void
{
    try {
        $ventas = $this->ventasModel->getAllVentasByEmpresa($id_empresa);
        
        echo json_encode($ventas);
    } catch (PDOException $e) {
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
}




    public function createVenta($data)
    {
        try {
            $idVenta = $this->ventasModel->createVenta(
                $data['id_usuario'],
                $data['total'],
                $data['detalles'] // Array de detalles de venta
            );
            echo json_encode(['success' => true, 'message' => 'Venta creada exitosamente.', 'id_venta' => $idVenta]);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getAllVentas()
    {
        try {
            $ventas = $this->ventasModel->getAllVentas();
            echo json_encode($ventas);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getVentaById($id_venta)
    {
        try {
            $venta = $this->ventasModel->getVentaById($id_venta);
            echo json_encode($venta);
        } catch (PDOException $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}

$controlador = new VentaControlador();
$controlador->processRequest();
