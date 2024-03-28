<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\JobOffer;
use App\Repository\CandidacyRepository;
use App\Repository\CategoryRepository;
use App\Repository\JobOfferRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobOfferRepository $jor, CategoryRepository $catego): Response
    {
        $categorys = $catego->findAll();
        $jobOffers = $jor->findBy([], null, 4);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'jobOffers' => $jobOffers,
            'categorys' => $categorys
        ]);
    }
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/apply', name: 'app_apply')]
    public function apply(HttpFoundationRequest $request, JobOfferRepository $jobRepo, EntityManagerInterface $em, CandidacyRepository $candidacyRepo): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->render('security/login.html.twig');
        }
        $jobId = $request->request->get('jobid');
        $job = $jobRepo->find($jobId);
        $candidacy = new Candidacy();
        $candidacy->setJobOffer($job);
        $candidacy->setCandidat($user->getCandidat());
        $candidacy->setAprouve(false);
        $createdAt = new DateTime();
        $candidacy->setCreatedAt($createdAt);

        $em->persist($candidacy);
        $em->flush($candidacy);

        return $this->redirectToRoute('app_home');
    }
    #[Route('/jobsList', name: 'app_jobsList')]
    public function joblist(JobOfferRepository $jor, CategoryRepository $catego): Response
    {
        $categorys = $catego->findAll();
        $jobOffers = $jor->findBy([], null, 4);
        return $this->render('home/jobs.html.twig', [
            'controller_name' => 'HomeController',
            'jobOffers' => $jobOffers,
            'categorys' => $categorys
        ]);
    }
    #[Route('/detailJobOffer', name: 'app_jobOffer')]
    public function detailJobOffer(JobOfferRepository $jor, HttpFoundationRequest $request): Response
    {

        $candidatures = $this->getUser()->getCandidat()->getCandidacies();
        $jobOffer = $jor->find($request->request->get('jobid'));




        return $this->render('home/detail.html.twig', [
            'controller_name' => 'HomeController',
            'jobOffer' => $jobOffer,
            '$candidatures' => $candidatures,
        ]);
    }
}
