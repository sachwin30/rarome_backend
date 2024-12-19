<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



use App\Service\UploadDocument;





class TestController extends AbstractController {
    
    

    private $uploadDocument;

    public function __construct(UploadDocument $uploadDocumentService) {
        $this->uploadDocument = $uploadDocumentService;
    }

    
    #[Route('/documents', name: 'documents')]
    public function documentList(): JsonResponse {
        try {
            
            
            
            
            $docList = $this->uploadDocument->documentList();
            
            
            
            
            return new JsonResponse(['success' => true, 'data' => $docList, 'message' => ''], Response::HTTP_OK);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}

?>