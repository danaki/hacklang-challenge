# Hacklang challenge

## Installation

 * Install [HHVM](https://github.com/hhvm/homebrew-hhvm)
 * Install [composer](https://getcomposer.org/download/)
 * Install composer dependencies: `hhvm composer.phar install`
 * Run `hhvm vendor/bin/phpunit`

## Problems

### PROBLEM 1

Implement a function with the following signature:

function findMaxSliceSum(ConstVector<int> $xs): int

The function should accept an arbitrary vector of integers and return the maximum
possible sum of any contiguous slice (that is, anything that can be obtained using
the slice() method) of this vector.

For example:
```
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
```

There is a straightforward solution to this problem, but solutions with quadratic
(or worse) time complexity are not optimal and will likely fail the efficiency
test.

### PROBLEM 2

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

```
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
```

With some inputs, particularly those involving very large or very small (but
non-zero) numbers, floating point precision issues might come into play, and the
order of operations might substantially affect the final result.  You do not need
to concern yourself with that, and you may assume that all inputs, outputs and
intermediate results are not going to trigger this problem.

As with Problem 1, there is a very straightforward solution to this problem, but
any solution with quadratic (or worse) time complexity is unlikely to pass the
efficiency test.

