<?hh // strict

use function Challenge\prodExcept;
use function Facebook\FBExpect\expect;
use PHPUnit\Framework\TestCase;

final class Problem2Test extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testSolution($input, $expected)
    {
        expect(prodExcept($input))->toHaveSameContentAs($expected);
    }

    public function dataProvider()
    {
        return [
            [ImmVector { 1, 2, 3, 4 }, ImmVector { 24, 12, 8, 6 }],
            [ImmVector { }, ImmVector { }],
            [ImmVector { -0.5, 100, 20 }, ImmVector { 2000, -10, -50 }]
        ];
    }
}
