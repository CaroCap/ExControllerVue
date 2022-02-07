<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExRecapController extends AbstractController
{
    #[Route('/ex/recap', name: 'ex_recap')]
    public function index(): Response
    {
        return $this->render('ex_recap/index.html.twig', [
            'controller_name' => 'ExRecapController',
        ]);
    }

    #[Route('/ex/recap/bienvenue', name: 'ex_bienvenue')]
    public function hello()
    {
        return $this->render('ex_recap/hello.html.twig', [
            'controller_name' => 'ExRecapController',
        ]);
    }

    #[Route('/ex/recap/{prenom}', name: 'ex_recap_prenom')]
    public function helloYou(Request $objet)
    {
        $prenom = $objet->get('prenom');
        $array = ["prenom" => $prenom];
        return $this->render('ex_recap/hello_prenom.html.twig', $array);
    }

    #[Route('/ex/recap/genre/{prenom}', name: 'ex_recap_genre')]
    public function helloGenre(Request $objet, HttpClientInterface $client)
    {
        $prenom = $objet->get('prenom');
        $response = $client->request("GET", "https://api.genderize.io/?name=".$prenom);
        $contenu = $response->getContent();
        // pour transformer le json en array => true sinon sera un objet
        $array = json_decode($contenu, true);
        // pour voir ce que json renvoie 
        // return new Response(dd($array));
        return $this->render('ex_recap/hello_genre.html.twig', $array);
    }
}
