<?hh // strict

namespace Challenge;

use \ConstVector;
use function \array_reverse;

function findMaxSliceSum(ConstVector<int> $xs): int
{
    $back = [0];
    foreach ($xs as $i => $x) {
        $back[] = $back[$i] + $x;
    }

    $forward = [0];
    foreach (array_reverse($xs) as $i => $x) {
        $forward[] = $forward[$i] + $x;
    }

    $forward = array_reverse($forward);

    $res = [];
	foreach ($xs as $i => $x) {
        $res[] = Pair { $back[$i], $forward[$i + 1] };
    }

    $max = 0;
    foreach ($xs as $i => $x) {
        $q = $x + $res[$i][0];
        if ($q > $max) {
            $max = $q;
        }

        $q = $x + $res[$i][1];
        if ($q > $max) {
            $max = $q;
        }

        if ($x > $max) {
            $max = $x;
        }
    }

    return $max;
}

