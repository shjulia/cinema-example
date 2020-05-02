<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Model\Movie\Entity\Movie\Movie as MovieEntity;
use App\Model\Movie\UseCase\Movie ;
use App\ReadModel\Movie\MovieFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/create", methods={"POST"})
     * @param Request $request
     * @param Movie\Create\Handler $handler
     * @return JsonResponse
     */
    public function create(Request $request, Movie\Create\Handler $handler): JsonResponse
    {
        /** @var Movie\Create\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Movie\Create\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
        }

        $handler->handle($command);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/update", methods={"POST"})
     * @param MovieEntity $movie
     * @param Request $request
     * @param Movie\Edit\Handler $handler
     * @return JsonResponse
     */
    public function update(MovieEntity $movie, Request $request, Movie\Edit\Handler $handler)
    {
        /** @var Movie\Edit\Command $command */
        $command = $this->serializer->deserialize(
            $request->getContent(),
            Movie\Edit\Command::class,
            'json',
            [
                'object_to_populate' => new Movie\Edit\Command($movie->getId()->getValue()),
                'ignored_attributes' => ['id'],
            ]
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
        }

        $handler->handle($command);

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/delete", methods={"DELETE"})
     * @param MovieEntity $movie
     * @param Request $request
     * @param Movie\Delete\Handler $handler
     * @return JsonResponse
     */
    public function delete(MovieEntity $movie, Request $request, Movie\Delete\Handler $handler) {
        /** @var Movie\Delete\Command $command */
        $command = $this->serializer->deserialize(
            $request->getContent(),
            Movie\Delete\Command::class,
            'json',
            [
                'object_to_populate' => new Movie\Delete\Command($movie->getId()->getValue()),
                'ignored_attributes' => ['id'],
            ]
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);
        }

        $handler->handle($command);

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/search", methods={"GET"})
     * @param Request $request
     * @param MovieFetcher $movieFetcher
     * @return JsonResponse
     */
    public function search(Request $request, MovieFetcher $movieFetcher)
    {
        $movies = $movieFetcher->findMovie(
            $request->get('title', null),
            $request->get('genre', null)
        );
        return $this->json($movies, Response::HTTP_OK);

    }
}