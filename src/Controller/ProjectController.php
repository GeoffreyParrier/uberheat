<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\SearchIntent;
use App\Repository\ProjectRepository;
use App\Repository\SearchIntentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="create-project", methods={"POST"})
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return JsonResponse
     */
    public function createAction(Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        $query = json_decode($request->getContent());

        try {
            $this->isValidQueryFormat($query);

            $searchIntents = $query->searchIntents;
            if (!is_array($searchIntents)) {
                throw new Exception('Property "searchIntents" is not an array');
            }

            $newProject = new Project();

            $newProject->setName($query->name);

            foreach ($searchIntents as $searchIntent) {
                $searchIntentObj = new SearchIntent();
                $searchIntentObj->setSearch($searchIntent);

                $newProject->addSearchIntent($searchIntentObj);
            }

            $em = $managerRegistry->getManager();
            $em->persist($newProject);
            $em->flush();

            return $this->json([
                'error' => null,
                'data' => $newProject
            ]);

        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'BAD_REQUEST',
                    'message' => $e->getMessage(),
                ],
                'data' => null
            ]);
        }
    }

    /**
     * @Route("/projects/{id}", name="read-project", methods={"GET"})
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param string $id
     * @return JsonResponse
     */
//    public function readAction(Request $request, ProjectRepository $projectRepository, string $id): JsonResponse
//    {
//        $project = $projectRepository->find($id);
//
//        return $this->json([
//            'error' => null,
//            'data' => $project
//        ]);
//    }

    /**
     * @Route("/projects/{id}/addSearchIntent", name="add-searchIntents-to-project", methods={"PATCH"})
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @param string $id
     * @return JsonResponse
     */
    public function addSearchIntentAction(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, string $id): JsonResponse
    {
        $query = json_decode($request->getContent());

        try {
            $searchIntent = new SearchIntent();
            $searchIntent->setSearch($query);

            $project = $projectRepository->find($id);

            $project->addSearchIntent($searchIntent);

            $em->persist($project);
            $em->flush();
        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'BAD_REQUEST',
                    'message' => $e->getMessage(),
                ],
                'data' => null
            ]);
        }

        return $this->json([
            'error' => null,
            'data' => $project
        ]);
    }

    /**
     * @Route("/projects/{id}/removeSearchIntent/{searchIntentId}", name="remove-searchIntents-to-project", methods={"PATCH"})
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @param SearchIntentRepository $searchIntentRepository
     * @param string $id
     * @param string $searchIntentId
     * @return JsonResponse
     */
    public function removeSearchIntentAction(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, SearchIntentRepository $searchIntentRepository, string $id, string $searchIntentId): JsonResponse
    {
        try {
            $searchIntent = $searchIntentRepository->find($searchIntentId);

            var_dump($searchIntent);

            $project = $projectRepository->find($id);

            $em->remove($searchIntent);
            $em->flush();
        } catch (Exception $e) {
            return $this->json([
                'error' => [
                    'code' => 'BAD_REQUEST',
                    'message' => $e->getMessage(),
                ],
                'data' => null
            ]);
        }

        return $this->json([
            'error' => null,
            'data' => $project
        ]);
    }

    private function isValidQueryFormat($query)
    {
        $validQueryProperties = ['name', 'searchIntents'];
        $requiredQueryProperties = ['name'];

        // Check if required search properties exist in $query
        foreach ($requiredQueryProperties as $requiredQueryProperty) {
            if (!property_exists($query, $requiredQueryProperty)) {
                throw new Exception(sprintf('Missing property "%s"', $requiredQueryProperty));
            }
        }

        // Check if $query has only accepted properties
        $queryPropertiesArray = get_object_vars($query);
        foreach ($queryPropertiesArray as $queryProperty => $queryPropertyValue) {
            if (!in_array($queryProperty, $validQueryProperties, true)) {
                throw new Exception(sprintf('Unknown property "%s", only [%s] are accepted', $queryProperty, implode(', ', $requiredQueryProperties)));
            }
        }
    }
}
