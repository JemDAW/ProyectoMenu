<?php
namespace App\Controller;
use App\Repository\EmpleadoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class empleadoController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class empleadoController
{
    private $EmpleadoRepository;

    public function __construct(EmpleadoRepository $EmpleadoRepository)
    {
        $this->EmpleadoRepository = $EmpleadoRepository;
    }

    /**
     * @Route("empleado", name="add_empleado", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        $email = $data['email'];
        $password = $data['password'];
        $tipo_usuario = $data['tipo_usuario'];

        if (empty($nombre) || empty($email) || empty($password)) {
            throw new NotFoundHttpException('Nombre, email y contraseña obligatorio');
        }

        $this->EmpleadoRepository->saveEmpleado($nombre, $email, $password, $tipo_usuario);

        return new JsonResponse(['status' => 'Empleado created!'], Response::HTTP_CREATED);
    }

        /**
     * @Route("empleado/{id}", name="get_one_empleado", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $empleado = $this->EmpleadoRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $empleado->getId(),
            'nombre' => $empleado->getNombre(),
            'email' => $empleado->getEmail(),
            'password' => $empleado->getPassword(),
            'tipo_usuario' => $empleado->getTipoUsuario()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
    * @Route("login/{texto}", name="buscar_empleado_por_email")
    */
    public function buscarEmpleado($texto): JsonResponse
    {
        $empleados = $this->EmpleadoRepository->findByMail($texto);
        $data = [];

        foreach ($empleados as $empleado) {
            $data[] = [
                'id' => $empleado->getId(),
                'nombre' => $empleado->getNombre(),
                'email' => $empleado->getEmail(),
                'password' => $empleado->getPassword(),
                'tipo_usuario' => $empleado->getTipoUsuario()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("empleados", name="get_all_empleados", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $empleados = $this->EmpleadoRepository->findAll();
        $data = [];

        foreach ($empleados as $empleado) {
            $data[] = [
                'id' => $empleado->getId(),
                'nombre' => $empleado->getNombre(),
                'email' => $empleado->getEmail(),
                'password' => $empleado->getPassword(),
                'tipo_usuario' => $empleado->getTipoUsuario()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("empleado/{id}", name="update_empleado", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $empleado = $this->EmpleadoRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nombre']) ? true : $empleado->setNombre($data['nombre']);
        empty($data['email']) ? true : $empleado->setEmail($data['email']);
        empty($data['password']) ? true : $empleado->setPassword($data['password']);
        empty($data['tipo_usuario']) ? true : $empleado->setTipoUsuario($data['tipo_usuario']);

        $updatedempleado = $this->EmpleadoRepository->updateEmpleado($empleado);

		return new JsonResponse(['status' => 'Empleado updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("delete/empleado/{id}", name="delete_empleado", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $empleado = $this->EmpleadoRepository->findOneBy(['id' => $id]);

        $this->EmpleadoRepository->removeEmpleado($empleado);

        return new JsonResponse(['status' => 'Empleado deleted'], Response::HTTP_OK);
    }
}

?>