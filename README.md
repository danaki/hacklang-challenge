# Hacklang challenge

## Installation

 * Install [HHVM](https://github.com/hhvm/homebrew-hhvm)
 * Install [composer](https://getcomposer.org/download/)
 * Install composer dependencies: `hhvm composer.phar install`
 * Run `hhvm vendor/bin/phpunit`

## Problems

===================================================================================
PROBLEM 1
===================================================================================

Implement a function with the following signature:

function findMaxSliceSum(ConstVector<int> $xs): int

The function should accept an arbitrary vector of integers and return the maximum
possible sum of any contiguous slice (that is, anything that can be obtained using
the slice() method) of this vector.

For example:

--------------------------------------+--------------------------------------------
$xs                                   | expected result
--------------------------------------+--------------------------------------------
ImmVector { 1, 2, 3, 4, 5 }           | 15
                                      | NOTE: The slice consisting of the entire
                                      | vector has a greater sum that any smaller
                                      | slice in this case.
--------------------------------------+--------------------------------------------
ImmVector { -1, -2, -3, -4, -5 }      | 0
                                      | NOTE: Empty slice has a sum of zero, and
                                      | all non-empty slices of this vector have
                                      | negative sums.
--------------------------------------+--------------------------------------------
ImmVector { 1, -2, 3, -4 }            | 3
                                      | The slice consisting of a single element -
                                      | 3 - has the sum of 3, and this sum is
                                      | greater than the sum of any other slice of
                                      | this vector.
--------------------------------------+--------------------------------------------
ImmVector { 2, -2, 4, -2, 6, -2 }     | 8
                                      | Two different slices of this vector have
                                      | the maximum possible sum of 8.
--------------------------------------+--------------------------------------------
ImmVector { 5, -1, -2, 10, -8, 3, 4 } | 12
                                      | The slice 5, -1, -2, 10 has a sum of 12,
                                      | and all other slices of this vector have
                                      | strictly smaller sums.
--------------------------------------+--------------------------------------------

There is a straightforward solution to this problem, but solutions with quadratic
(or worse) time complexity are not optimal and will likely fail the efficiency
test.

===================================================================================
PROBLEM 2
===================================================================================

Implement a function with the following signature:

function prodExcept(ConstVector<num> $xs): ConstVector<num>

The function should accept any vector of numbers and return another vector of
numbers with the same number of elements.

Elements of the resulting vector should be produced as follows.  The first element
of the result should equal to the product of all the elements of the original
vector except for the first one, the second element of the result should equal to
the product of all the elements of the original vector except for the second one
etc. etc.

A few examples:

----------------------------+------------------------------------------------------
$xs                         | expected result
----------------------------+------------------------------------------------------
ImmVector { 1, 2, 3, 4 }    | ImmVector { 24, 12, 8, 6 }
                            | NOTE: 24 is the product of 2, 3 and 4; 12 is the
                            | product of 1, 3 and 4; 8 is the product of 1, 2 and
                            | 4; 6 is the product of 1, 2 and 3.
----------------------------+------------------------------------------------------
ImmVector { }               | ImmVector { }
----------------------------+------------------------------------------------------
ImmVector { -0.5, 100, 20 } | ImmVector { 2000, -10, -50 }
                            | NOTE:
                            |    2000 =  100 * 20
                            |     -10 = -0.5 * 20
                            |     -50 = -0.5 * 100
----------------------------+------------------------------------------------------

With some inputs, particularly those involving very large or very small (but
non-zero) numbers, floating point precision issues might come into play, and the
order of operations might substantially affect the final result.  You do not need
to concern yourself with that, and you may assume that all inputs, outputs and
intermediate results are not going to trigger this problem.

As with Problem 1, there is a very straightforward solution to this problem, but
any solution with quadratic (or worse) time complexity is unlikely to pass the
efficiency test.

===================================================================================
PROBLEM 3
===================================================================================

Implement a function with the following signature:

function parse(string $str): ?Set<string>

The function should parse an input string containing a description of a set of
strings using a special syntax, and return the set described.  If the input string
contains any syntax errors, the function should return null instead.

The following characters have a special meaning in the input string syntax:

* Braces: { and } are used to delimit a portion of the string where one of several
  options may be chosen to produce strings in the resulting set.

* Pipeline: | is used to delimit different options within braces.

* Backslash: \ serves as an escape character, allowing to insert braces and
  pipelines into the resulting string.

Unmatched unescaped braces are not allowed and are considered to be a syntax error.
Unescaped pipelines may only occur inside braces and are considered to be a syntax
error otherwise.  Unescaped backslash must always be followed by another character,
and is considered to be a syntax error when occurring as the last character in the
input string.

A few things that are NOT considered to constitute syntax errors:

* While braces are used for branching, they are allowed to contain just a single
  group, e.g. 'abcdef{ghijkl}mnopqr' is considered to be valid and equivalent to
  just 'abcdefghijklmnopqr'.

* Pipeline-delimited options within braces may be empty.  'a{b|}' is considered to
  be valid.

* Backslash may be used before characters other than braces, pipelines and
  backslashes.  The meaning in that case is the same as if the backslash were
  simply absent.  E.g. 'a\bc' is considered to be valid and equivalent to 'abc'.

A few examples:

1. Input: 'ab{c|d|e}'

   Expected result:
   Set {
       'abc',
       'abd',
       'abe'
   }

   NOTE: Describes a string starting with 'ab' followed by any of 'c', 'd' or 'e'.

2. Input: 'a{b|c}}'

   Expected result:
   null

   NOTE: There's an umatched closing brace in the input string.

3. Input: 'a{b{c|d}|e{f|g}}h'

   Expected result:
   Set {
       'abch',
       'abdh',
       'aefh',
       'aegh'
   }

4. Input: 'a{b|c}d{e|f}h'

   Result:
   Set {
       'abdeh',
       'abdfh',
       'acdeh',
       'acdfh'
   }

5. Input: '{\\{|\\||\\}}'

   Result:
   Set {
       '{',
       '|',
       '}'
   }

   NOTE: The input string is shown here as it would have to be typed in Hack
   source, since backslash is also considered to be an escape character by Hack
   itself.  The double backslashes above translate into a single actual backslash
   character.

You may not assume that a certain arbitrary substring will never occur in the input
strings.  Consider this to be an adversarial environment.  If your code relies on
this assumption, test cases will include a test specifically crafted to trip it.

If you're tempted to use regular expressions to solve this problem, you're probably
not on the right track, as the grammar of the input strings is not regular.

===================================================================================
PROBLEM 4
===================================================================================

Implement a function with the following signature:

function fanout<Tx, Ty, Tz>(
    (function (): Result<Tx>) $f,
    (function (Tx): Result<Ty>) $g1,
    (function (Tx): Result<Tz>) $g2
): Result<(Ty, Tz)>

Where the Result class is defined as follows:

=== begin Result.hh ===============================================================
<?hh // strict

/**
 * A wrapper for a value that may be absent due to a failure or error of some kind.
 * A Result<Tx> EITHER contains a value of type Tx, OR an Exception explaining why
 * the value in question could not be obtained.
 */
final class Result<+Tx>
{
    /**
     * Given a function producing a value of type Tx, runs it, and wraps the result
     * if successful.
     * If the given function throws an exception, catches it and wraps it in the
     * Result instead.
     */
    final public static function make((function (): Tx) $f): Result<Tx>
    {
        try {
            return new Result($f(), null);
        } catch (\Exception $ex) {
            return new Result(null, $ex);
        }
    }

    /**
     * Given a function computing Ty's out of Tx's, produces Result<Ty> out of a
     * given Result<Tx>
     *
     * - In case the original Result<Tx> wraps an exception, simply keeps the same
     *   exception in the Result<Ty> produced, without ever running $f.
     *
     * - In case there is a value inside Result<Tx>, applies $f to it and wraps the
     *   resulting Ty.
     */
    final public function map<Ty>((function (Tx): Ty) $f): Result<Ty>
    {
        return $this->flatMap($x ==> Result::make(() ==> $f($x)));
    }

    /**
     * Given a function that may successfully produce a Ty out of Tx or fail
     * instead, applies it to the value wrapped in the given Result<Tx>, or simply
     * passes along the wrapped exception.
     */
    final public function flatMap<Ty>((function (Tx): Result<Ty>) $f): Result<Ty>
    {
        if (!is_null($this->value)) {
            try {
                return $f($this->value);
            } catch (\Exception $ex) {
                return new Result(null, $ex);
            }
        } else {
            invariant(!is_null($this->error),
                'Exception must be present if value is absent');
            return new Result(null, $this->error);
        }
    }

    /**
     * Produces a simple string representation of this wrapper together with its
     * wrapped value or exception.
     *
     * This isn't meant to be invertible, and should only be used for testing
     * purposes.
     */
    final public function __toString(): string
    {
        if (!is_null($this->value)) {
            return 'Success(' . var_export($this->value, true) . ')';
        } else {
            invariant(!is_null($this->error),
                'Exception must be present if value is absent');
            return 'Failure(' . strval($this->error->getMessage()) . ')';
        }
    }

    final private function __construct(
        private ?Tx $value,
        private ?\Exception $error
    )
    {
        invariant((!is_null($value) && is_null($error)) ||
            (is_null($value) && !is_null($error)),
            'Exactly one of value and error must be non-null');
    }
}
=== end Result.hh =================================================================

Simply put, if Tx is some type, then Result<Tx> contains either a value of that
type, or an exception explaining why this value could not be obtained.

Fanout should evaluate the given function $f, and if it successfully produces a
value (rather than an exception wrapped in Result), it should apply both $g1 and
$g2 to it.  If both functions also successfully produce values, those values should
be stuffed into a tuple() and returned in a result.  If there's any failure along
the way, that failure should be returned as a final result.  $g1 should be
evaluated before $g2.  You may assume that $f, $g1 and $g2 are all pure and will
not cause any observable side effects when evaluated.

You are not allowed to change the given definition of Result.

Result::__toString() is provided for testing only and should not be used in your
solution.

Example:

Let's say we define functions $div and $succ as follows:

    $div = $x ==> Result::make(() ==>
    {
        if ($x === 0) {
            throw new \Exception('Division by zero.');
        }
        return 1024 / $x;
    });
    $succ = $x ==> Result::make(() ==> $x + 1);

Then the following call to fanout:

    strval(fanout(() ==> Result::make(() ==> 0), $div, $succ))

...should evaluate to the following string:

    'Failure(Division by zero.)'

While:

    strval(fanout(() ==> Result::make(() ==> 1), $div, $succ))

...should evaluate to:

    'Success(array (
      0 => 1024,
      1 => 2,
    ))'

The expected solution is essentially a single line of code.  The difficulty of this
problem lies in figuring out how to put together the few capabilities provided to
get the desired result.

Good luck!
