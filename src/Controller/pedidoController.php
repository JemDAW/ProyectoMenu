<?php
namespace App\Controller;
use App\Repository\PedidoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class pedidoController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class pedidoController
{
    private $PedidoRepository;

    public function __construct(PedidoRepository $PedidoRepository)
    {
        $this->PedidoRepository = $PedidoRepository;
    }

    /**
     * @Route("pedido", name="add_pedido", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $mesa = $data['mesa'];
        $precio_total = $data['precio_total'];
        $fecha = $data['fecha'];
        $hora = $data['hora'];

        if (empty($mesa) || empty($precio_total) || empty($fecha)) {
            throw new NotFoundHttpException('Mesa, precio_total y contraseña obligatorio');
        }

        $this->PedidoRepository->savePedido($mesa, $precio_total, $fecha, $hora);

        return new JsonResponse(['status' => 'Pedido created!'], Response::HTTP_CREATED);
    }

        /**
     * @Route("pedido/{id}", name="get_one_pedido", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $pedido = $this->PedidoRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $pedido->getId(),
            'mesa' => $pedido->getMesa(),
            'precio_total' => $pedido->getPrecioTotal(),
            'fecha' => $pedido->getFecha(),
            'hora' => $pedido->getHora()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("pedidos", name="get_all_pedidos", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $pedidos = $this->PedidoRepository->findAll();
        $data = [];

        foreach ($pedidos as $pedido) {
            $data[] = [
                'id' => $pedido->getId(),
                'mesa' => $pedido->getMesa(),
                'precio_total' => $pedido->getPrecioTotal(),
                'fecha' => $pedido->getFecha(),
                'hora' => $pedido->getHora()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("pedido/{id}", name="update_pedido", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $pedido = $this->PedidoRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['mesa']) ? true : $pedido->setMesa($data['mesa']);
        empty($data['precio_total']) ? true : $pedido->setPrecioTotal($data['precio_total']);
        empty($data['fecha']) ? true : $pedido->setFecha($data['fecha']);
        empty($data['hora']) ? true : $pedido->setHora($data['hora']);

        $updatedpedido = $this->PedidoRepository->updatePedido($pedido);

		return new JsonResponse(['status' => 'Pedido updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("pedido/{id}", name="delete_pedido", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $pedido = $this->PedidoRepository->findOneBy(['id' => $id]);

        $this->PedidoRepository->removePedido($pedido);

        return new JsonResponse(['status' => 'Pedido deleted'], Response::HTTP_OK);
    }
}

?>