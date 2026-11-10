<?php

namespace App\Serializer\Normalizer;

use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private CacheManager $cache
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = [];
        foreach ($object as $obj) {
            if($obj instanceof User){
                $obj->getAvatar() ? $obj->setAvatar($this->cache->getBrowserPath("/media/avatar/".$obj->getAvatar(), "avatar")) : null;
                array_push($data, $this->normalizer->normalize($obj, $format, $context));
            }
        }

        return [
            "data" => $data,
            "total" => count($object),
            "maxPage" => ceil(count($object) / $context["limit"]),
            'currentpage' => $context['currentpage'] ?? 1
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Paginator;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Paginator::class => true];
    }
}
