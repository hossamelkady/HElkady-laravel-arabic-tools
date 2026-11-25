<?php

namespace HossamElkady\ArabicTools\Support;

use InvalidArgumentException;

class Currencies
{
    /** Each unit: [singular, dual, plural 3-10, accusative singular 11+] */
    private const LIST = [
        'EGP' => [
            'major' => ['جنيه مصري', 'جنيهان مصريان', 'جنيهات مصرية', 'جنيهاً مصرياً'],
            'minor' => ['قرش', 'قرشان', 'قروش', 'قرشاً'],
        ],
        'SAR' => [
            'major' => ['ريال سعودي', 'ريالان سعوديان', 'ريالات سعودية', 'ريالاً سعودياً'],
            'minor' => ['هللة', 'هللتان', 'هللات', 'هللة'],
        ],
        'AED' => [
            'major' => ['درهم إماراتي', 'درهمان إماراتيان', 'دراهم إماراتية', 'درهماً إماراتياً'],
            'minor' => ['فلس', 'فلسان', 'فلوس', 'فلساً'],
        ],
        'USD' => [
            'major' => ['دولار أمريكي', 'دولاران أمريكيان', 'دولارات أمريكية', 'دولاراً أمريكياً'],
            'minor' => ['سنت', 'سنتان', 'سنتات', 'سنتاً'],
        ],
        'KWD' => [
            'decimals' => 3,
            'major' => ['دينار كويتي', 'ديناران كويتيان', 'دنانير كويتية', 'ديناراً كويتياً'],
            'minor' => ['فلس', 'فلسان', 'فلوس', 'فلساً'],
        ],
    ];

    public static function get(string $code): array
    {
        $code = strtoupper($code);
        return self::LIST[$code] ?? throw new InvalidArgumentException("Unsupported currency [$code].");
    }
}
