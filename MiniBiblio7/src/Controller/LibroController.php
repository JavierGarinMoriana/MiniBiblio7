<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Form\LibroType;
use App\Repository\AutorRepository;
use App\Repository\EditorialRepository;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    #[Route("listar", name: "listar")]
    function listarLibros(LibroRepository $libroRepository): Response
    {
        $libros = $libroRepository->listarLibrosAlfabetico();
        return $this->render("listar.html.twig", ["libros" => $libros]);
    }

    #[Route(path: "modificar/{id}", name: "modificarLibro")]
    public function listarLibrosModificables(Request $request, LibroRepository $libroRepository, Libro $libro): Response
    {

        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        $nuevo = $libro->getId() === null;

        if ($form->isSubmitted() && $form->isValid()){
            try {

                $libroRepository->save($libro);
                if ($nuevo) {
                    $this->addFlash('success', 'Libro creado con exito');
                } else {
                    $this->addFlash('success', 'Libro guardado con exito');
                }

                return $this->redirectToRoute('listar');

            }catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el libro');
            }
        }

        return $this->render('modificar.html.twig', ['form' => $form->createView(), 'libro' => $libro]);
    }

    #[Route('/eliminar/{id}', name: 'eliminarLibro')]
    public function elimiarLibros(Request $request, LibroRepository $libroRepository, Libro $libro) : Response
    {
        if ($request->request->has('confirmar')) {
            try {
                $libroRepository->remove($libro);
                $libroRepository->save();
                $this->addFlash('success', 'Libro borrado con exito');
                return $this->redirectToRoute('listar');
            }catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el libro');
            }
        }

        return $this->render('eliminar.html.twig', ['libro' => $libro]);
    }

    #[Route('nuevo', name: 'libroNuevo')]
    public function crearLibros(Request $request, LibroRepository $libroRepository) : Response
    {
        $libro = new Libro();
        $libroRepository->add($libro, false);
        return $this->listarLibrosModificables($request, $libroRepository, $libro);
    }
}