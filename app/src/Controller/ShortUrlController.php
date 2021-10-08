<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\ShortUrlType;
use App\Repository\ShortUrlRepository;
use App\Repository\UserRepository;
use App\Services\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/short/url")
 */
class ShortUrlController extends AbstractController
{
    /**
     * @Route("/", name="short_url_index", methods={"GET"})
     */
    public function index(ShortUrlRepository $shortUrlRepository): Response
    {
        return $this->render('short_url/index.html.twig', [
            'short_urls' => $shortUrlRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="short_url_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        UserRepository $userRepository,
        ShortUrlRepository $urlRepository,
        TokenService $tokenService
    ): Response
    {
        $email = $authenticationUtils->getLastUsername();
        $user = $userRepository->findByEmail($email);

        $shortUrl = new ShortUrl();
        $shortUrl->setUser($user);

        $form = $this->createForm(ShortUrlType::class, $shortUrl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $counter = $urlRepository->getLatestCounterForUser($user->getId());
            $shortUrl->setCounter($counter + 1);
            $hostName = parse_url($shortUrl->getLongUrl(), PHP_URL_HOST);
            $token = $tokenService->create($hostName, $counter, $user->getId());
            if(! $urlRepository->isTokenUnique($token)) {
                dd(sprintf('Token is not Unique %s', $token));
            }

            $shortUrl->setToken($token);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shortUrl);
            $entityManager->flush();

            return $this->redirectToRoute('short_url_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('short_url/new.html.twig', [
            'short_url' => $shortUrl,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="short_url_show", methods={"GET"})
     */
    public function show(ShortUrl $shortUrl): Response
    {
        return $this->render('short_url/show.html.twig', [
            'short_url' => $shortUrl,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="short_url_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShortUrl $shortUrl): Response
    {
        $form = $this->createForm(ShortUrlType::class, $shortUrl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('short_url_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('short_url/edit.html.twig', [
            'short_url' => $shortUrl,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="short_url_delete", methods={"POST"})
     */
    public function delete(Request $request, ShortUrl $shortUrl): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shortUrl->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shortUrl);
            $entityManager->flush();
        }

        return $this->redirectToRoute('short_url_index', [], Response::HTTP_SEE_OTHER);
    }
}
