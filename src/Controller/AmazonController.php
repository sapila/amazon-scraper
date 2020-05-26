<?php

namespace ScrapingService\Controller;

use ScrapingService\Amazon\Service\AmazonService;
use ScrapingService\Controller\Request\ProductRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AmazonController
{
    public function getProduct(Request $request,ValidatorInterface $validator, AmazonService $amazonService)
    {
        $productRequest = new ProductRequest(
            $request->get('locale'),
            $request->get('asin'),
            $request->get('title')
        );

        $errors = $validator->validate($productRequest);

        if (count($errors) > 0) {
            $errorCollection = array();
            foreach($errors as $error){
                /** @var $error ConstraintViolationInterface */
                $errorCollection[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse($errorCollection);
        }

        $product = $amazonService->fetch($productRequest);

        return new JsonResponse($product->toArray(), 200);
    }
}
