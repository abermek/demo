<?php

namespace App\Controller\Image;

use App\Attribute\Input;
use App\DTO\Response\ImageResponse;
use App\Service\Image\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\ImageType;
use App\Entity\Image;
use Vich\UploaderBundle\Handler\UploadHandler;
use Nelmio\ApiDocBundle\Annotation as SWG;
use OpenApi\Annotations as OA;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
        UploaderHelper $uploaderHelper,
        #[Input(ImageType::class)] Image $image
    ): ImageResponse {
       $uploadImage->execute($image);

        $em->persist($image);
        $em->flush();

        return new ImageResponse(
            $image->getId(),
            $image->getName(),
            $uploaderHelper->asset($image, Image::FILE_FIELD_NAME)
        );
    }
}
