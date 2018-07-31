<?hh // strict

use function Challenge\findMaxSliceSum;
use function Facebook\FBExpect\expect;
use PHPUnit\Framework\TestCase;

final class Problem1Test extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testSolution($input, $expected)
    {
        expect(findMaxSliceSum($input))->toBeSame($expected);
    }

    public function dataProvider()
    {
        return [
            [ImmVector { 1, 2, 3, 4, 5 }, 15],
            [ImmVector { -1, -2, -3, -4, -5 }, 0],
            [ImmVector { 1, -2, 3, -4 }, 3],
            [ImmVector { 2, -2, 4, -2, 6, -2 }, 8],
            [ImmVector { 5, -1, -2, 10, -8, 3, 4 }, 12]
        ];
    }
}
