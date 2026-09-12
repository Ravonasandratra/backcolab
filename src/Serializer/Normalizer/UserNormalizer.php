<?php

namespace App\Serializer\Normalizer;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = [];
        foreach ($object as $obj) {
            array_push($data, $this->normalizer->normalize($obj, $format, $context));
        }

        return [
            "data" => $data,
            "total" => count($object),
            "maxPage" => ceil(count($object) / $context["limit"]),
            'currentpage' => $context['currentpage'] ?? null
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
