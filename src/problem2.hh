<?hh

namespace Challenge;

use \ConstVector;
use function \{array_map, array_reduce};

function prodExcept(ConstVector<num> $xs): ConstVector<num>
{
    $prod = array_reduce($xs, function ($a, $b) { return $a * $b; }, 1);
    return new ImmVector(array_map(function ($a) use ($prod) { return $prod / $a; }, $xs));
}
