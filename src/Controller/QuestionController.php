<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_show")
     */
    public function show($id)
    {
        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        return new Response('Check out this great question: '.$question->getName());

        // or render a template
        // in the template, print things with {{ question.name }}
        // return $this->render('question/show.html.twig', ['question' => $question]);
    }
}
