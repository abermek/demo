<?php

namespace App\Controller\Image;

use App\Attribute\Input;
use App\Entity\Image;
use App\Form\Type\ImageType;
use App\Service\Image\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\RequestBody(request=ImageType::class, required=true)
 * @OA\Response(
 *     response=200,
 *     description="Returns created Image",
 *     @SWG\Model(type=Image::class)
 * )
 * @OA\Tag(name="Image")
 * @SWG\Security(name="Bearer")
 */
#[Route(path: '/images', name: 'images.create', methods: ['POST'])]
class CreateAction
{
    public function __invoke(
        EntityManagerInterface $em,
        UploadImage $uploadImage,
        #[Input(ImageType::class)] Image $image
    ): Image {
       $uploadImage->execute($image);

        $em->persist($image);
        $em->flush();

        return $image;
    }
}
