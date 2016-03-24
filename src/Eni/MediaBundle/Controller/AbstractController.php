<?php

namespace Eni\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AbstractController
 *
 * @author Administrateur
 */
abstract class AbstractController extends Controller
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function renderHtml($template, $variables = [])
    {
        extract($variables);
        ob_start();
        require_once __DIR__ . '/../Resources/views/' . $template;
        $content = ob_get_clean();
        return new Response($content);
    }

    public function createResponseListFromFormat($data, $format)
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $headers = [
            "Content-Type" => "application/$format"
        ];
        return new Response($serializer->serialize($data, $format), 200, $headers);
    }
}
