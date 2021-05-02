<?php
namespace App\Controller;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class itemController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class itemController
{
    private $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @Route("item", name="add_item", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        $precio = $data['precio'];
        $descripcion = $data['descripcion'];
        $tag = $data['tag'];

        if (empty($nombre) || empty($precio)) {
            throw new NotFoundHttpException('Nombre y precio obligatorio');
        }

        $this->itemRepository->saveitem($nombre, $precio, $descripcion, $tag);

        return new JsonResponse(['status' => 'Item created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("item/{id}", name="get_one_item", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $item = $this->itemRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $item->getId(),
            'nombre' => $item->getNombre(),
            'precio' => $item->getPrecio(),
            'descripcion' => $item->getDescripcion(),
            'tag' => $item->getTag()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
    * @Route("items/{texto}", name="buscar_items_tag")
    */
    public function buscar($texto)
    {
        $items = $this->itemRepository->findByTag($texto);
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'precio' => $item->getPrecio(),
                'descripcion' => $item->getDescripcion(),
                'tag' => $item->getTag()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("items", name="get_all_items", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $items = $this->itemRepository->findAll();
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'precio' => $item->getPrecio(),
                'descripcion' => $item->getDescripcion(),
                'tag' => $item->getTag()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("item/{id}", name="update_item", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $item = $this->itemRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nombre']) ? true : $item->setNombre($data['nombre']);
        empty($data['precio']) ? true : $item->setPrecio($data['precio']);
        empty($data['descripcion']) ? true : $item->setDescripcion($data['descripcion']);
        empty($data['tag']) ? true : $item->setTag($data['tag']);

        $updateditem = $this->itemRepository->updateitem($item);

		return new JsonResponse(['status' => 'item updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("item/{id}", name="delete_item", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $item = $this->itemRepository->findOneBy(['id' => $id]);

        $this->itemRepository->removeitem($item);

        return new JsonResponse(['status' => 'item deleted'], Response::HTTP_OK);
    }
}

?>