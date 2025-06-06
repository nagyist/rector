# 382 Rules Overview

**This overview is deprecated and replaced by more advanced web search. There you can search and filter by nodes, copy-paste configs for configurable rules and more.**

Use https://getrector.com/find-rule instead!

<br>

## Categories

- [Arguments](#arguments) (4)

- [Carbon](#carbon) (4)

- [CodeQuality](#codequality) (69)

- [CodingStyle](#codingstyle) (29)

- [DeadCode](#deadcode) (45)

- [EarlyReturn](#earlyreturn) (8)

- [Instanceof](#instanceof) (1)

- [Naming](#naming) (6)

- [Php52](#php52) (2)

- [Php53](#php53) (3)

- [Php54](#php54) (3)

- [Php55](#php55) (6)

- [Php56](#php56) (1)

- [Php70](#php70) (19)

- [Php71](#php71) (7)

- [Php72](#php72) (9)

- [Php73](#php73) (9)

- [Php74](#php74) (14)

- [Php80](#php80) (16)

- [Php81](#php81) (8)

- [Php82](#php82) (5)

- [Php83](#php83) (3)

- [Php84](#php84) (1)

- [Privatization](#privatization) (4)

- [Removing](#removing) (5)

- [Renaming](#renaming) (11)

- [Strict](#strict) (5)

- [Transform](#transform) (25)

- [TypeDeclaration](#typedeclaration) (57)

- [Visibility](#visibility) (3)

<br>

## Arguments

### ArgumentAdderRector

This Rector adds new default arguments in calls of defined methods and class types.

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector`](../rules/Arguments/Rector/ClassMethod/ArgumentAdderRector.php)

```diff
 $someObject = new SomeExampleClass;
-$someObject->someMethod();
+$someObject->someMethod(true);

 class MyCustomClass extends SomeExampleClass
 {
-    public function someMethod()
+    public function someMethod($value = true)
     {
     }
 }
```

<br>

### FunctionArgumentDefaultValueReplacerRector

Streamline the operator arguments of version_compare function

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector`](../rules/Arguments/Rector/FuncCall/FunctionArgumentDefaultValueReplacerRector.php)

```diff
-version_compare(PHP_VERSION, '5.6', 'gte');
+version_compare(PHP_VERSION, '5.6', 'ge');
```

<br>

### RemoveMethodCallParamRector

Remove parameter of method call

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\MethodCall\RemoveMethodCallParamRector`](../rules/Arguments/Rector/MethodCall/RemoveMethodCallParamRector.php)

```diff
 final class SomeClass
 {
     public function run(Caller $caller)
     {
-        $caller->process(1, 2);
+        $caller->process(1);
     }
 }
```

<br>

### ReplaceArgumentDefaultValueRector

Replaces defined map of arguments in defined methods and their calls.

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\ClassMethod\ReplaceArgumentDefaultValueRector`](../rules/Arguments/Rector/ClassMethod/ReplaceArgumentDefaultValueRector.php)

```diff
 $someObject = new SomeClass;
-$someObject->someMethod(SomeClass::OLD_CONSTANT);
+$someObject->someMethod(false);
```

<br>

## Carbon

### DateFuncCallToCarbonRector

Convert `date()` function call to `Carbon::now()->format(*)`

- class: [`Rector\Carbon\Rector\FuncCall\DateFuncCallToCarbonRector`](../rules/Carbon/Rector/FuncCall/DateFuncCallToCarbonRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $date = date('Y-m-d');
+        $date = \Carbon\Carbon::now()->format('Y-m-d');
     }
 }
```

<br>

### DateTimeInstanceToCarbonRector

Convert new `DateTime()` to Carbon::*()

- class: [`Rector\Carbon\Rector\New_\DateTimeInstanceToCarbonRector`](../rules/Carbon/Rector/New_/DateTimeInstanceToCarbonRector.php)

```diff
-$date = new \DateTime('today');
+$date = \Carbon\Carbon::today();
```

<br>

### DateTimeMethodCallToCarbonRector

Convert new `DateTime()` with a method call to Carbon::*()

- class: [`Rector\Carbon\Rector\MethodCall\DateTimeMethodCallToCarbonRector`](../rules/Carbon/Rector/MethodCall/DateTimeMethodCallToCarbonRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $date = (new \DateTime('today +20 day'))->format('Y-m-d');
+        $date = \Carbon\Carbon::today()->addDays(20)->format('Y-m-d')
     }
 }
```

<br>

### TimeFuncCallToCarbonRector

Convert `time()` function call to `Carbon::now()->timestamp`

- class: [`Rector\Carbon\Rector\FuncCall\TimeFuncCallToCarbonRector`](../rules/Carbon/Rector/FuncCall/TimeFuncCallToCarbonRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $time = time();
+        $time = \Carbon\Carbon::now()->timestamp;
     }
 }
```

<br>

## CodeQuality

### AbsolutizeRequireAndIncludePathRector

include/require to absolute path. This Rector might introduce backwards incompatible code, when the include/require being changed depends on the current working directory.

- class: [`Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector`](../rules/CodeQuality/Rector/Include_/AbsolutizeRequireAndIncludePathRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        require 'autoload.php';
+        require __DIR__ . '/autoload.php';

         require $variable;
     }
 }
```

<br>

### AndAssignsToSeparateLinesRector

Split 2 assign ands to separate line

- class: [`Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector`](../rules/CodeQuality/Rector/LogicalAnd/AndAssignsToSeparateLinesRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $tokens = [];
-        $token = 4 and $tokens[] = $token;
+        $token = 4;
+        $tokens[] = $token;
     }
 }
```

<br>

### ArrayKeyExistsTernaryThenValueToCoalescingRector

Change `array_key_exists()` ternary to coalescing

- class: [`Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector`](../rules/CodeQuality/Rector/Ternary/ArrayKeyExistsTernaryThenValueToCoalescingRector.php)

```diff
 class SomeClass
 {
     public function run($values, $keyToMatch)
     {
-        $result = array_key_exists($keyToMatch, $values) ? $values[$keyToMatch] : null;
+        $result = $values[$keyToMatch] ?? null;
     }
 }
```

<br>

### ArrayMergeOfNonArraysToSimpleArrayRector

Change array_merge of non arrays to array directly

- class: [`Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector`](../rules/CodeQuality/Rector/FuncCall/ArrayMergeOfNonArraysToSimpleArrayRector.php)

```diff
 class SomeClass
 {
     public function go()
     {
         $value = 5;
         $value2 = 10;

-        return array_merge([$value], [$value2]);
+        return [$value, $value2];
     }
 }
```

<br>

### BooleanNotIdenticalToNotIdenticalRector

Negated identical boolean compare to not identical compare (does not apply to non-bool values)

- class: [`Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector`](../rules/CodeQuality/Rector/Identical/BooleanNotIdenticalToNotIdenticalRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $a = true;
         $b = false;

-        var_dump(! $a === $b); // true
-        var_dump(! ($a === $b)); // true
+        var_dump($a !== $b); // true
+        var_dump($a !== $b); // true
         var_dump($a !== $b); // true
     }
 }
```

<br>

### CallUserFuncWithArrowFunctionToInlineRector

Refactor `call_user_func()` with arrow function to direct call

- class: [`Rector\CodeQuality\Rector\FuncCall\CallUserFuncWithArrowFunctionToInlineRector`](../rules/CodeQuality/Rector/FuncCall/CallUserFuncWithArrowFunctionToInlineRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $result = \call_user_func(fn () => 100);
+        $result = 100;
     }
 }
```

<br>

### ChangeArrayPushToArrayAssignRector

Change `array_push()` to direct variable assign

- class: [`Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector`](../rules/CodeQuality/Rector/FuncCall/ChangeArrayPushToArrayAssignRector.php)

```diff
 $items = [];
-array_push($items, $item);
+$items[] = $item;
```

<br>

### CleanupUnneededNullsafeOperatorRector

Cleanup unneeded nullsafe operator

- class: [`Rector\CodeQuality\Rector\NullsafeMethodCall\CleanupUnneededNullsafeOperatorRector`](../rules/CodeQuality/Rector/NullsafeMethodCall/CleanupUnneededNullsafeOperatorRector.php)

```diff
 class HelloWorld {
     public function getString(): string
     {
          return 'hello world';
     }
 }

 function get(): HelloWorld
 {
      return new HelloWorld();
 }

-echo get()?->getString();
+echo get()->getString();
```

<br>

### CombineIfRector

Merges nested if statements

- class: [`Rector\CodeQuality\Rector\If_\CombineIfRector`](../rules/CodeQuality/Rector/If_/CombineIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if ($cond1) {
-            if ($cond2) {
-                return 'foo';
-            }
+        if ($cond1 && $cond2) {
+            return 'foo';
         }
     }
 }
```

<br>

### CombinedAssignRector

Simplify `$value` = `$value` + 5; assignments to shorter ones

- class: [`Rector\CodeQuality\Rector\Assign\CombinedAssignRector`](../rules/CodeQuality/Rector/Assign/CombinedAssignRector.php)

```diff
-$value = $value + 5;
+$value += 5;
```

<br>

### CommonNotEqualRector

Use common != instead of less known <> with same meaning

- class: [`Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector`](../rules/CodeQuality/Rector/NotEqual/CommonNotEqualRector.php)

```diff
 final class SomeClass
 {
     public function run($one, $two)
     {
-        return $one <> $two;
+        return $one != $two;
     }
 }
```

<br>

### CompactToVariablesRector

Change `compact()` call to own array

- class: [`Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector`](../rules/CodeQuality/Rector/FuncCall/CompactToVariablesRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $checkout = 'one';
         $form = 'two';

-        return compact('checkout', 'form');
+        return ['checkout' => $checkout, 'form' => $form];
     }
 }
```

<br>

### CompleteDynamicPropertiesRector

Add missing dynamic properties

- class: [`Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector`](../rules/CodeQuality/Rector/Class_/CompleteDynamicPropertiesRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var int
+     */
+    public $value;
+
     public function set()
     {
         $this->value = 5;
     }
 }
```

<br>

### CompleteMissingIfElseBracketRector

Complete missing if/else brackets

- class: [`Rector\CodeQuality\Rector\If_\CompleteMissingIfElseBracketRector`](../rules/CodeQuality/Rector/If_/CompleteMissingIfElseBracketRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        if ($value)
+        if ($value) {
             return 1;
+        }
     }
 }
```

<br>

### ConsecutiveNullCompareReturnsToNullCoalesceQueueRector

Change multiple null compares to ?? queue

- class: [`Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector`](../rules/CodeQuality/Rector/If_/ConsecutiveNullCompareReturnsToNullCoalesceQueueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if ($this->orderItem !== null) {
-            return $this->orderItem;
-        }
-
-        if ($this->orderItemUnit !== null) {
-            return $this->orderItemUnit;
-        }
-
-        return null;
+        return $this->orderItem ?? $this->orderItemUnit;
     }
 }
```

<br>

### ConvertStaticPrivateConstantToSelfRector

Replaces static::* access to private constants with self::*

- class: [`Rector\CodeQuality\Rector\ClassConstFetch\ConvertStaticPrivateConstantToSelfRector`](../rules/CodeQuality/Rector/ClassConstFetch/ConvertStaticPrivateConstantToSelfRector.php)

```diff
 final class Foo
 {
     private const BAR = 'bar';

     public function run()
     {
-        $bar = static::BAR;
+        $bar = self::BAR;
     }
 }
```

<br>

### ExplicitBoolCompareRector

Make if conditions more explicit

- class: [`Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector`](../rules/CodeQuality/Rector/If_/ExplicitBoolCompareRector.php)

```diff
 final class SomeController
 {
     public function run($items)
     {
-        if (!count($items)) {
+        if (count($items) === 0) {
             return 'no items';
         }
     }
 }
```

<br>

### ExplicitReturnNullRector

Add explicit return null to method/function that returns a value, but missed main return

- class: [`Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector`](../rules/CodeQuality/Rector/ClassMethod/ExplicitReturnNullRector.php)

```diff
 class SomeClass
 {
     /**
-     * @return string|void
+     * @return string|null
      */
     public function run(int $number)
     {
         if ($number > 50) {
             return 'yes';
         }
+
+        return null;
     }
 }
```

<br>

### FlipTypeControlToUseExclusiveTypeRector

Flip type control from null compare to use exclusive instanceof object

- class: [`Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector`](../rules/CodeQuality/Rector/Identical/FlipTypeControlToUseExclusiveTypeRector.php)

```diff
 function process(?DateTime $dateTime)
 {
-    if ($dateTime === null) {
+    if (! $dateTime instanceof DateTime) {
         return;
     }
 }
```

<br>

### ForRepeatedCountToOwnVariableRector

Change `count()` in for function to own variable

- class: [`Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector`](../rules/CodeQuality/Rector/For_/ForRepeatedCountToOwnVariableRector.php)

```diff
 class SomeClass
 {
     public function run($items)
     {
-        for ($i = 5; $i <= count($items); $i++) {
+        $itemsCount = count($items);
+        for ($i = 5; $i <= $itemsCount; $i++) {
             echo $items[$i];
         }
     }
 }
```

<br>

### ForeachItemsAssignToEmptyArrayToAssignRector

Change `foreach()` items assign to empty array to direct assign

- class: [`Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector`](../rules/CodeQuality/Rector/Foreach_/ForeachItemsAssignToEmptyArrayToAssignRector.php)

```diff
 class SomeClass
 {
     public function run($items)
     {
         $collectedItems = [];

-        foreach ($items as $item) {
-             $collectedItems[] = $item;
-        }
+        $collectedItems = $items;
     }
 }
```

<br>

### ForeachToInArrayRector

Simplify `foreach` loops into `in_array` when possible

- class: [`Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector`](../rules/CodeQuality/Rector/Foreach_/ForeachToInArrayRector.php)

```diff
-foreach ($items as $item) {
-    if ($item === 'something') {
-        return true;
-    }
-}
-
-return false;
+return in_array('something', $items, true);
```

<br>

### InlineArrayReturnAssignRector

Inline just in time array dim fetch assigns to direct return

- class: [`Rector\CodeQuality\Rector\ClassMethod\InlineArrayReturnAssignRector`](../rules/CodeQuality/Rector/ClassMethod/InlineArrayReturnAssignRector.php)

```diff
 function getPerson()
 {
-    $person = [];
-    $person['name'] = 'Timmy';
-    $person['surname'] = 'Back';
-
-    return $person;
+    return [
+        'name' => 'Timmy',
+        'surname' => 'Back',
+    ];
 }
```

<br>

### InlineConstructorDefaultToPropertyRector

Move property default from constructor to property default

- class: [`Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector`](../rules/CodeQuality/Rector/Class_/InlineConstructorDefaultToPropertyRector.php)

```diff
 final class SomeClass
 {
-    private $name;
+    private $name = 'John';

     public function __construct()
     {
-        $this->name = 'John';
     }
 }
```

<br>

### InlineIfToExplicitIfRector

Change inline if to explicit if

- class: [`Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector`](../rules/CodeQuality/Rector/Expression/InlineIfToExplicitIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $userId = null;

-        is_null($userId) && $userId = 5;
+        if (is_null($userId)) {
+            $userId = 5;
+        }
     }
 }
```

<br>

### InlineIsAInstanceOfRector

Change `is_a()` with object and class name check to instanceof

- class: [`Rector\CodeQuality\Rector\FuncCall\InlineIsAInstanceOfRector`](../rules/CodeQuality/Rector/FuncCall/InlineIsAInstanceOfRector.php)

```diff
 class SomeClass
 {
     public function run(object $object)
     {
-        return is_a($object, SomeType::class);
+        return $object instanceof SomeType;
     }
 }
```

<br>

### IsAWithStringWithThirdArgumentRector

Complete missing 3rd argument in case `is_a()` function in case of strings

- class: [`Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector`](../rules/CodeQuality/Rector/FuncCall/IsAWithStringWithThirdArgumentRector.php)

```diff
 class SomeClass
 {
     public function __construct(string $value)
     {
-        return is_a($value, 'stdClass');
+        return is_a($value, 'stdClass', true);
     }
 }
```

<br>

### IssetOnPropertyObjectToPropertyExistsRector

Change isset on property object to `property_exists()` and not null check

- class: [`Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector`](../rules/CodeQuality/Rector/Isset_/IssetOnPropertyObjectToPropertyExistsRector.php)

```diff
 class SomeClass
 {
     private $x;

     public function run(): void
     {
-        isset($this->x);
+        property_exists($this, 'x') && $this->x !== null;
     }
 }
```

<br>

### JoinStringConcatRector

Joins concat of 2 strings, unless the length is too long

- class: [`Rector\CodeQuality\Rector\Concat\JoinStringConcatRector`](../rules/CodeQuality/Rector/Concat/JoinStringConcatRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $name = 'Hi' . ' Tom';
+        $name = 'Hi Tom';
     }
 }
```

<br>

### LocallyCalledStaticMethodToNonStaticRector

Change static method and local-only calls to non-static

- class: [`Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector`](../rules/CodeQuality/Rector/ClassMethod/LocallyCalledStaticMethodToNonStaticRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        self::someStatic();
+        $this->someStatic();
     }

-    private static function someStatic()
+    private function someStatic()
     {
     }
 }
```

<br>

### LogicalToBooleanRector

Change OR, AND to ||, && with more common understanding

- class: [`Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector`](../rules/CodeQuality/Rector/LogicalAnd/LogicalToBooleanRector.php)

```diff
-if ($f = false or true) {
+if (($f = false) || true) {
     return $f;
 }
```

<br>

### NewStaticToNewSelfRector

Change unsafe new `static()` to new `self()`

- class: [`Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector`](../rules/CodeQuality/Rector/New_/NewStaticToNewSelfRector.php)

```diff
 final class SomeClass
 {
     public function build()
     {
-        return new static();
+        return new self();
     }
 }
```

<br>

### NumberCompareToMaxFuncCallRector

Ternary number compare to `max()` call

- class: [`Rector\CodeQuality\Rector\Ternary\NumberCompareToMaxFuncCallRector`](../rules/CodeQuality/Rector/Ternary/NumberCompareToMaxFuncCallRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return $value > 100 ? $value : 100;
+        return max($value, 100);
     }
 }
```

<br>

### OptionalParametersAfterRequiredRector

Move required parameters after optional ones

- class: [`Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector`](../rules/CodeQuality/Rector/ClassMethod/OptionalParametersAfterRequiredRector.php)

```diff
 class SomeObject
 {
-    public function run($optional = 1, $required)
+    public function run($required, $optional = 1)
     {
     }
 }
```

<br>

### RemoveSoleValueSprintfRector

Remove `sprintf()` wrapper if not needed

- class: [`Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector`](../rules/CodeQuality/Rector/FuncCall/RemoveSoleValueSprintfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $welcome = 'hello';
-        $value = sprintf('%s', $welcome);
+        $value = $welcome;
     }
 }
```

<br>

### RemoveUselessIsObjectCheckRector

Remove useless `is_object()` check on combine with instanceof check

- class: [`Rector\CodeQuality\Rector\BooleanAnd\RemoveUselessIsObjectCheckRector`](../rules/CodeQuality/Rector/BooleanAnd/RemoveUselessIsObjectCheckRector.php)

```diff
-is_object($obj) && $obj instanceof DateTime
+$obj instanceof DateTime
```

<br>

### ReplaceMultipleBooleanNotRector

Replace the Double not operator (!!) by type-casting to boolean

- class: [`Rector\CodeQuality\Rector\BooleanNot\ReplaceMultipleBooleanNotRector`](../rules/CodeQuality/Rector/BooleanNot/ReplaceMultipleBooleanNotRector.php)

```diff
-$bool = !!$var;
+$bool = (bool) $var;
```

<br>

### SetTypeToCastRector

Changes `settype()` to (type) where possible

- class: [`Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector`](../rules/CodeQuality/Rector/FuncCall/SetTypeToCastRector.php)

```diff
 class SomeClass
 {
     public function run($foo)
     {
-        settype($foo, 'string');
+        $foo = (string) $foo;

-        return settype($foo, 'integer');
+        return (int) $foo;
     }
 }
```

<br>

### ShortenElseIfRector

Shortens else/if to elseif

- class: [`Rector\CodeQuality\Rector\If_\ShortenElseIfRector`](../rules/CodeQuality/Rector/If_/ShortenElseIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($cond1) {
             return $action1;
-        } else {
-            if ($cond2) {
-                return $action2;
-            }
+        } elseif ($cond2) {
+            return $action2;
         }
     }
 }
```

<br>

### SimplifyArraySearchRector

Simplify array_search to in_array

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector`](../rules/CodeQuality/Rector/Identical/SimplifyArraySearchRector.php)

```diff
-array_search("searching", $array) !== false;
+in_array("searching", $array);
```

<br>

```diff
-array_search("searching", $array, true) !== false;
+in_array("searching", $array, true);
```

<br>

### SimplifyBoolIdenticalTrueRector

Simplify bool value compare to true or false

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector`](../rules/CodeQuality/Rector/Identical/SimplifyBoolIdenticalTrueRector.php)

```diff
 class SomeClass
 {
     public function run(bool $value, string $items)
     {
-         $match = in_array($value, $items, TRUE) === TRUE;
+         $match = in_array($value, $items, TRUE);

-         $match = in_array($value, $items, TRUE) !== FALSE;
+         $match = in_array($value, $items, TRUE);
     }
 }
```

<br>

### SimplifyConditionsRector

Simplify conditions

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector`](../rules/CodeQuality/Rector/Identical/SimplifyConditionsRector.php)

```diff
-if (! ($foo !== 'bar')) {...
+if ($foo === 'bar') {...
```

<br>

### SimplifyDeMorganBinaryRector

Simplify negated conditions with de Morgan theorem

- class: [`Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector`](../rules/CodeQuality/Rector/BooleanNot/SimplifyDeMorganBinaryRector.php)

```diff
 $a = 5;
 $b = 10;
-$result = !($a > 20 || $b <= 50);
+$result = $a <= 20 && $b > 50;
```

<br>

### SimplifyEmptyArrayCheckRector

Simplify `is_array` and `empty` functions combination into a simple identical check for an empty array

- class: [`Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector`](../rules/CodeQuality/Rector/BooleanAnd/SimplifyEmptyArrayCheckRector.php)

```diff
-is_array($values) && empty($values)
+$values === []
```

<br>

### SimplifyEmptyCheckOnEmptyArrayRector

Simplify `empty()` functions calls on empty arrays

- class: [`Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector`](../rules/CodeQuality/Rector/Empty_/SimplifyEmptyCheckOnEmptyArrayRector.php)

```diff
 $array = [];

-if (empty($values)) {
+if ([] === $values) {
 }
```

<br>

### SimplifyForeachToCoalescingRector

Changes foreach that returns set value to ??

- class: [`Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector`](../rules/CodeQuality/Rector/Foreach_/SimplifyForeachToCoalescingRector.php)

```diff
-foreach ($this->oldToNewFunctions as $oldFunction => $newFunction) {
-    if ($currentFunction === $oldFunction) {
-        return $newFunction;
-    }
-}
-
-return null;
+return $this->oldToNewFunctions[$currentFunction] ?? null;
```

<br>

### SimplifyFuncGetArgsCountRector

Simplify count of `func_get_args()` to `func_num_args()`

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyFuncGetArgsCountRector.php)

```diff
-count(func_get_args());
+func_num_args();
```

<br>

### SimplifyIfElseToTernaryRector

Changes if/else for same value as assign to ternary

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector`](../rules/CodeQuality/Rector/If_/SimplifyIfElseToTernaryRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (empty($value)) {
-            $this->arrayBuilt[][$key] = true;
-        } else {
-            $this->arrayBuilt[][$key] = $value;
-        }
+        $this->arrayBuilt[][$key] = empty($value) ? true : $value;
     }
 }
```

<br>

### SimplifyIfNotNullReturnRector

Changes redundant null check to instant return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector`](../rules/CodeQuality/Rector/If_/SimplifyIfNotNullReturnRector.php)

```diff
 $newNode = 'something';
-if ($newNode !== null) {
-    return $newNode;
-}
-
-return null;
+return $newNode;
```

<br>

### SimplifyIfNullableReturnRector

Direct return on if nullable check before return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfNullableReturnRector`](../rules/CodeQuality/Rector/If_/SimplifyIfNullableReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = $this->get();
-        if (! $value instanceof \stdClass) {
-            return null;
-        }
-
-        return $value;
+        return $this->get();
     }

     public function get(): ?stdClass {
     }
 }
```

<br>

### SimplifyIfReturnBoolRector

Shortens if return false/true to direct return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector`](../rules/CodeQuality/Rector/If_/SimplifyIfReturnBoolRector.php)

```diff
-if (strpos($docToken->getContent(), "\n") === false) {
-    return true;
-}
-
-return false;
+return strpos($docToken->getContent(), "\n") === false;
```

<br>

### SimplifyInArrayValuesRector

Removes unneeded `array_values()` in `in_array()` call

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyInArrayValuesRector.php)

```diff
-in_array("key", array_values($array), true);
+in_array("key", $array, true);
```

<br>

### SimplifyRegexPatternRector

Simplify regex pattern to known ranges

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyRegexPatternRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        preg_match('#[a-zA-Z0-9+]#', $value);
+        preg_match('#[\w\d+]#', $value);
     }
 }
```

<br>

### SimplifyStrposLowerRector

Simplify `strpos(strtolower()`, "...") calls

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyStrposLowerRector.php)

```diff
-strpos(strtolower($var), "...")
+stripos($var, "...")
```

<br>

### SimplifyTautologyTernaryRector

Simplify tautology ternary to value

- class: [`Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector`](../rules/CodeQuality/Rector/Ternary/SimplifyTautologyTernaryRector.php)

```diff
-$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;
+$value = $fullyQualifiedTypeHint;
```

<br>

### SimplifyUselessVariableRector

Removes useless variable assigns

:wrench: **configure it!**

- class: [`Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector`](../rules/CodeQuality/Rector/FunctionLike/SimplifyUselessVariableRector.php)

```diff
 function () {
-    $a = true;
-    return $a;
+    return true;
 };
```

<br>

```diff
 function () {
     $a = 'Hello, ';
-    $a .= 'World!';

-    return $a;
+    return $a . 'World!';
 };
```

<br>

### SingleInArrayToCompareRector

Changes `in_array()` with single element to ===

- class: [`Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector`](../rules/CodeQuality/Rector/FuncCall/SingleInArrayToCompareRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (in_array(strtolower($type), ['$this'], true)) {
+        if (strtolower($type) === '$this') {
             return strtolower($type);
         }
     }
 }
```

<br>

### SingularSwitchToIfRector

Change switch with only 1 check to if

- class: [`Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector`](../rules/CodeQuality/Rector/Switch_/SingularSwitchToIfRector.php)

```diff
 class SomeObject
 {
     public function run($value)
     {
         $result = 1;
-        switch ($value) {
-            case 100:
+        if ($value === 100) {
             $result = 1000;
         }

         return $result;
     }
 }
```

<br>

### StaticToSelfStaticMethodCallOnFinalClassRector

Change `static::methodCall()` to `self::methodCall()` on final class

- class: [`Rector\CodeQuality\Rector\Class_\StaticToSelfStaticMethodCallOnFinalClassRector`](../rules/CodeQuality/Rector/Class_/StaticToSelfStaticMethodCallOnFinalClassRector.php)

```diff
 final class SomeClass
 {
     public function d()
     {
-        echo static::run();
+        echo self::run();
     }

     private static function run()
     {
         echo 'test';
     }
 }
```

<br>

### StrlenZeroToIdenticalEmptyStringRector

Changes strlen comparison to 0 to direct empty string compare

- class: [`Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector`](../rules/CodeQuality/Rector/Identical/StrlenZeroToIdenticalEmptyStringRector.php)

```diff
 class SomeClass
 {
     public function run(string $value)
     {
-        $empty = strlen($value) === 0;
+        $empty = $value === '';
     }
 }
```

<br>

### SwitchNegatedTernaryRector

Switch negated ternary condition rector

- class: [`Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector`](../rules/CodeQuality/Rector/Ternary/SwitchNegatedTernaryRector.php)

```diff
 class SomeClass
 {
     public function run(bool $upper, string $name)
     {
-        return ! $upper
-            ? $name
-            : strtoupper($name);
+        return $upper
+            ? strtoupper($name)
+            : $name;
     }
 }
```

<br>

### SwitchTrueToIfRector

Change switch (true) to if statements

- class: [`Rector\CodeQuality\Rector\Switch_\SwitchTrueToIfRector`](../rules/CodeQuality/Rector/Switch_/SwitchTrueToIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        switch (true) {
-            case $value === 0:
-                return 'no';
-            case $value === 1:
-                return 'yes';
-            case $value === 2:
-                return 'maybe';
-        };
+        if ($value === 0) {
+            return 'no';
+        }
+
+        if ($value === 1) {
+            return 'yes';
+        }
+
+        if ($value === 2) {
+            return 'maybe';
+        }
     }
 }
```

<br>

### TernaryEmptyArrayArrayDimFetchToCoalesceRector

Change ternary empty on array property with array dim fetch to coalesce operator

- class: [`Rector\CodeQuality\Rector\Ternary\TernaryEmptyArrayArrayDimFetchToCoalesceRector`](../rules/CodeQuality/Rector/Ternary/TernaryEmptyArrayArrayDimFetchToCoalesceRector.php)

```diff
 final class SomeClass
 {
     private array $items = [];

     public function run()
     {
-        return ! empty($this->items) ? $this->items[0] : 'default';
+        return $this->items[0] ?? 'default';
     }
 }
```

<br>

### TernaryFalseExpressionToIfRector

Change ternary with false to if and explicit call

- class: [`Rector\CodeQuality\Rector\Expression\TernaryFalseExpressionToIfRector`](../rules/CodeQuality/Rector/Expression/TernaryFalseExpressionToIfRector.php)

```diff
 final class SomeClass
 {
     public function run($value, $someMethod)
     {
-        $value ? $someMethod->call($value) : false;
+        if ($value) {
+            $someMethod->call($value);
+        }
     }
 }
```

<br>

### ThrowWithPreviousExceptionRector

When throwing into a catch block, checks that the previous exception is passed to the new throw clause

- class: [`Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector`](../rules/CodeQuality/Rector/Catch_/ThrowWithPreviousExceptionRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         try {
             $someCode = 1;
         } catch (Throwable $throwable) {
-            throw new AnotherException('ups');
+            throw new AnotherException('ups', $throwable->getCode(), $throwable);
         }
     }
 }
```

<br>

### UnnecessaryTernaryExpressionRector

Remove unnecessary ternary expressions

- class: [`Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector`](../rules/CodeQuality/Rector/Ternary/UnnecessaryTernaryExpressionRector.php)

```diff
-$foo === $bar ? true : false;
+$foo === $bar;
```

<br>

### UnusedForeachValueToArrayKeysRector

Change foreach with unused `$value` but only `$key,` to `array_keys()`

- class: [`Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector`](../rules/CodeQuality/Rector/Foreach_/UnusedForeachValueToArrayKeysRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $items = [];
-        foreach ($values as $key => $value) {
+        foreach (array_keys($values) as $key) {
             $items[$key] = null;
         }
     }
 }
```

<br>

### UnwrapSprintfOneArgumentRector

unwrap `sprintf()` with one argument

- class: [`Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector`](../rules/CodeQuality/Rector/FuncCall/UnwrapSprintfOneArgumentRector.php)

```diff
-echo sprintf('value');
+echo 'value';
```

<br>

### UseIdenticalOverEqualWithSameTypeRector

Use ===/!== over ==/!=, it values have the same type

- class: [`Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector`](../rules/CodeQuality/Rector/Equal/UseIdenticalOverEqualWithSameTypeRector.php)

```diff
 class SomeClass
 {
     public function run(int $firstValue, int $secondValue)
     {
-         $isSame = $firstValue == $secondValue;
-         $isDifferent = $firstValue != $secondValue;
+         $isSame = $firstValue === $secondValue;
+         $isDifferent = $firstValue !== $secondValue;
     }
 }
```

<br>

## CodingStyle

### ArraySpreadInsteadOfArrayMergeRector

Change `array_merge()` to spread operator

- class: [`Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector`](../rules/CodingStyle/Rector/FuncCall/ArraySpreadInsteadOfArrayMergeRector.php)

```diff
 class SomeClass
 {
     public function run($iter1, $iter2)
     {
-        $values = array_merge(iterator_to_array($iter1), iterator_to_array($iter2));
+        $values = [...$iter1, ...$iter2];

         // Or to generalize to all iterables
-        $anotherValues = array_merge(
-            is_array($iter1) ? $iter1 : iterator_to_array($iter1),
-            is_array($iter2) ? $iter2 : iterator_to_array($iter2)
-        );
+        $anotherValues = [...$iter1, ...$iter2];
     }
 }
```

<br>

### CallUserFuncArrayToVariadicRector

Replace `call_user_func_array()` with variadic

- class: [`Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector`](../rules/CodingStyle/Rector/FuncCall/CallUserFuncArrayToVariadicRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        call_user_func_array('some_function', $items);
+        some_function(...$items);
     }
 }
```

<br>

### CallUserFuncToMethodCallRector

Refactor `call_user_func()` on known class method to a method call

- class: [`Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector`](../rules/CodingStyle/Rector/FuncCall/CallUserFuncToMethodCallRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $result = \call_user_func([$this->property, 'method'], $args);
+        $result = $this->property->method($args);
     }
 }
```

<br>

### CatchExceptionNameMatchingTypeRector

Type and name of catch exception should match

- class: [`Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector`](../rules/CodingStyle/Rector/Catch_/CatchExceptionNameMatchingTypeRector.php)

```diff
 try {
     // ...
-} catch (SomeException $typoException) {
-    $typoException->getMessage();
+} catch (SomeException $someException) {
+    $someException->getMessage();
 }
```

<br>

### ConsistentImplodeRector

Changes various implode forms to consistent one

- class: [`Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector`](../rules/CodingStyle/Rector/FuncCall/ConsistentImplodeRector.php)

```diff
 class SomeClass
 {
     public function run(array $items)
     {
-        $itemsAsStrings = implode($items);
-        $itemsAsStrings = implode($items, '|');
+        $itemsAsStrings = implode('', $items);
+        $itemsAsStrings = implode('|', $items);
     }
 }
```

<br>

### CountArrayToEmptyArrayComparisonRector

Change count array comparison to empty array comparison to improve performance

- class: [`Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector`](../rules/CodingStyle/Rector/FuncCall/CountArrayToEmptyArrayComparisonRector.php)

```diff
-count($array) === 0;
-count($array) > 0;
-! count($array);
+$array === [];
+$array !== [];
+$array === [];
```

<br>

### EncapsedStringsToSprintfRector

Convert enscaped {$string} to more readable sprintf or concat, if no mask is used

:wrench: **configure it!**

- class: [`Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector`](../rules/CodingStyle/Rector/Encapsed/EncapsedStringsToSprintfRector.php)

```diff
-echo "Unsupported format {$format} - use another";
+echo sprintf('Unsupported format %s - use another', $format);

-echo "Try {$allowed}";
+echo 'Try ' . $allowed;
```

<br>

```diff
-echo "Unsupported format {$format} - use another";
+echo sprintf('Unsupported format %s - use another', $format);

-echo "Try {$allowed}";
+echo sprintf('Try %s', $allowed);
```

<br>

### FuncGetArgsToVariadicParamRector

Refactor `func_get_args()` in to a variadic param

- class: [`Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector`](../rules/CodingStyle/Rector/ClassMethod/FuncGetArgsToVariadicParamRector.php)

```diff
-function run()
+function run(...$args)
 {
-    $args = \func_get_args();
 }
```

<br>

### FunctionFirstClassCallableRector

Upgrade string callback functions to first class callable

- class: [`Rector\CodingStyle\Rector\FuncCall\FunctionFirstClassCallableRector`](../rules/CodingStyle/Rector/FuncCall/FunctionFirstClassCallableRector.php)

```diff
 final class SomeClass
 {
     public function run(array $data)
     {
-        return array_map('trim', $data);
+        return array_map(trim(...), $data);
     }
 }
```

<br>

### MakeInheritedMethodVisibilitySameAsParentRector

Make method visibility same as parent one

- class: [`Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector`](../rules/CodingStyle/Rector/ClassMethod/MakeInheritedMethodVisibilitySameAsParentRector.php)

```diff
 class ChildClass extends ParentClass
 {
-    public function run()
+    protected function run()
     {
     }
 }

 class ParentClass
 {
     protected function run()
     {
     }
 }
```

<br>

### MultiDimensionalArrayToArrayDestructRector

Change multidimensional array access in foreach to array destruct

- class: [`Rector\CodingStyle\Rector\Foreach_\MultiDimensionalArrayToArrayDestructRector`](../rules/CodingStyle/Rector/Foreach_/MultiDimensionalArrayToArrayDestructRector.php)

```diff
 class SomeClass
 {
     /**
      * @param array<int, array{id: int, name: string}> $users
      */
     public function run(array $users)
     {
-        foreach ($users as $user) {
-            echo $user['id'];
-            echo sprintf('Name: %s', $user['name']);
+        foreach ($users as ['id' => $id, 'name' => $name]) {
+            echo $id;
+            echo sprintf('Name: %s', $name);
         }
     }
 }
```

<br>

### NewlineAfterStatementRector

Add new line after statements to tidify code

- class: [`Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector`](../rules/CodingStyle/Rector/Stmt/NewlineAfterStatementRector.php)

```diff
 class SomeClass
 {
     public function first()
     {
     }
+
     public function second()
     {
     }
 }
```

<br>

### NewlineBeforeNewAssignSetRector

Add extra space before new assign set

- class: [`Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector`](../rules/CodingStyle/Rector/ClassMethod/NewlineBeforeNewAssignSetRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
         $value = new Value;
         $value->setValue(5);
+
         $value2 = new Value;
         $value2->setValue(1);
     }
 }
```

<br>

### NullableCompareToNullRector

Changes negate of empty comparison of nullable value to explicit === or !== compare

- class: [`Rector\CodingStyle\Rector\If_\NullableCompareToNullRector`](../rules/CodingStyle/Rector/If_/NullableCompareToNullRector.php)

```diff
 /** @var stdClass|null $value */
-if ($value) {
+if ($value !== null) {
 }

-if (!$value) {
+if ($value === null) {
 }
```

<br>

### PostIncDecToPreIncDecRector

Use ++$value or --$value  instead of `$value++` or `$value--`

- class: [`Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector`](../rules/CodingStyle/Rector/PostInc/PostIncDecToPreIncDecRector.php)

```diff
 class SomeClass
 {
     public function run($value = 1)
     {
-        $value++; echo $value;
-        $value--; echo $value;
+        ++$value; echo $value;
+        --$value; echo $value;
     }
 }
```

<br>

### RemoveFinalFromConstRector

Remove final from constants in classes defined as final

- class: [`Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector`](../rules/CodingStyle/Rector/ClassConst/RemoveFinalFromConstRector.php)

```diff
 final class SomeClass
 {
-    final public const NAME = 'value';
+    public const NAME = 'value';
 }
```

<br>

### RemoveUselessAliasInUseStatementRector

Remove useless alias in use statement as same name with last use statement name

- class: [`Rector\CodingStyle\Rector\Stmt\RemoveUselessAliasInUseStatementRector`](../rules/CodingStyle/Rector/Stmt/RemoveUselessAliasInUseStatementRector.php)

```diff
-use App\Bar as Bar;
+use App\Bar;
```

<br>

### SeparateMultiUseImportsRector

Split multi use imports and trait statements to standalone lines

- class: [`Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector`](../rules/CodingStyle/Rector/Use_/SeparateMultiUseImportsRector.php)

```diff
-use A, B;
+use A;
+use B;

 class SomeClass
 {
-    use SomeTrait, AnotherTrait;
+    use SomeTrait;
+    use AnotherTrait;
 }
```

<br>

### SplitDoubleAssignRector

Split multiple inline assigns to each own lines default value, to prevent undefined array issues

- class: [`Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector`](../rules/CodingStyle/Rector/Assign/SplitDoubleAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $one = $two = 1;
+        $one = 1;
+        $two = 1;
     }
 }
```

<br>

### SplitGroupedClassConstantsRector

Separate class constant to own lines

- class: [`Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector`](../rules/CodingStyle/Rector/ClassConst/SplitGroupedClassConstantsRector.php)

```diff
 class SomeClass
 {
-    const HI = true, HELLO = 'true';
+    const HI = true;
+    const HELLO = 'true';
 }
```

<br>

### SplitGroupedPropertiesRector

Separate grouped properties to own lines

- class: [`Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector`](../rules/CodingStyle/Rector/Property/SplitGroupedPropertiesRector.php)

```diff
 class SomeClass
 {
     /**
      * @var string
      */
-    public $isIt, $isIsThough;
+    public $isIt;
+
+    /**
+     * @var string
+     */
+    public $isIsThough;
 }
```

<br>

### StaticArrowFunctionRector

Changes ArrowFunction to be static when possible

- class: [`Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector`](../rules/CodingStyle/Rector/ArrowFunction/StaticArrowFunctionRector.php)

```diff
-fn (): string => 'test';
+static fn (): string => 'test';
```

<br>

### StaticClosureRector

Changes Closure to be static when possible

- class: [`Rector\CodingStyle\Rector\Closure\StaticClosureRector`](../rules/CodingStyle/Rector/Closure/StaticClosureRector.php)

```diff
-function () {
+static function () {
     if (rand(0, 1)) {
         return 1;
     }

     return 2;
 }
```

<br>

### StrictArraySearchRector

Makes array_search search for identical elements

- class: [`Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector`](../rules/CodingStyle/Rector/FuncCall/StrictArraySearchRector.php)

```diff
-array_search($value, $items);
+array_search($value, $items, true);
```

<br>

### SymplifyQuoteEscapeRector

Prefer quote that are not inside the string

- class: [`Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector`](../rules/CodingStyle/Rector/String_/SymplifyQuoteEscapeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-         $name = "\" Tom";
-         $name = '\' Sara';
+         $name = '" Tom';
+         $name = "' Sara";
     }
 }
```

<br>

### TernaryConditionVariableAssignmentRector

Assign outcome of ternary condition to variable, where applicable

- class: [`Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector`](../rules/CodingStyle/Rector/Ternary/TernaryConditionVariableAssignmentRector.php)

```diff
 function ternary($value)
 {
-    $value ? $a = 1 : $a = 0;
+    $a = $value ? 1 : 0;
 }
```

<br>

### UseClassKeywordForClassNameResolutionRector

Use `class` keyword for class name resolution in string instead of hardcoded string reference

- class: [`Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector`](../rules/CodingStyle/Rector/String_/UseClassKeywordForClassNameResolutionRector.php)

```diff
-$value = 'App\SomeClass::someMethod()';
+$value = \App\SomeClass::class . '::someMethod()';
```

<br>

### VersionCompareFuncCallToConstantRector

Changes use of call to version compare function to use of PHP version constant

- class: [`Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector`](../rules/CodingStyle/Rector/FuncCall/VersionCompareFuncCallToConstantRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        version_compare(PHP_VERSION, '5.3.0', '<');
+        PHP_VERSION_ID < 50300;
     }
 }
```

<br>

### WrapEncapsedVariableInCurlyBracesRector

Wrap encapsed variables in curly braces

- class: [`Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector`](../rules/CodingStyle/Rector/Encapsed/WrapEncapsedVariableInCurlyBracesRector.php)

```diff
 function run($world)
 {
-    echo "Hello $world!";
+    echo "Hello {$world}!";
 }
```

<br>

## DeadCode

### RecastingRemovalRector

Removes recasting of the same type

- class: [`Rector\DeadCode\Rector\Cast\RecastingRemovalRector`](../rules/DeadCode/Rector/Cast/RecastingRemovalRector.php)

```diff
 $string = '';
-$string = (string) $string;
+$string = $string;

 $array = [];
-$array = (array) $array;
+$array = $array;
```

<br>

### ReduceAlwaysFalseIfOrRector

Reduce always false in a if ( || ) condition

- class: [`Rector\DeadCode\Rector\If_\ReduceAlwaysFalseIfOrRector`](../rules/DeadCode/Rector/If_/ReduceAlwaysFalseIfOrRector.php)

```diff
 class SomeClass
 {
     public function run(int $number)
     {
-        if (! is_int($number) || $number > 50) {
+        if ($number > 50) {
             return 'yes';
         }

         return 'no';
     }
 }
```

<br>

### RemoveAlwaysTrueIfConditionRector

Remove if condition that is always true

- class: [`Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector`](../rules/DeadCode/Rector/If_/RemoveAlwaysTrueIfConditionRector.php)

```diff
 final class SomeClass
 {
     public function go()
     {
-        if (1 === 1) {
-            return 'yes';
-        }
+        return 'yes';

         return 'no';
     }
 }
```

<br>

### RemoveAndTrueRector

Remove and true that has no added value

- class: [`Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector`](../rules/DeadCode/Rector/BooleanAnd/RemoveAndTrueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return true && 5 === 1;
+        return 5 === 1;
     }
 }
```

<br>

### RemoveAnnotationRector

Remove annotation by names

:wrench: **configure it!**

- class: [`Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector`](../rules/DeadCode/Rector/ClassLike/RemoveAnnotationRector.php)

```diff
-/**
- * @method getName()
- */
 final class SomeClass
 {
 }
```

<br>

### RemoveConcatAutocastRector

Remove (string) casting when it comes to concat, that does this by default

- class: [`Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector`](../rules/DeadCode/Rector/Concat/RemoveConcatAutocastRector.php)

```diff
 class SomeConcatenatingClass
 {
     public function run($value)
     {
-        return 'hi ' . (string) $value;
+        return 'hi ' . $value;
     }
 }
```

<br>

### RemoveDeadConditionAboveReturnRector

Remove dead condition above return

- class: [`Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector`](../rules/DeadCode/Rector/Return_/RemoveDeadConditionAboveReturnRector.php)

```diff
 final class SomeClass
 {
     public function go()
     {
-        if (1 === 1) {
-            return 'yes';
-        }
-
         return 'yes';
     }
 }
```

<br>

### RemoveDeadContinueRector

Remove useless continue at the end of loops

- class: [`Rector\DeadCode\Rector\For_\RemoveDeadContinueRector`](../rules/DeadCode/Rector/For_/RemoveDeadContinueRector.php)

```diff
 while ($i < 10) {
     ++$i;
-    continue;
 }
```

<br>

### RemoveDeadIfForeachForRector

Remove if, foreach and for that does not do anything

- class: [`Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector`](../rules/DeadCode/Rector/For_/RemoveDeadIfForeachForRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        if ($value) {
-        }
-
-        foreach ($values as $value) {
-        }
-
         return $value;
     }
 }
```

<br>

### RemoveDeadInstanceOfRector

Remove dead instanceof check on type hinted variable

- class: [`Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector`](../rules/DeadCode/Rector/If_/RemoveDeadInstanceOfRector.php)

```diff
 function run(stdClass $stdClass)
 {
-    if (! $stdClass instanceof stdClass) {
-        return false;
-    }
-
     return true;
 }
```

<br>

### RemoveDeadLoopRector

Remove loop with no body

- class: [`Rector\DeadCode\Rector\For_\RemoveDeadLoopRector`](../rules/DeadCode/Rector/For_/RemoveDeadLoopRector.php)

```diff
 class SomeClass
 {
     public function run($values)
     {
-        for ($i=1; $i<count($values); ++$i) {
-        }
     }
 }
```

<br>

### RemoveDeadReturnRector

Remove last return in the functions, since does not do anything

- class: [`Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector`](../rules/DeadCode/Rector/FunctionLike/RemoveDeadReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $shallWeDoThis = true;

         if ($shallWeDoThis) {
             return;
         }
-
-        return;
     }
 }
```

<br>

### RemoveDeadStmtRector

Removes dead code statements

- class: [`Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector`](../rules/DeadCode/Rector/Expression/RemoveDeadStmtRector.php)

```diff
-$value = 5;
-$value;
+$value = 5;
```

<br>

### RemoveDeadTryCatchRector

Remove dead try/catch

- class: [`Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector`](../rules/DeadCode/Rector/TryCatch/RemoveDeadTryCatchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        try {
-            // some code
-        }
-        catch (Throwable $throwable) {
-            throw $throwable;
-        }
     }
 }
```

<br>

### RemoveDeadZeroAndOneOperationRector

Remove operation with 1 and 0, that have no effect on the value

- class: [`Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector`](../rules/DeadCode/Rector/Plus/RemoveDeadZeroAndOneOperationRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5 * 1;
-        $value = 5 + 0;
+        $value = 5;
+        $value = 5;
     }
 }
```

<br>

### RemoveDoubleAssignRector

Simplify useless double assigns

- class: [`Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector`](../rules/DeadCode/Rector/Assign/RemoveDoubleAssignRector.php)

```diff
-$value = 1;
 $value = 1;
```

<br>

### RemoveDuplicatedArrayKeyRector

Remove duplicated key in defined arrays.

- class: [`Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector`](../rules/DeadCode/Rector/Array_/RemoveDuplicatedArrayKeyRector.php)

```diff
 $item = [
-    1 => 'A',
     1 => 'B'
 ];
```

<br>

### RemoveDuplicatedCaseInSwitchRector

2 following switch keys with identical  will be reduced to one result

- class: [`Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector`](../rules/DeadCode/Rector/Switch_/RemoveDuplicatedCaseInSwitchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         switch ($name) {
              case 'clearHeader':
                  return $this->modifyHeader($node, 'remove');
              case 'clearAllHeaders':
-                 return $this->modifyHeader($node, 'replace');
              case 'clearRawHeaders':
                  return $this->modifyHeader($node, 'replace');
              case '...':
                  return 5;
         }
     }
 }
```

<br>

### RemoveEmptyClassMethodRector

Remove empty class methods not required by parents

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector`](../rules/DeadCode/Rector/ClassMethod/RemoveEmptyClassMethodRector.php)

```diff
 class OrphanClass
 {
-    public function __construct()
-    {
-    }
 }
```

<br>

### RemoveNonExistingVarAnnotationRector

Removes non-existing `@var` annotations above the code

- class: [`Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector`](../rules/DeadCode/Rector/Node/RemoveNonExistingVarAnnotationRector.php)

```diff
 class SomeClass
 {
     public function get()
     {
-        /** @var Training[] $trainings */
         return $this->getData();
     }
 }
```

<br>

### RemoveNullPropertyInitializationRector

Remove initialization with null value from property declarations

- class: [`Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector`](../rules/DeadCode/Rector/PropertyProperty/RemoveNullPropertyInitializationRector.php)

```diff
 class SunshineCommand extends ParentClassWithNewConstructor
 {
-    private $myVar = null;
+    private $myVar;
 }
```

<br>

### RemoveNullTagValueNodeRector

Remove `@var/@param/@return` null docblock

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveNullTagValueNodeRector`](../rules/DeadCode/Rector/ClassMethod/RemoveNullTagValueNodeRector.php)

```diff
 class SomeClass
 {
-    /**
-     * @return null
-     */
     public function foo()
     {
         return null;
     }
 }
```

<br>

### RemoveParentCallWithoutParentRector

Remove unused parent call with no parent class

- class: [`Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector`](../rules/DeadCode/Rector/StaticCall/RemoveParentCallWithoutParentRector.php)

```diff
 class OrphanClass
 {
     public function __construct()
     {
-         parent::__construct();
     }
 }
```

<br>

### RemovePhpVersionIdCheckRector

Remove unneeded PHP_VERSION_ID conditional checks

- class: [`Rector\DeadCode\Rector\ConstFetch\RemovePhpVersionIdCheckRector`](../rules/DeadCode/Rector/ConstFetch/RemovePhpVersionIdCheckRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (PHP_VERSION_ID < 80000) {
-            return;
-        }
-
         echo 'do something';
     }
 }
```

<br>

### RemoveTypedPropertyDeadInstanceOfRector

Remove dead instanceof check on type hinted property

- class: [`Rector\DeadCode\Rector\If_\RemoveTypedPropertyDeadInstanceOfRector`](../rules/DeadCode/Rector/If_/RemoveTypedPropertyDeadInstanceOfRector.php)

```diff
 final class SomeClass
 {
     private $someObject;

     public function __construct(SomeObject $someObject)
     {
         $this->someObject = $someObject;
     }

     public function run()
     {
-        if ($this->someObject instanceof SomeObject) {
-            return true;
-        }
-
-        return false;
+        return true;
     }
 }
```

<br>

### RemoveUnreachableStatementRector

Remove unreachable statements

- class: [`Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector`](../rules/DeadCode/Rector/Stmt/RemoveUnreachableStatementRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         return 5;
-
-        $removeMe = 10;
     }
 }
```

<br>

### RemoveUnusedConstructorParamRector

Remove unused parameter in constructor

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedConstructorParamRector.php)

```diff
 final class SomeClass
 {
     private $hey;

-    public function __construct($hey, $man)
+    public function __construct($hey)
     {
         $this->hey = $hey;
     }
 }
```

<br>

### RemoveUnusedForeachKeyRector

Remove unused key in foreach

- class: [`Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector`](../rules/DeadCode/Rector/Foreach_/RemoveUnusedForeachKeyRector.php)

```diff
 $items = [];
-foreach ($items as $key => $value) {
+foreach ($items as $value) {
     $result = $value;
 }
```

<br>

### RemoveUnusedNonEmptyArrayBeforeForeachRector

Remove unused if check to non-empty array before foreach of the array

- class: [`Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector`](../rules/DeadCode/Rector/If_/RemoveUnusedNonEmptyArrayBeforeForeachRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $values = [];
-        if ($values !== []) {
-            foreach ($values as $value) {
-                echo $value;
-            }
+        foreach ($values as $value) {
+            echo $value;
         }
     }
 }
```

<br>

### RemoveUnusedPrivateClassConstantRector

Remove unused class constants

- class: [`Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector`](../rules/DeadCode/Rector/ClassConst/RemoveUnusedPrivateClassConstantRector.php)

```diff
 class SomeClass
 {
-    private const SOME_CONST = 'dead';
-
     public function run()
     {
     }
 }
```

<br>

### RemoveUnusedPrivateMethodParameterRector

Remove unused parameter, if not required by interface or parent class

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPrivateMethodParameterRector.php)

```diff
 class SomeClass
 {
-    private function run($value, $value2)
+    private function run($value)
     {
          $this->value = $value;
     }
 }
```

<br>

### RemoveUnusedPrivateMethodRector

Remove unused private method

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPrivateMethodRector.php)

```diff
 final class SomeController
 {
     public function run()
     {
         return 5;
     }
-
-    private function skip()
-    {
-        return 10;
-    }
 }
```

<br>

### RemoveUnusedPrivatePropertyRector

Remove unused private properties

- class: [`Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector`](../rules/DeadCode/Rector/Property/RemoveUnusedPrivatePropertyRector.php)

```diff
 class SomeClass
 {
-    private $property;
 }
```

<br>

### RemoveUnusedPromotedPropertyRector

Remove unused promoted property

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPromotedPropertyRector.php)

```diff
 class SomeClass
 {
     public function __construct(
-        private $someUnusedDependency,
         private $usedDependency
     ) {
     }

     public function getUsedDependency()
     {
         return $this->usedDependency;
     }
 }
```

<br>

### RemoveUnusedPublicMethodParameterRector

Remove unused parameter in public method on final class without extends and interface

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPublicMethodParameterRector.php)

```diff
 final class SomeClass
 {
-    public function run($a, $b)
+    public function run($a)
     {
         echo $a;
     }
 }
```

<br>

### RemoveUnusedVariableAssignRector

Remove unused assigns to variables

- class: [`Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector`](../rules/DeadCode/Rector/Assign/RemoveUnusedVariableAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5;
     }
 }
```

<br>

### RemoveUselessParamTagRector

Remove `@param` docblock with same type as parameter type

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUselessParamTagRector.php)

```diff
 class SomeClass
 {
     /**
-     * @param string $a
      * @param string $b description
      */
     public function foo(string $a, string $b)
     {
     }
 }
```

<br>

### RemoveUselessReadOnlyTagRector

Remove useless `@readonly` annotation on native readonly type

- class: [`Rector\DeadCode\Rector\Property\RemoveUselessReadOnlyTagRector`](../rules/DeadCode/Rector/Property/RemoveUselessReadOnlyTagRector.php)

```diff
 final class SomeClass
 {
-    /**
-     * @readonly
-     */
     private readonly string $name;

     public function __construct(string $name)
     {
         $this->name = $name;
     }
 }
```

<br>

### RemoveUselessReturnExprInConstructRector

Remove useless return Expr in `__construct()`

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnExprInConstructRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUselessReturnExprInConstructRector.php)

```diff
 class SomeClass
 {
     public function __construct()
     {
         if (rand(0, 1)) {
             $this->init();
-            return true;
+            return;
         }

         if (rand(2, 3)) {
-            return parent::construct();
+            parent::construct();
+            return;
         }

         $this->execute();
     }
 }
```

<br>

### RemoveUselessReturnTagRector

Remove `@return` docblock with same type as defined in PHP

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUselessReturnTagRector.php)

```diff
 use stdClass;

 class SomeClass
 {
-    /**
-     * @return stdClass
-     */
     public function foo(): stdClass
     {
     }
 }
```

<br>

### RemoveUselessVarTagRector

Remove unused `@var` annotation for properties

- class: [`Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector`](../rules/DeadCode/Rector/Property/RemoveUselessVarTagRector.php)

```diff
 final class SomeClass
 {
-    /**
-     * @var string
-     */
     public string $name = 'name';
 }
```

<br>

### SimplifyIfElseWithSameContentRector

Remove if/else if they have same content

- class: [`Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector`](../rules/DeadCode/Rector/If_/SimplifyIfElseWithSameContentRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (true) {
-            return 1;
-        } else {
-            return 1;
-        }
+        return 1;
     }
 }
```

<br>

### SimplifyMirrorAssignRector

Removes unneeded `$value` = `$value` assigns

- class: [`Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector`](../rules/DeadCode/Rector/Expression/SimplifyMirrorAssignRector.php)

```diff
 function run() {
-    $result = $result;
 }
```

<br>

### TernaryToBooleanOrFalseToBooleanAndRector

Change ternary of bool : false to && bool

- class: [`Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector`](../rules/DeadCode/Rector/Ternary/TernaryToBooleanOrFalseToBooleanAndRector.php)

```diff
 class SomeClass
 {
     public function go()
     {
-        return $value ? $this->getBool() : false;
+        return $value && $this->getBool();
     }

     private function getBool(): bool
     {
         return (bool) 5;
     }
 }
```

<br>

### UnwrapFutureCompatibleIfPhpVersionRector

Remove php version checks if they are passed

- class: [`Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector`](../rules/DeadCode/Rector/If_/UnwrapFutureCompatibleIfPhpVersionRector.php)

```diff
 // current PHP: 7.2
-if (version_compare(PHP_VERSION, '7.2', '<')) {
-    return 'is PHP 7.1-';
-} else {
-    return 'is PHP 7.2+';
-}
+return 'is PHP 7.2+';
```

<br>

## EarlyReturn

### ChangeIfElseValueAssignToEarlyReturnRector

Change if/else value to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeIfElseValueAssignToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($this->hasDocBlock($tokens, $index)) {
-            $docToken = $tokens[$this->getDocBlockIndex($tokens, $index)];
-        } else {
-            $docToken = null;
+            return $tokens[$this->getDocBlockIndex($tokens, $index)];
         }
-
-        return $docToken;
+        return null;
     }
 }
```

<br>

### ChangeNestedForeachIfsToEarlyContinueRector

Change nested ifs to foreach with continue

- class: [`Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector`](../rules/EarlyReturn/Rector/Foreach_/ChangeNestedForeachIfsToEarlyContinueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $items = [];

         foreach ($values as $value) {
-            if ($value === 5) {
-                if ($value2 === 10) {
-                    $items[] = 'maybe';
-                }
+            if ($value !== 5) {
+                continue;
             }
+            if ($value2 !== 10) {
+                continue;
+            }
+
+            $items[] = 'maybe';
         }
     }
 }
```

<br>

### ChangeNestedIfsToEarlyReturnRector

Change nested ifs to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeNestedIfsToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if ($value === 5) {
-            if ($value2 === 10) {
-                return 'yes';
-            }
+        if ($value !== 5) {
+            return 'no';
+        }
+
+        if ($value2 === 10) {
+            return 'yes';
         }

         return 'no';
     }
 }
```

<br>

### ChangeOrIfContinueToMultiContinueRector

Changes if || to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector`](../rules/EarlyReturn/Rector/If_/ChangeOrIfContinueToMultiContinueRector.php)

```diff
 class SomeClass
 {
     public function canDrive(Car $newCar)
     {
         foreach ($cars as $car) {
-            if ($car->hasWheels() || $car->hasFuel()) {
+            if ($car->hasWheels()) {
+                continue;
+            }
+            if ($car->hasFuel()) {
                 continue;
             }

             $car->setWheel($newCar->wheel);
             $car->setFuel($newCar->fuel);
         }
     }
 }
```

<br>

### PreparedValueToEarlyReturnRector

Return early prepared value in ifs

- class: [`Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector`](../rules/EarlyReturn/Rector/Return_/PreparedValueToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $var = null;
-
         if (rand(0, 1)) {
-            $var = 1;
+            return 1;
         }

         if (rand(0, 1)) {
-            $var = 2;
+            return 2;
         }

-        return $var;
+        return null;
     }
 }
```

<br>

### RemoveAlwaysElseRector

Split if statement, when if condition always break execution flow

- class: [`Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector`](../rules/EarlyReturn/Rector/If_/RemoveAlwaysElseRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
         if ($value) {
             throw new \InvalidStateException;
-        } else {
-            return 10;
         }
+
+        return 10;
     }
 }
```

<br>

### ReturnBinaryOrToEarlyReturnRector

Changes Single return of || to early returns

- class: [`Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector`](../rules/EarlyReturn/Rector/Return_/ReturnBinaryOrToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function accept()
     {
-        return $this->something() || $this->somethingElse();
+        if ($this->something()) {
+            return true;
+        }
+        return (bool) $this->somethingElse();
     }
 }
```

<br>

### ReturnEarlyIfVariableRector

Replace if conditioned variable override with direct return

- class: [`Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector`](../rules/EarlyReturn/Rector/StmtsAwareInterface/ReturnEarlyIfVariableRector.php)

```diff
 final class SomeClass
 {
     public function run($value)
     {
         if ($value === 50) {
-            $value = 100;
+            return 100;
         }

         return $value;
     }
 }
```

<br>

## Instanceof

### FlipNegatedTernaryInstanceofRector

Flip negated ternary of instanceof to direct use of object

- class: [`Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector`](../rules/Instanceof_/Rector/Ternary/FlipNegatedTernaryInstanceofRector.php)

```diff
-echo ! $object instanceof Product ? null : $object->getPrice();
+echo $object instanceof Product ? $object->getPrice() : null;
```

<br>

## Naming

### RenameForeachValueVariableToMatchExprVariableRector

Renames value variable name in foreach loop to match expression variable

- class: [`Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector`](../rules/Naming/Rector/Foreach_/RenameForeachValueVariableToMatchExprVariableRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $array = [];
-        foreach ($variables as $property) {
-            $array[] = $property;
+        foreach ($variables as $variable) {
+            $array[] = $variable;
         }
     }
 }
```

<br>

### RenameForeachValueVariableToMatchMethodCallReturnTypeRector

Renames value variable name in foreach loop to match method type

- class: [`Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector`](../rules/Naming/Rector/Foreach_/RenameForeachValueVariableToMatchMethodCallReturnTypeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $array = [];
-        foreach ($object->getMethods() as $property) {
-            $array[] = $property;
+        foreach ($object->getMethods() as $method) {
+            $array[] = $method;
         }
     }
 }
```

<br>

### RenameParamToMatchTypeRector

Rename param to match ClassType

- class: [`Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector`](../rules/Naming/Rector/ClassMethod/RenameParamToMatchTypeRector.php)

```diff
 final class SomeClass
 {
-    public function run(Apple $pie)
+    public function run(Apple $apple)
     {
-        $food = $pie;
+        $food = $apple;
     }
 }
```

<br>

### RenamePropertyToMatchTypeRector

Rename property and method param to match its type

- class: [`Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector`](../rules/Naming/Rector/Class_/RenamePropertyToMatchTypeRector.php)

```diff
 class SomeClass
 {
     /**
      * @var EntityManager
      */
-    private $eventManager;
+    private $entityManager;

-    public function __construct(EntityManager $eventManager)
+    public function __construct(EntityManager $entityManager)
     {
-        $this->eventManager = $eventManager;
+        $this->entityManager = $entityManager;
     }
 }
```

<br>

### RenameVariableToMatchMethodCallReturnTypeRector

Rename variable to match method return type

- class: [`Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector`](../rules/Naming/Rector/Assign/RenameVariableToMatchMethodCallReturnTypeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $a = $this->getRunner();
+        $runner = $this->getRunner();
     }

     public function getRunner(): Runner
     {
         return new Runner();
     }
 }
```

<br>

### RenameVariableToMatchNewTypeRector

Rename variable to match new ClassType

- class: [`Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector`](../rules/Naming/Rector/ClassMethod/RenameVariableToMatchNewTypeRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $search = new DreamSearch();
-        $search->advance();
+        $dreamSearch = new DreamSearch();
+        $dreamSearch->advance();
     }
 }
```

<br>

## Php52

### ContinueToBreakInSwitchRector

Use break instead of continue in switch statements

- class: [`Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector`](../rules/Php52/Rector/Switch_/ContinueToBreakInSwitchRector.php)

```diff
 function some_run($value)
 {
     switch ($value) {
         case 1:
             echo 'Hi';
-            continue;
+            break;
         case 2:
             echo 'Hello';
             break;
     }
 }
```

<br>

### VarToPublicPropertyRector

Change property modifier from `var` to `public`

- class: [`Rector\Php52\Rector\Property\VarToPublicPropertyRector`](../rules/Php52/Rector/Property/VarToPublicPropertyRector.php)

```diff
 final class SomeController
 {
-    var $name = 'Tom';
+    public $name = 'Tom';
 }
```

<br>

## Php53

### DirNameFileConstantToDirConstantRector

Convert dirname(__FILE__) to __DIR__

- class: [`Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector`](../rules/Php53/Rector/FuncCall/DirNameFileConstantToDirConstantRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return dirname(__FILE__);
+        return __DIR__;
     }
 }
```

<br>

### ReplaceHttpServerVarsByServerRector

Rename old `$HTTP_*` variable names to new replacements

- class: [`Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector`](../rules/Php53/Rector/Variable/ReplaceHttpServerVarsByServerRector.php)

```diff
-$serverVars = $HTTP_SERVER_VARS;
+$serverVars = $_SERVER;
```

<br>

### TernaryToElvisRector

Use ?: instead of ?, where useful

- class: [`Rector\Php53\Rector\Ternary\TernaryToElvisRector`](../rules/Php53/Rector/Ternary/TernaryToElvisRector.php)

```diff
 function elvis()
 {
-    $value = $a ? $a : false;
+    $value = $a ?: false;
 }
```

<br>

## Php54

### LongArrayToShortArrayRector

Long array to short array

- class: [`Rector\Php54\Rector\Array_\LongArrayToShortArrayRector`](../rules/Php54/Rector/Array_/LongArrayToShortArrayRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return array();
+        return [];
     }
 }
```

<br>

### RemoveReferenceFromCallRector

Remove & from function and method calls

- class: [`Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector`](../rules/Php54/Rector/FuncCall/RemoveReferenceFromCallRector.php)

```diff
 final class SomeClass
 {
     public function run($one)
     {
-        return strlen(&$one);
+        return strlen($one);
     }
 }
```

<br>

### RemoveZeroBreakContinueRector

Remove 0 from break and continue

- class: [`Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector`](../rules/Php54/Rector/Break_/RemoveZeroBreakContinueRector.php)

```diff
 class SomeClass
 {
     public function run($random)
     {
-        continue 0;
-        break 0;
+        continue;
+        break;

         $five = 5;
-        continue $five;
+        continue 5;

-        break $random;
+        break;
     }
 }
```

<br>

## Php55

### ClassConstantToSelfClassRector

Change `__CLASS__` to self::class

- class: [`Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector`](../rules/Php55/Rector/Class_/ClassConstantToSelfClassRector.php)

```diff
 class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(__CLASS__);
+       var_dump(self::class);
    }
 }
```

<br>

### GetCalledClassToSelfClassRector

Change `get_called_class()` to self::class on final class

- class: [`Rector\Php55\Rector\FuncCall\GetCalledClassToSelfClassRector`](../rules/Php55/Rector/FuncCall/GetCalledClassToSelfClassRector.php)

```diff
 final class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(get_called_class());
+       var_dump(self::class);
    }
 }
```

<br>

### GetCalledClassToStaticClassRector

Change `get_called_class()` to static::class on non-final class

- class: [`Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector`](../rules/Php55/Rector/FuncCall/GetCalledClassToStaticClassRector.php)

```diff
 class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(get_called_class());
+       var_dump(static::class);
    }
 }
```

<br>

### PregReplaceEModifierRector

The /e modifier is no longer supported, use preg_replace_callback instead

- class: [`Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector`](../rules/Php55/Rector/FuncCall/PregReplaceEModifierRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $comment = preg_replace('~\b(\w)(\w+)~e', '"$1".strtolower("$2")', $comment);
+        $comment = preg_replace_callback('~\b(\w)(\w+)~', function ($matches) {
+              return($matches[1].strtolower($matches[2]));
+        }, $comment);
     }
 }
```

<br>

### StaticToSelfOnFinalClassRector

Change `static::class` to `self::class` on final class

- class: [`Rector\Php55\Rector\ClassConstFetch\StaticToSelfOnFinalClassRector`](../rules/Php55/Rector/ClassConstFetch/StaticToSelfOnFinalClassRector.php)

```diff
 final class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(static::class);
+       var_dump(self::class);
    }
 }
```

<br>

### StringClassNameToClassConstantRector

Replace string class names by <class>::class constant

:wrench: **configure it!**

- class: [`Rector\Php55\Rector\String_\StringClassNameToClassConstantRector`](../rules/Php55/Rector/String_/StringClassNameToClassConstantRector.php)

```diff
 class AnotherClass
 {
 }

 class SomeClass
 {
     public function run()
     {
-        return 'AnotherClass';
+        return \AnotherClass::class;
     }
 }
```

<br>

## Php56

### PowToExpRector

Changes pow(val, val2) to ** (exp) parameter

- class: [`Rector\Php56\Rector\FuncCall\PowToExpRector`](../rules/Php56/Rector/FuncCall/PowToExpRector.php)

```diff
-pow(1, 2);
+1**2;
```

<br>

## Php70

### BreakNotInLoopOrSwitchToReturnRector

Convert break outside for/foreach/switch context to return

- class: [`Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector`](../rules/Php70/Rector/Break_/BreakNotInLoopOrSwitchToReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($isphp5)
             return 1;
         else
             return 2;
-        break;
+        return;
     }
 }
```

<br>

### CallUserMethodRector

Changes `call_user_method()/call_user_method_array()` to `call_user_func()/call_user_func_array()`

- class: [`Rector\Php70\Rector\FuncCall\CallUserMethodRector`](../rules/Php70/Rector/FuncCall/CallUserMethodRector.php)

```diff
-call_user_method($method, $obj, "arg1", "arg2");
+call_user_func(array(&$obj, "method"), "arg1", "arg2");
```

<br>

### EmptyListRector

`list()` cannot be empty

- class: [`Rector\Php70\Rector\List_\EmptyListRector`](../rules/Php70/Rector/List_/EmptyListRector.php)

```diff
-'list() = $values;'
+'list($unusedGenerated) = $values;'
```

<br>

### EregToPregMatchRector

Changes ereg*() to preg*() calls

- class: [`Rector\Php70\Rector\FuncCall\EregToPregMatchRector`](../rules/Php70/Rector/FuncCall/EregToPregMatchRector.php)

```diff
-ereg("hi")
+preg_match("#hi#");
```

<br>

### ExceptionHandlerTypehintRector

Change typehint from `Exception` to `Throwable`.

- class: [`Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector`](../rules/Php70/Rector/FunctionLike/ExceptionHandlerTypehintRector.php)

```diff
-function handler(Exception $exception) { ... }
+function handler(Throwable $exception) { ... }
 set_exception_handler('handler');
```

<br>

### IfIssetToCoalescingRector

Change if with isset and return to coalesce

- class: [`Rector\Php70\Rector\StmtsAwareInterface\IfIssetToCoalescingRector`](../rules/Php70/Rector/StmtsAwareInterface/IfIssetToCoalescingRector.php)

```diff
 class SomeClass
 {
     private $items = [];

     public function resolve($key)
     {
-        if (isset($this->items[$key])) {
-            return $this->items[$key];
-        }
-
-        return 'fallback value';
+        return $this->items[$key] ?? 'fallback value';
     }
 }
```

<br>

### IfToSpaceshipRector

Changes if/else to spaceship <=> where useful

- class: [`Rector\Php70\Rector\If_\IfToSpaceshipRector`](../rules/Php70/Rector/If_/IfToSpaceshipRector.php)

```diff
 usort($languages, function ($first, $second) {
-if ($first[0] === $second[0]) {
-    return 0;
-}
-
-return ($first[0] < $second[0]) ? 1 : -1;
+return $second[0] <=> $first[0];
 });
```

<br>

### ListSplitStringRector

`list()` cannot split string directly anymore, use `str_split()`

- class: [`Rector\Php70\Rector\Assign\ListSplitStringRector`](../rules/Php70/Rector/Assign/ListSplitStringRector.php)

```diff
-list($foo) = "string";
+list($foo) = str_split("string");
```

<br>

### ListSwapArrayOrderRector

`list()` assigns variables in reverse order - relevant in array assign

- class: [`Rector\Php70\Rector\Assign\ListSwapArrayOrderRector`](../rules/Php70/Rector/Assign/ListSwapArrayOrderRector.php)

```diff
-list($a[], $a[]) = [1, 2];
+list($a[], $a[]) = array_reverse([1, 2]);
```

<br>

### MultiDirnameRector

Changes multiple `dirname()` calls to one with nesting level

- class: [`Rector\Php70\Rector\FuncCall\MultiDirnameRector`](../rules/Php70/Rector/FuncCall/MultiDirnameRector.php)

```diff
-dirname(dirname($path));
+dirname($path, 2);
```

<br>

### Php4ConstructorRector

Changes PHP 4 style constructor to __construct.

- class: [`Rector\Php70\Rector\ClassMethod\Php4ConstructorRector`](../rules/Php70/Rector/ClassMethod/Php4ConstructorRector.php)

```diff
 class SomeClass
 {
-    public function SomeClass()
+    public function __construct()
     {
     }
 }
```

<br>

### RandomFunctionRector

Changes rand, srand, and getrandmax to newer alternatives

- class: [`Rector\Php70\Rector\FuncCall\RandomFunctionRector`](../rules/Php70/Rector/FuncCall/RandomFunctionRector.php)

```diff
-rand();
+random_int();
```

<br>

### ReduceMultipleDefaultSwitchRector

Remove first default switch, that is ignored

- class: [`Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector`](../rules/Php70/Rector/Switch_/ReduceMultipleDefaultSwitchRector.php)

```diff
 switch ($expr) {
     default:
-         echo "Hello World";
-
-    default:
          echo "Goodbye Moon!";
          break;
 }
```

<br>

### RenameMktimeWithoutArgsToTimeRector

Renames `mktime()` without arguments to `time()`

- class: [`Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector`](../rules/Php70/Rector/FuncCall/RenameMktimeWithoutArgsToTimeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $time = mktime(1, 2, 3);
-        $nextTime = mktime();
+        $nextTime = time();
     }
 }
```

<br>

### StaticCallOnNonStaticToInstanceCallRector

Changes static call to instance call, where not useful

- class: [`Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector`](../rules/Php70/Rector/StaticCall/StaticCallOnNonStaticToInstanceCallRector.php)

```diff
 class Something
 {
     public function doWork()
     {
     }
 }

 class Another
 {
     public function run()
     {
-        return Something::doWork();
+        return (new Something)->doWork();
     }
 }
```

<br>

### TernaryToNullCoalescingRector

Changes unneeded null check to ?? operator

- class: [`Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector`](../rules/Php70/Rector/Ternary/TernaryToNullCoalescingRector.php)

```diff
-$value === null ? 10 : $value;
+$value ?? 10;
```

<br>

```diff
-isset($value) ? $value : 10;
+$value ?? 10;
```

<br>

### TernaryToSpaceshipRector

Use <=> spaceship instead of ternary with same effect

- class: [`Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector`](../rules/Php70/Rector/Ternary/TernaryToSpaceshipRector.php)

```diff
 function order_func($a, $b) {
-    return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
+    return $a <=> $b;
 }
```

<br>

### ThisCallOnStaticMethodToStaticCallRector

Changes `$this->call()` to static method to static call

- class: [`Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector`](../rules/Php70/Rector/MethodCall/ThisCallOnStaticMethodToStaticCallRector.php)

```diff
 class SomeClass
 {
     public static function run()
     {
-        $this->eat();
+        static::eat();
     }

     public static function eat()
     {
     }
 }
```

<br>

### WrapVariableVariableNameInCurlyBracesRector

Ensure variable variables are wrapped in curly braces

- class: [`Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector`](../rules/Php70/Rector/Variable/WrapVariableVariableNameInCurlyBracesRector.php)

```diff
 function run($foo)
 {
-    global $$foo->bar;
+    global ${$foo->bar};
 }
```

<br>

## Php71

### AssignArrayToStringRector

String cannot be turned into array by assignment anymore

- class: [`Rector\Php71\Rector\Assign\AssignArrayToStringRector`](../rules/Php71/Rector/Assign/AssignArrayToStringRector.php)

```diff
-$string = '';
+$string = [];
 $string[] = 1;
```

<br>

### BinaryOpBetweenNumberAndStringRector

Change binary operation between some number + string to PHP 7.1 compatible version

- class: [`Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector`](../rules/Php71/Rector/BinaryOp/BinaryOpBetweenNumberAndStringRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5 + '';
-        $value = 5.0 + 'hi';
+        $value = 5 + 0;
+        $value = 5.0 + 0.0;
     }
 }
```

<br>

### IsIterableRector

Changes is_array + Traversable check to is_iterable

- class: [`Rector\Php71\Rector\BooleanOr\IsIterableRector`](../rules/Php71/Rector/BooleanOr/IsIterableRector.php)

```diff
-is_array($foo) || $foo instanceof Traversable;
+is_iterable($foo);
```

<br>

### ListToArrayDestructRector

Change `list()` to array destruct

- class: [`Rector\Php71\Rector\List_\ListToArrayDestructRector`](../rules/Php71/Rector/List_/ListToArrayDestructRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        list($id1, $name1) = $data;
+        [$id1, $name1] = $data;

-        foreach ($data as list($id, $name)) {
+        foreach ($data as [$id, $name]) {
         }
     }
 }
```

<br>

### MultiExceptionCatchRector

Changes multi catch of same exception to single one | separated.

- class: [`Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector`](../rules/Php71/Rector/TryCatch/MultiExceptionCatchRector.php)

```diff
 try {
     // Some code...
-} catch (ExceptionType1 $exception) {
-    $sameCode;
-} catch (ExceptionType2 $exception) {
+} catch (ExceptionType1 | ExceptionType2 $exception) {
     $sameCode;
 }
```

<br>

### PublicConstantVisibilityRector

Add explicit public constant visibility.

- class: [`Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector`](../rules/Php71/Rector/ClassConst/PublicConstantVisibilityRector.php)

```diff
 class SomeClass
 {
-    const HEY = 'you';
+    public const HEY = 'you';
 }
```

<br>

### RemoveExtraParametersRector

Remove extra parameters

- class: [`Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector`](../rules/Php71/Rector/FuncCall/RemoveExtraParametersRector.php)

```diff
-strlen("asdf", 1);
+strlen("asdf");
```

<br>

## Php72

### CreateFunctionToAnonymousFunctionRector

Use anonymous functions instead of deprecated `create_function()`

- class: [`Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector`](../rules/Php72/Rector/FuncCall/CreateFunctionToAnonymousFunctionRector.php)

```diff
 class ClassWithCreateFunction
 {
     public function run()
     {
-        $callable = create_function('$matches', "return '$delimiter' . strtolower(\$matches[1]);");
+        $callable = function($matches) use ($delimiter) {
+            return $delimiter . strtolower($matches[1]);
+        };
     }
 }
```

<br>

### GetClassOnNullRector

Null is no more allowed in `get_class()`

- class: [`Rector\Php72\Rector\FuncCall\GetClassOnNullRector`](../rules/Php72/Rector/FuncCall/GetClassOnNullRector.php)

```diff
 final class SomeClass
 {
     public function getItem()
     {
         $value = null;
-        return get_class($value);
+        return $value !== null ? get_class($value) : self::class;
     }
 }
```

<br>

### ListEachRector

`each()` function is deprecated, use `key()` and `current()` instead

- class: [`Rector\Php72\Rector\Assign\ListEachRector`](../rules/Php72/Rector/Assign/ListEachRector.php)

```diff
-list($key, $callback) = each($callbacks);
+$key = key($callbacks);
+$callback = current($callbacks);
+next($callbacks);
```

<br>

### ParseStrWithResultArgumentRector

Use `$result` argument in `parse_str()` function

- class: [`Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector`](../rules/Php72/Rector/FuncCall/ParseStrWithResultArgumentRector.php)

```diff
-parse_str($this->query);
-$data = get_defined_vars();
+parse_str($this->query, $result);
+$data = $result;
```

<br>

### ReplaceEachAssignmentWithKeyCurrentRector

Replace `each()` assign outside loop

- class: [`Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector`](../rules/Php72/Rector/Assign/ReplaceEachAssignmentWithKeyCurrentRector.php)

```diff
 $array = ['b' => 1, 'a' => 2];

-$eachedArray = each($array);
+$eachedArray[1] = current($array);
+$eachedArray['value'] = current($array);
+$eachedArray[0] = key($array);
+$eachedArray['key'] = key($array);
+
+next($array);
```

<br>

### StringifyDefineRector

Make first argument of `define()` string

- class: [`Rector\Php72\Rector\FuncCall\StringifyDefineRector`](../rules/Php72/Rector/FuncCall/StringifyDefineRector.php)

```diff
 class SomeClass
 {
     public function run(int $a)
     {
-         define(CONSTANT_2, 'value');
+         define('CONSTANT_2', 'value');
          define('CONSTANT', 'value');
     }
 }
```

<br>

### StringsAssertNakedRector

String asserts must be passed directly to `assert()`

- class: [`Rector\Php72\Rector\FuncCall\StringsAssertNakedRector`](../rules/Php72/Rector/FuncCall/StringsAssertNakedRector.php)

```diff
 function nakedAssert()
 {
-    assert('true === true');
-    assert("true === true");
+    assert(true === true);
+    assert(true === true);
 }
```

<br>

### UnsetCastRector

Removes (unset) cast

- class: [`Rector\Php72\Rector\Unset_\UnsetCastRector`](../rules/Php72/Rector/Unset_/UnsetCastRector.php)

```diff
-$different = (unset) $value;
+$different = null;

-$value = (unset) $value;
+unset($value);
```

<br>

### WhileEachToForeachRector

`each()` function is deprecated, use `foreach()` instead.

- class: [`Rector\Php72\Rector\While_\WhileEachToForeachRector`](../rules/Php72/Rector/While_/WhileEachToForeachRector.php)

```diff
-while (list($key, $callback) = each($callbacks)) {
+foreach ($callbacks as $key => $callback) {
     // ...
 }
```

<br>

```diff
-while (list($key) = each($callbacks)) {
+foreach (array_keys($callbacks) as $key) {
     // ...
 }
```

<br>

## Php73

### ArrayKeyFirstLastRector

Make use of `array_key_first()` and `array_key_last()`

- class: [`Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector`](../rules/Php73/Rector/FuncCall/ArrayKeyFirstLastRector.php)

```diff
-reset($items);
-$firstKey = key($items);
+$firstKey = array_key_first($items);
```

<br>

```diff
-end($items);
-$lastKey = key($items);
+$lastKey = array_key_last($items);
```

<br>

### IsCountableRector

Changes is_array + Countable check to is_countable

- class: [`Rector\Php73\Rector\BooleanOr\IsCountableRector`](../rules/Php73/Rector/BooleanOr/IsCountableRector.php)

```diff
-is_array($foo) || $foo instanceof Countable;
+is_countable($foo);
```

<br>

### JsonThrowOnErrorRector

Adds JSON_THROW_ON_ERROR to `json_encode()` and `json_decode()` to throw JsonException on error

- class: [`Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector`](../rules/Php73/Rector/FuncCall/JsonThrowOnErrorRector.php)

```diff
-json_encode($content);
-json_decode($json);
+json_encode($content, JSON_THROW_ON_ERROR);
+json_decode($json, null, 512, JSON_THROW_ON_ERROR);
```

<br>

### RegexDashEscapeRector

Escape - in some cases

- class: [`Rector\Php73\Rector\FuncCall\RegexDashEscapeRector`](../rules/Php73/Rector/FuncCall/RegexDashEscapeRector.php)

```diff
-preg_match("#[\w-()]#", 'some text');
+preg_match("#[\w\-()]#", 'some text');
```

<br>

### SensitiveConstantNameRector

Changes case insensitive constants to sensitive ones.

- class: [`Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector`](../rules/Php73/Rector/ConstFetch/SensitiveConstantNameRector.php)

```diff
 define('FOO', 42, true);
 var_dump(FOO);
-var_dump(foo);
+var_dump(FOO);
```

<br>

### SensitiveDefineRector

Changes case insensitive constants to sensitive ones.

- class: [`Rector\Php73\Rector\FuncCall\SensitiveDefineRector`](../rules/Php73/Rector/FuncCall/SensitiveDefineRector.php)

```diff
-define('FOO', 42, true);
+define('FOO', 42);
```

<br>

### SensitiveHereNowDocRector

Changes heredoc/nowdoc that contains closing word to safe wrapper name

- class: [`Rector\Php73\Rector\String_\SensitiveHereNowDocRector`](../rules/Php73/Rector/String_/SensitiveHereNowDocRector.php)

```diff
-$value = <<<A
+$value = <<<A_WRAP
     A
-A
+A_WRAP
```

<br>

### SetCookieRector

Convert setcookie argument to PHP7.3 option array

- class: [`Rector\Php73\Rector\FuncCall\SetCookieRector`](../rules/Php73/Rector/FuncCall/SetCookieRector.php)

```diff
-setcookie('name', $value, 360);
+setcookie('name', $value, ['expires' => 360]);
```

<br>

```diff
-setcookie('name', $name, 0, '', '', true, true);
+setcookie('name', $name, ['expires' => 0, 'path' => '', 'domain' => '', 'secure' => true, 'httponly' => true]);
```

<br>

### StringifyStrNeedlesRector

Makes needles explicit strings

- class: [`Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector`](../rules/Php73/Rector/FuncCall/StringifyStrNeedlesRector.php)

```diff
 $needle = 5;
-$fivePosition = strpos('725', $needle);
+$fivePosition = strpos('725', (string) $needle);
```

<br>

## Php74

### AddLiteralSeparatorToNumberRector

Add "_" as thousands separator in numbers for higher or equals to limitValue config

:wrench: **configure it!**

- class: [`Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector`](../rules/Php74/Rector/LNumber/AddLiteralSeparatorToNumberRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $int = 500000;
-        $float = 1000500.001;
+        $int = 500_000;
+        $float = 1_000_500.001;
     }
 }
```

<br>

### ArrayKeyExistsOnPropertyRector

Change `array_key_exists()` on property to `property_exists()`

- class: [`Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector`](../rules/Php74/Rector/FuncCall/ArrayKeyExistsOnPropertyRector.php)

```diff
 class SomeClass
 {
      public $value;
 }
 $someClass = new SomeClass;

-array_key_exists('value', $someClass);
+property_exists($someClass, 'value');
```

<br>

### ClosureToArrowFunctionRector

Change closure to arrow function

- class: [`Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector`](../rules/Php74/Rector/Closure/ClosureToArrowFunctionRector.php)

```diff
 class SomeClass
 {
     public function run($meetups)
     {
-        return array_filter($meetups, function (Meetup $meetup) {
-            return is_object($meetup);
-        });
+        return array_filter($meetups, fn(Meetup $meetup) => is_object($meetup));
     }
 }
```

<br>

### CurlyToSquareBracketArrayStringRector

Change curly based array and string to square bracket

- class: [`Rector\Php74\Rector\ArrayDimFetch\CurlyToSquareBracketArrayStringRector`](../rules/Php74/Rector/ArrayDimFetch/CurlyToSquareBracketArrayStringRector.php)

```diff
 $string = 'test';
-echo $string{0};
+echo $string[0];

 $array = ['test'];
-echo $array{0};
+echo $array[0];
```

<br>

### ExportToReflectionFunctionRector

Change `export()` to ReflectionFunction alternatives

- class: [`Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector`](../rules/Php74/Rector/StaticCall/ExportToReflectionFunctionRector.php)

```diff
-$reflectionFunction = ReflectionFunction::export('foo');
-$reflectionFunctionAsString = ReflectionFunction::export('foo', true);
+$reflectionFunction = new ReflectionFunction('foo');
+$reflectionFunctionAsString = (string) new ReflectionFunction('foo');
```

<br>

### FilterVarToAddSlashesRector

Change `filter_var()` with slash escaping to `addslashes()`

- class: [`Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector`](../rules/Php74/Rector/FuncCall/FilterVarToAddSlashesRector.php)

```diff
 $var= "Satya's here!";
-filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
+addslashes($var);
```

<br>

### HebrevcToNl2brHebrevRector

Change hebrevc($str) to nl2br(hebrev($str))

- class: [`Rector\Php74\Rector\FuncCall\HebrevcToNl2brHebrevRector`](../rules/Php74/Rector/FuncCall/HebrevcToNl2brHebrevRector.php)

```diff
-hebrevc($str);
+nl2br(hebrev($str));
```

<br>

### MbStrrposEncodingArgumentPositionRector

Change `mb_strrpos()` encoding argument position

- class: [`Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector`](../rules/Php74/Rector/FuncCall/MbStrrposEncodingArgumentPositionRector.php)

```diff
-mb_strrpos($text, "abc", "UTF-8");
+mb_strrpos($text, "abc", 0, "UTF-8");
```

<br>

### MoneyFormatToNumberFormatRector

Change `money_format()` to equivalent `number_format()`

- class: [`Rector\Php74\Rector\FuncCall\MoneyFormatToNumberFormatRector`](../rules/Php74/Rector/FuncCall/MoneyFormatToNumberFormatRector.php)

```diff
-$value = money_format('%i', $value);
+$value = number_format(round($value, 2, PHP_ROUND_HALF_ODD), 2, '.', '');
```

<br>

### NullCoalescingOperatorRector

Use null coalescing operator ??=

- class: [`Rector\Php74\Rector\Assign\NullCoalescingOperatorRector`](../rules/Php74/Rector/Assign/NullCoalescingOperatorRector.php)

```diff
 $array = [];
-$array['user_id'] = $array['user_id'] ?? 'value';
+$array['user_id'] ??= 'value';
```

<br>

### ParenthesizeNestedTernaryRector

Add parentheses to nested ternary

- class: [`Rector\Php74\Rector\Ternary\ParenthesizeNestedTernaryRector`](../rules/Php74/Rector/Ternary/ParenthesizeNestedTernaryRector.php)

```diff
-$value = $a ? $b : $a ?: null;
+$value = ($a ? $b : $a) ?: null;
```

<br>

### RealToFloatTypeCastRector

Change deprecated (real) to (float)

- class: [`Rector\Php74\Rector\Double\RealToFloatTypeCastRector`](../rules/Php74/Rector/Double/RealToFloatTypeCastRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $number = (real) 5;
+        $number = (float) 5;
         $number = (float) 5;
         $number = (double) 5;
     }
 }
```

<br>

### RestoreDefaultNullToNullableTypePropertyRector

Add null default to properties with PHP 7.4 property nullable type

- class: [`Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector`](../rules/Php74/Rector/Property/RestoreDefaultNullToNullableTypePropertyRector.php)

```diff
 class SomeClass
 {
-    public ?string $name;
+    public ?string $name = null;
 }
```

<br>

### RestoreIncludePathToIniRestoreRector

Change `restore_include_path()` to ini_restore("include_path")

- class: [`Rector\Php74\Rector\FuncCall\RestoreIncludePathToIniRestoreRector`](../rules/Php74/Rector/FuncCall/RestoreIncludePathToIniRestoreRector.php)

```diff
-restore_include_path();
+ini_restore('include_path');
```

<br>

## Php80

### AddParamBasedOnParentClassMethodRector

Add missing parameter based on parent class method

- class: [`Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector`](../rules/Php80/Rector/ClassMethod/AddParamBasedOnParentClassMethodRector.php)

```diff
 class A
 {
     public function execute($foo)
     {
     }
 }

 class B extends A{
-    public function execute()
+    public function execute($foo)
     {
     }
 }
```

<br>

### AnnotationToAttributeRector

Change annotation to attribute

:wrench: **configure it!**

- class: [`Rector\Php80\Rector\Class_\AnnotationToAttributeRector`](../rules/Php80/Rector/Class_/AnnotationToAttributeRector.php)

```diff
 use Symfony\Component\Routing\Annotation\Route;

 class SymfonyRoute
 {
-    /**
-     * @Route("/path", name="action") api route
-     */
+    #[Route(path: '/path', name: 'action')] // api route
     public function action()
     {
     }
 }
```

<br>

### ChangeSwitchToMatchRector

Change `switch()` to `match()`

- class: [`Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector`](../rules/Php80/Rector/Switch_/ChangeSwitchToMatchRector.php)

```diff
-switch ($input) {
-    case Lexer::T_SELECT:
-        $statement = 'select';
-        break;
-    case Lexer::T_UPDATE:
-        $statement = 'update';
-        break;
-    default:
-        $statement = 'error';
-}
+$statement = match ($input) {
+    Lexer::T_SELECT => 'select',
+    Lexer::T_UPDATE => 'update',
+    default => 'error',
+};
```

<br>

### ClassOnObjectRector

Change get_class($object) to faster `$object::class`

- class: [`Rector\Php80\Rector\FuncCall\ClassOnObjectRector`](../rules/Php80/Rector/FuncCall/ClassOnObjectRector.php)

```diff
 class SomeClass
 {
     public function run($object)
     {
-        return get_class($object);
+        return $object::class;
     }
 }
```

<br>

### ClassOnThisVariableObjectRector

Change `$this::class` to static::class or self::class depends on class modifier

- class: [`Rector\Php80\Rector\ClassConstFetch\ClassOnThisVariableObjectRector`](../rules/Php80/Rector/ClassConstFetch/ClassOnThisVariableObjectRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return $this::class;
+        return static::class;
     }
 }
```

<br>

### ClassPropertyAssignToConstructorPromotionRector

Change simple property init and assign to constructor promotion

:wrench: **configure it!**

- class: [`Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector`](../rules/Php80/Rector/Class_/ClassPropertyAssignToConstructorPromotionRector.php)

```diff
 class SomeClass
 {
-    public float $price;
-
     public function __construct(
-        float $price = 0.0
+        public float $price = 0.0
     ) {
-        $this->price = $price;
     }
 }
```

<br>

### FinalPrivateToPrivateVisibilityRector

Changes method visibility from final private to only private

- class: [`Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector`](../rules/Php80/Rector/ClassMethod/FinalPrivateToPrivateVisibilityRector.php)

```diff
 class SomeClass
 {
-    final private function getter() {
+    private function getter() {
         return $this;
     }
 }
```

<br>

### GetDebugTypeRector

Change ternary type resolve to `get_debug_type()`

- class: [`Rector\Php80\Rector\Ternary\GetDebugTypeRector`](../rules/Php80/Rector/Ternary/GetDebugTypeRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return is_object($value) ? get_class($value) : gettype($value);
+        return get_debug_type($value);
     }
 }
```

<br>

### MixedTypeRector

Change mixed docs type to mixed typed

- class: [`Rector\Php80\Rector\FunctionLike\MixedTypeRector`](../rules/Php80/Rector/FunctionLike/MixedTypeRector.php)

```diff
 class SomeClass
 {
-    /**
-     * @param mixed $param
-     */
-    public function run($param)
+    public function run(mixed $param)
     {
     }
 }
```

<br>

### NestedAnnotationToAttributeRector

Changed nested annotations to attributes

:wrench: **configure it!**

- class: [`Rector\Php80\Rector\Property\NestedAnnotationToAttributeRector`](../rules/Php80/Rector/Property/NestedAnnotationToAttributeRector.php)

```diff
 use Doctrine\ORM\Mapping as ORM;

 class SomeEntity
 {
-    /**
-     * @ORM\JoinTable(name="join_table_name",
-     *     joinColumns={@ORM\JoinColumn(name="origin_id")},
-     *     inverseJoinColumns={@ORM\JoinColumn(name="target_id")}
-     * )
-     */
+    #[ORM\JoinTable(name: 'join_table_name')]
+    #[ORM\JoinColumn(name: 'origin_id')]
+    #[ORM\InverseJoinColumn(name: 'target_id')]
     private $collection;
 }
```

<br>

### RemoveUnusedVariableInCatchRector

Remove unused variable in `catch()`

- class: [`Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector`](../rules/Php80/Rector/Catch_/RemoveUnusedVariableInCatchRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
         try {
-        } catch (Throwable $notUsedThrowable) {
+        } catch (Throwable) {
         }
     }
 }
```

<br>

### SetStateToStaticRector

Adds static visibility to `__set_state()` methods

- class: [`Rector\Php80\Rector\ClassMethod\SetStateToStaticRector`](../rules/Php80/Rector/ClassMethod/SetStateToStaticRector.php)

```diff
 class SomeClass
 {
-    public function __set_state($properties) {
+    public static function __set_state($properties) {

     }
 }
```

<br>

### StrContainsRector

Replace `strpos()` !== false and `strstr()`  with `str_contains()`

- class: [`Rector\Php80\Rector\NotIdentical\StrContainsRector`](../rules/Php80/Rector/NotIdentical/StrContainsRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return strpos('abc', 'a') !== false;
+        return str_contains('abc', 'a');
     }
 }
```

<br>

### StrEndsWithRector

Change helper functions to `str_ends_with()`

- class: [`Rector\Php80\Rector\Identical\StrEndsWithRector`](../rules/Php80/Rector/Identical/StrEndsWithRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $isMatch = substr($haystack, -strlen($needle)) === $needle;
+        $isMatch = str_ends_with($haystack, $needle);

-        $isNotMatch = substr($haystack, -strlen($needle)) !== $needle;
+        $isNotMatch = !str_ends_with($haystack, $needle);
     }
 }
```

<br>

```diff
 class SomeClass
 {
     public function run()
     {
-        $isMatch = substr($haystack, -9) === 'hardcoded;
+        $isMatch = str_ends_with($haystack, 'hardcoded');

-        $isNotMatch = substr($haystack, -9) !== 'hardcoded';
+        $isNotMatch = !str_ends_with($haystack, 'hardcoded');
     }
 }
```

<br>

### StrStartsWithRector

Change helper functions to `str_starts_with()`

- class: [`Rector\Php80\Rector\Identical\StrStartsWithRector`](../rules/Php80/Rector/Identical/StrStartsWithRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $isMatch = substr($haystack, 0, strlen($needle)) === $needle;
+        $isMatch = str_starts_with($haystack, $needle);

-        $isNotMatch = substr($haystack, 0, strlen($needle)) !== $needle;
+        $isNotMatch = ! str_starts_with($haystack, $needle);
     }
 }
```

<br>

### StringableForToStringRector

Add `Stringable` interface to classes with `__toString()` method

- class: [`Rector\Php80\Rector\Class_\StringableForToStringRector`](../rules/Php80/Rector/Class_/StringableForToStringRector.php)

```diff
-class SomeClass
+class SomeClass implements Stringable
 {
-    public function __toString()
+    public function __toString(): string
     {
         return 'I can stringz';
     }
 }
```

<br>

## Php81

### FirstClassCallableRector

Upgrade array callable to first class callable

- class: [`Rector\Php81\Rector\Array_\FirstClassCallableRector`](../rules/Php81/Rector/Array_/FirstClassCallableRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $name = [$this, 'name'];
+        $name = $this->name(...);
     }

     public function name()
     {
     }
 }
```

<br>

### MyCLabsClassToEnumRector

Refactor MyCLabs enum class to native Enum

- class: [`Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector`](../rules/Php81/Rector/Class_/MyCLabsClassToEnumRector.php)

```diff
-use MyCLabs\Enum\Enum;
-
-final class Action extends Enum
+enum Action : string
 {
-    private const VIEW = 'view';
-    private const EDIT = 'edit';
+    case VIEW = 'view';
+    case EDIT = 'edit';
 }
```

<br>

### MyCLabsMethodCallToEnumConstRector

Refactor MyCLabs enum fetch to Enum const

- class: [`Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector`](../rules/Php81/Rector/MethodCall/MyCLabsMethodCallToEnumConstRector.php)

```diff
-$name = SomeEnum::VALUE()->getKey();
+$name = SomeEnum::VALUE;
```

<br>

### NewInInitializerRector

Replace property declaration of new state with direct new

- class: [`Rector\Php81\Rector\ClassMethod\NewInInitializerRector`](../rules/Php81/Rector/ClassMethod/NewInInitializerRector.php)

```diff
 class SomeClass
 {
-    private Logger $logger;
-
     public function __construct(
-        ?Logger $logger = null,
+        private Logger $logger = new NullLogger,
     ) {
-        $this->logger = $logger ?? new NullLogger;
     }
 }
```

<br>

### NullToStrictStringFuncCallArgRector

Change null to strict string defined function call args

- class: [`Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector`](../rules/Php81/Rector/FuncCall/NullToStrictStringFuncCallArgRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        preg_split("#a#", null);
+        preg_split("#a#", '');
     }
 }
```

<br>

### ReadOnlyPropertyRector

Decorate read-only property with `readonly` attribute

- class: [`Rector\Php81\Rector\Property\ReadOnlyPropertyRector`](../rules/Php81/Rector/Property/ReadOnlyPropertyRector.php)

```diff
 class SomeClass
 {
     public function __construct(
-        private string $name
+        private readonly string $name
     ) {
     }

     public function getName()
     {
         return $this->name;
     }
 }
```

<br>

### SpatieEnumClassToEnumRector

Refactor Spatie enum class to native Enum

:wrench: **configure it!**

- class: [`Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector`](../rules/Php81/Rector/Class_/SpatieEnumClassToEnumRector.php)

```diff
-use \Spatie\Enum\Enum;
-
-/**
- * @method static self draft()
- * @method static self published()
- * @method static self archived()
- */
-class StatusEnum extends Enum
+enum StatusEnum : string
 {
+    case DRAFT = 'draft';
+    case PUBLISHED = 'published';
+    case ARCHIVED = 'archived';
 }
```

<br>

### SpatieEnumMethodCallToEnumConstRector

Refactor Spatie enum method calls

- class: [`Rector\Php81\Rector\MethodCall\SpatieEnumMethodCallToEnumConstRector`](../rules/Php81/Rector/MethodCall/SpatieEnumMethodCallToEnumConstRector.php)

```diff
-$value1 = SomeEnum::SOME_CONSTANT()->getValue();
-$value2 = SomeEnum::SOME_CONSTANT()->value;
-$name1 = SomeEnum::SOME_CONSTANT()->getName();
-$name2 = SomeEnum::SOME_CONSTANT()->name;
+$value1 = SomeEnum::SOME_CONSTANT->value;
+$value2 = SomeEnum::SOME_CONSTANT->value;
+$name1 = SomeEnum::SOME_CONSTANT->name;
+$name2 = SomeEnum::SOME_CONSTANT->name;
```

<br>

## Php82

### AddSensitiveParameterAttributeRector

Add SensitiveParameter attribute to method and function configured parameters

:wrench: **configure it!**

- class: [`Rector\Php82\Rector\Param\AddSensitiveParameterAttributeRector`](../rules/Php82/Rector/Param/AddSensitiveParameterAttributeRector.php)

```diff
 class SomeClass
 {
-    public function run(string $password)
+    public function run(#[\SensitiveParameter] string $password)
     {
     }
 }
```

<br>

### FilesystemIteratorSkipDotsRector

Prior PHP 8.2 FilesystemIterator::SKIP_DOTS was always set and could not be removed, therefore FilesystemIterator::SKIP_DOTS is added in order to keep this behaviour.

- class: [`Rector\Php82\Rector\New_\FilesystemIteratorSkipDotsRector`](../rules/Php82/Rector/New_/FilesystemIteratorSkipDotsRector.php)

```diff
-new FilesystemIterator(__DIR__, FilesystemIterator::KEY_AS_FILENAME);
+new FilesystemIterator(__DIR__, FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::SKIP_DOTS);
```

<br>

### ReadOnlyClassRector

Decorate read-only class with `readonly` attribute

- class: [`Rector\Php82\Rector\Class_\ReadOnlyClassRector`](../rules/Php82/Rector/Class_/ReadOnlyClassRector.php)

```diff
-final class SomeClass
+final readonly class SomeClass
 {
     public function __construct(
-        private readonly string $name
+        private string $name
     ) {
     }
 }
```

<br>

### Utf8DecodeEncodeToMbConvertEncodingRector

Change deprecated utf8_decode and utf8_encode to mb_convert_encoding

- class: [`Rector\Php82\Rector\FuncCall\Utf8DecodeEncodeToMbConvertEncodingRector`](../rules/Php82/Rector/FuncCall/Utf8DecodeEncodeToMbConvertEncodingRector.php)

```diff
-utf8_decode($value);
-utf8_encode($value);
+mb_convert_encoding($value, 'ISO-8859-1');
+mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
```

<br>

### VariableInStringInterpolationFixerRector

Replace deprecated "${var}" to "{$var}"

- class: [`Rector\Php82\Rector\Encapsed\VariableInStringInterpolationFixerRector`](../rules/Php82/Rector/Encapsed/VariableInStringInterpolationFixerRector.php)

```diff
 $c = "football";
-echo "I like playing ${c}";
+echo "I like playing {$c}";
```

<br>

## Php83

### AddOverrideAttributeToOverriddenMethodsRector

Add override attribute to overridden methods

- class: [`Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector`](../rules/Php83/Rector/ClassMethod/AddOverrideAttributeToOverriddenMethodsRector.php)

```diff
 class ParentClass
 {
     public function foo()
     {
     }
 }

 class ChildClass extends ParentClass
 {
+    #[\Override]
     public function foo()
     {
     }
 }
```

<br>

### AddTypeToConstRector

Add type to constants based on their value

- class: [`Rector\Php83\Rector\ClassConst\AddTypeToConstRector`](../rules/Php83/Rector/ClassConst/AddTypeToConstRector.php)

```diff
 final class SomeClass
 {
-    public const TYPE = 'some_type';
+    public const string TYPE = 'some_type';
 }
```

<br>

### CombineHostPortLdapUriRector

Combine separated host and port on `ldap_connect()` args

- class: [`Rector\Php83\Rector\FuncCall\CombineHostPortLdapUriRector`](../rules/Php83/Rector/FuncCall/CombineHostPortLdapUriRector.php)

```diff
-ldap_connect('ldap://ldap.example.com', 389);
+ldap_connect('ldap://ldap.example.com:389');
```

<br>

## Php84

### ExplicitNullableParamTypeRector

Make implicit nullable param to explicit

- class: [`Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector`](../rules/Php84/Rector/Param/ExplicitNullableParamTypeRector.php)

```diff
-function foo(string $param = null) {}
+function foo(?string $param = null) {}
```

<br>

## Privatization

### FinalizeTestCaseClassRector

PHPUnit test case will be finalized

- class: [`Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector`](../rules/Privatization/Rector/Class_/FinalizeTestCaseClassRector.php)

```diff
 use PHPUnit\Framework\TestCase;

-class SomeClass extends TestCase
+final class SomeClass extends TestCase
 {
 }
```

<br>

### PrivatizeFinalClassMethodRector

Change protected class method to private if possible

- class: [`Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector`](../rules/Privatization/Rector/ClassMethod/PrivatizeFinalClassMethodRector.php)

```diff
 final class SomeClass
 {
-    protected function someMethod()
+    private function someMethod()
     {
     }
 }
```

<br>

### PrivatizeFinalClassPropertyRector

Change property to private if possible

- class: [`Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector`](../rules/Privatization/Rector/Property/PrivatizeFinalClassPropertyRector.php)

```diff
 final class SomeClass
 {
-    protected $value;
+    private $value;
 }
```

<br>

### PrivatizeLocalGetterToPropertyRector

Privatize getter of local property to property

- class: [`Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector`](../rules/Privatization/Rector/MethodCall/PrivatizeLocalGetterToPropertyRector.php)

```diff
 class SomeClass
 {
     private $some;

     public function run()
     {
-        return $this->getSome() + 5;
+        return $this->some + 5;
     }

     private function getSome()
     {
         return $this->some;
     }
 }
```

<br>

## Removing

### ArgumentRemoverRector

Removes defined arguments in defined methods and their calls.

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector`](../rules/Removing/Rector/ClassMethod/ArgumentRemoverRector.php)

```diff
 $someObject = new SomeClass;
-$someObject->someMethod(true);
+$someObject->someMethod();
```

<br>

### RemoveFuncCallArgRector

Remove argument by position by function name

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector`](../rules/Removing/Rector/FuncCall/RemoveFuncCallArgRector.php)

```diff
-remove_last_arg(1, 2);
+remove_last_arg(1);
```

<br>

### RemoveFuncCallRector

Remove function

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\FuncCall\RemoveFuncCallRector`](../rules/Removing/Rector/FuncCall/RemoveFuncCallRector.php)

```diff
-$x = 'something';
-var_dump($x);
+$x = 'something';
```

<br>

### RemoveInterfacesRector

Removes interfaces usage from class.

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\Class_\RemoveInterfacesRector`](../rules/Removing/Rector/Class_/RemoveInterfacesRector.php)

```diff
-class SomeClass implements SomeInterface
+class SomeClass
 {
 }
```

<br>

### RemoveTraitUseRector

Remove specific traits from code

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\Class_\RemoveTraitUseRector`](../rules/Removing/Rector/Class_/RemoveTraitUseRector.php)

```diff
 class SomeClass
 {
-    use SomeTrait;
 }
```

<br>

## Renaming

### RenameAnnotationRector

Turns defined annotations above properties and methods to their new values.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector`](../rules/Renaming/Rector/ClassMethod/RenameAnnotationRector.php)

```diff
 use PHPUnit\Framework\TestCase;

 final class SomeTest extends TestCase
 {
     /**
-     * @test
+     * @scenario
      */
     public function someMethod()
     {
     }
 }
```

<br>

### RenameAttributeRector

Rename attribute class names

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\Class_\RenameAttributeRector`](../rules/Renaming/Rector/Class_/RenameAttributeRector.php)

```diff
-#[SimpleRoute()]
+#[BasicRoute()]
 class SomeClass
 {
 }
```

<br>

### RenameClassConstFetchRector

Replaces defined class constants in their calls.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector`](../rules/Renaming/Rector/ClassConstFetch/RenameClassConstFetchRector.php)

```diff
-$value = SomeClass::OLD_CONSTANT;
-$value = SomeClass::OTHER_OLD_CONSTANT;
+$value = SomeClass::NEW_CONSTANT;
+$value = DifferentClass::NEW_CONSTANT;
```

<br>

### RenameClassRector

Replaces defined classes by new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\Name\RenameClassRector`](../rules/Renaming/Rector/Name/RenameClassRector.php)

```diff
 namespace App;

-use SomeOldClass;
+use SomeNewClass;

-function someFunction(SomeOldClass $someOldClass): SomeOldClass
+function someFunction(SomeNewClass $someOldClass): SomeNewClass
 {
-    if ($someOldClass instanceof SomeOldClass) {
-        return new SomeOldClass;
+    if ($someOldClass instanceof SomeNewClass) {
+        return new SomeNewClass;
     }
 }
```

<br>

### RenameConstantRector

Replace constant by new ones

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ConstFetch\RenameConstantRector`](../rules/Renaming/Rector/ConstFetch/RenameConstantRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        return MYSQL_ASSOC;
+        return MYSQLI_ASSOC;
     }
 }
```

<br>

### RenameFunctionLikeParamWithinCallLikeArgRector

Rename param within closures and arrow functions based on use with specified method calls

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\FunctionLike\RenameFunctionLikeParamWithinCallLikeArgRector`](../rules/Renaming/Rector/FunctionLike/RenameFunctionLikeParamWithinCallLikeArgRector.php)

```diff
-(new SomeClass)->process(function ($param) {});
+(new SomeClass)->process(function ($parameter) {});
```

<br>

### RenameFunctionRector

Turns defined function call new one.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\FuncCall\RenameFunctionRector`](../rules/Renaming/Rector/FuncCall/RenameFunctionRector.php)

```diff
-view("...", []);
+Laravel\Templating\render("...", []);
```

<br>

### RenameMethodRector

Turns method names to new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\MethodCall\RenameMethodRector`](../rules/Renaming/Rector/MethodCall/RenameMethodRector.php)

```diff
 $someObject = new SomeExampleClass;
-$someObject->oldMethod();
+$someObject->newMethod();
```

<br>

### RenamePropertyRector

Replaces defined old properties by new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector`](../rules/Renaming/Rector/PropertyFetch/RenamePropertyRector.php)

```diff
-$someObject->someOldProperty;
+$someObject->someNewProperty;
```

<br>

### RenameStaticMethodRector

Turns method names to new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector`](../rules/Renaming/Rector/StaticCall/RenameStaticMethodRector.php)

```diff
-SomeClass::oldStaticMethod();
+AnotherExampleClass::newStaticMethod();
```

<br>

### RenameStringRector

Change string value

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\String_\RenameStringRector`](../rules/Renaming/Rector/String_/RenameStringRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return 'ROLE_PREVIOUS_ADMIN';
+        return 'IS_IMPERSONATOR';
     }
 }
```

<br>

## Strict

### BooleanInBooleanNotRuleFixerRector

Fixer for PHPStan reports by strict type rule - "PHPStan\Rules\BooleansInConditions\BooleanInBooleanNotRule"

:wrench: **configure it!**

- class: [`Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector`](../rules/Strict/Rector/BooleanNot/BooleanInBooleanNotRuleFixerRector.php)

```diff
 class SomeClass
 {
     public function run(string|null $name)
     {
-        if (! $name) {
+        if ($name === null) {
             return 'no name';
         }

         return 'name';
     }
 }
```

<br>

### BooleanInIfConditionRuleFixerRector

Fixer for PHPStan reports by strict type rule - "PHPStan\Rules\BooleansInConditions\BooleanInIfConditionRule"

:wrench: **configure it!**

- class: [`Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector`](../rules/Strict/Rector/If_/BooleanInIfConditionRuleFixerRector.php)

```diff
 final class NegatedString
 {
     public function run(string $name)
     {
-        if ($name) {
+        if ($name !== '') {
             return 'name';
         }

         return 'no name';
     }
 }
```

<br>

### BooleanInTernaryOperatorRuleFixerRector

Fixer for PHPStan reports by strict type rule - "PHPStan\Rules\BooleansInConditions\BooleanInTernaryOperatorRule"

:wrench: **configure it!**

- class: [`Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector`](../rules/Strict/Rector/Ternary/BooleanInTernaryOperatorRuleFixerRector.php)

```diff
 final class ArrayCompare
 {
     public function run(array $data)
     {
-        return $data ? 1 : 2;
+        return $data !== [] ? 1 : 2;
     }
 }
```

<br>

### DisallowedEmptyRuleFixerRector

Fixer for PHPStan reports by strict type rule - "PHPStan\Rules\DisallowedConstructs\DisallowedEmptyRule"

:wrench: **configure it!**

- class: [`Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector`](../rules/Strict/Rector/Empty_/DisallowedEmptyRuleFixerRector.php)

```diff
 final class SomeEmptyArray
 {
     public function run(array $items)
     {
-        return empty($items);
+        return $items === [];
     }
 }
```

<br>

### DisallowedShortTernaryRuleFixerRector

Fixer for PHPStan reports by strict type rule - "PHPStan\Rules\DisallowedConstructs\DisallowedShortTernaryRule"

:wrench: **configure it!**

- class: [`Rector\Strict\Rector\Ternary\DisallowedShortTernaryRuleFixerRector`](../rules/Strict/Rector/Ternary/DisallowedShortTernaryRuleFixerRector.php)

```diff
 final class ShortTernaryArray
 {
     public function run(array $array)
     {
-        return $array ?: 2;
+        return $array !== [] ? $array : 2;
     }
 }
```

<br>

## Transform

### AddAllowDynamicPropertiesAttributeRector

Add the `AllowDynamicProperties` attribute to all classes

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\AddAllowDynamicPropertiesAttributeRector`](../rules/Transform/Rector/Class_/AddAllowDynamicPropertiesAttributeRector.php)

```diff
 namespace Example\Domain;

+#[AllowDynamicProperties]
 class SomeObject {
     public string $someProperty = 'hello world';
 }
```

<br>

### AddInterfaceByTraitRector

Add interface by used trait

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\AddInterfaceByTraitRector`](../rules/Transform/Rector/Class_/AddInterfaceByTraitRector.php)

```diff
-class SomeClass
+class SomeClass implements SomeInterface
 {
     use SomeTrait;
 }
```

<br>

### ArrayDimFetchToMethodCallRector

Change array dim fetch to method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ArrayDimFetch\ArrayDimFetchToMethodCallRector`](../rules/Transform/Rector/ArrayDimFetch/ArrayDimFetchToMethodCallRector.php)

```diff
-$app['someService'];
+$app->make('someService');
```

<br>

### AttributeKeyToClassConstFetchRector

Replace key value on specific attribute to class constant

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Attribute\AttributeKeyToClassConstFetchRector`](../rules/Transform/Rector/Attribute/AttributeKeyToClassConstFetchRector.php)

```diff
 use Doctrine\ORM\Mapping\Column;
+use Doctrine\DBAL\Types\Types;

 class SomeClass
 {
-    #[Column(type: "string")]
+    #[Column(type: Types::STRING)]
     public $name;
 }
```

<br>

### ConstFetchToClassConstFetchRector

Change const fetch to class const fetch

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ConstFetch\ConstFetchToClassConstFetchRector`](../rules/Transform/Rector/ConstFetch/ConstFetchToClassConstFetchRector.php)

```diff
-$x = CONTEXT_COURSE
+$x = course::LEVEL
```

<br>

### FuncCallToConstFetchRector

Changes use of function calls to use constants

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector`](../rules/Transform/Rector/FuncCall/FuncCallToConstFetchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = php_sapi_name();
+        $value = PHP_SAPI;
     }
 }
```

<br>

### FuncCallToMethodCallRector

Turns defined function calls to local method calls.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector`](../rules/Transform/Rector/FuncCall/FuncCallToMethodCallRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var \Namespaced\SomeRenderer
+     */
+    private $someRenderer;
+
+    public function __construct(\Namespaced\SomeRenderer $someRenderer)
+    {
+        $this->someRenderer = $someRenderer;
+    }
+
     public function run()
     {
-        view('...');
+        $this->someRenderer->view('...');
     }
 }
```

<br>

### FuncCallToNewRector

Change configured function calls to new Instance

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToNewRector`](../rules/Transform/Rector/FuncCall/FuncCallToNewRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $array = collection([]);
+        $array = new \Collection([]);
     }
 }
```

<br>

### FuncCallToStaticCallRector

Turns defined function call to static method call.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector`](../rules/Transform/Rector/FuncCall/FuncCallToStaticCallRector.php)

```diff
-view("...", []);
+SomeClass::render("...", []);
```

<br>

### MergeInterfacesRector

Merges old interface to a new one, that already has its methods

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\MergeInterfacesRector`](../rules/Transform/Rector/Class_/MergeInterfacesRector.php)

```diff
-class SomeClass implements SomeInterface, SomeOldInterface
+class SomeClass implements SomeInterface
 {
 }
```

<br>

### MethodCallToFuncCallRector

Change method call to function call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToFuncCallRector`](../rules/Transform/Rector/MethodCall/MethodCallToFuncCallRector.php)

```diff
 final class SomeClass
 {
     public function show()
     {
-        return $this->render('some_template');
+        return view('some_template');
     }
 }
```

<br>

### MethodCallToPropertyFetchRector

Turns method call `"$this->something()"` to property fetch "$this->something"

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector`](../rules/Transform/Rector/MethodCall/MethodCallToPropertyFetchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $this->someMethod();
+        $this->someProperty;
     }
 }
```

<br>

### MethodCallToStaticCallRector

Change method call to desired static call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector`](../rules/Transform/Rector/MethodCall/MethodCallToStaticCallRector.php)

```diff
 final class SomeClass
 {
     private $anotherDependency;

     public function __construct(AnotherDependency $anotherDependency)
     {
         $this->anotherDependency = $anotherDependency;
     }

     public function loadConfiguration()
     {
-        return $this->anotherDependency->process('value');
+        return StaticCaller::anotherMethod('value');
     }
 }
```

<br>

### NewToStaticCallRector

Change new Object to static call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\New_\NewToStaticCallRector`](../rules/Transform/Rector/New_/NewToStaticCallRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        new Cookie($name);
+        Cookie::create($name);
     }
 }
```

<br>

### ParentClassToTraitsRector

Replaces parent class to specific traits

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\ParentClassToTraitsRector`](../rules/Transform/Rector/Class_/ParentClassToTraitsRector.php)

```diff
-class SomeClass extends Nette\Object
+class SomeClass
 {
+    use Nette\SmartObject;
 }
```

<br>

### PropertyAssignToMethodCallRector

Turns property assign of specific type and property name to method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector`](../rules/Transform/Rector/Assign/PropertyAssignToMethodCallRector.php)

```diff
 $someObject = new SomeClass;
-$someObject->oldProperty = false;
+$someObject->newMethodCall(false);
```

<br>

### PropertyFetchToMethodCallRector

Replaces properties assign calls be defined methods.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector`](../rules/Transform/Rector/Assign/PropertyFetchToMethodCallRector.php)

```diff
-$result = $object->property;
-$object->property = $value;
+$result = $object->getProperty();
+$object->setProperty($value);

-$bare = $object->bareProperty;
+$bare = $object->getConfig('someArg');
```

<br>

### RectorConfigBuilderRector

Change RectorConfig to RectorConfigBuilder

- class: [`Rector\Transform\Rector\FileWithoutNamespace\RectorConfigBuilderRector`](../rules/Transform/Rector/FileWithoutNamespace/RectorConfigBuilderRector.php)

```diff
-return static function (RectorConfig $rectorConfig): void {
-    $rectorConfig->rule(SomeRector::class);
-};
+return RectorConfig::configure()->rules([SomeRector::class]);
```

<br>

### ReplaceParentCallByPropertyCallRector

Changes method calls in child of specific types to defined property method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector`](../rules/Transform/Rector/MethodCall/ReplaceParentCallByPropertyCallRector.php)

```diff
 final class SomeClass
 {
     public function run(SomeTypeToReplace $someTypeToReplace)
     {
-        $someTypeToReplace->someMethodCall();
+        $this->someProperty->someMethodCall();
     }
 }
```

<br>

### ReturnTypeWillChangeRector

Add #[\ReturnTypeWillChange] attribute to configured instanceof class with methods

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ClassMethod\ReturnTypeWillChangeRector`](../rules/Transform/Rector/ClassMethod/ReturnTypeWillChangeRector.php)

```diff
 class SomeClass implements ArrayAccess
 {
+    #[\ReturnTypeWillChange]
     public function offsetGet($offset)
     {
     }
 }
```

<br>

### StaticCallToFuncCallRector

Turns static call to function call.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector`](../rules/Transform/Rector/StaticCall/StaticCallToFuncCallRector.php)

```diff
-OldClass::oldMethod("args");
+new_function("args");
```

<br>

### StaticCallToMethodCallRector

Change static call to service method via constructor injection

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector`](../rules/Transform/Rector/StaticCall/StaticCallToMethodCallRector.php)

```diff
-use Nette\Utils\FileSystem;
+use App\Custom\SmartFileSystem;

 class SomeClass
 {
+    /**
+     * @var SmartFileSystem
+     */
+    private $smartFileSystem;
+
+    public function __construct(SmartFileSystem $smartFileSystem)
+    {
+        $this->smartFileSystem = $smartFileSystem;
+    }
+
     public function run()
     {
-        return FileSystem::write('file', 'content');
+        return $this->smartFileSystem->dumpFile('file', 'content');
     }
 }
```

<br>

### StaticCallToNewRector

Change static call to new instance

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToNewRector`](../rules/Transform/Rector/StaticCall/StaticCallToNewRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $dotenv = JsonResponse::create(['foo' => 'bar'], Response::HTTP_OK);
+        $dotenv = new JsonResponse(['foo' => 'bar'], Response::HTTP_OK);
     }
 }
```

<br>

### StringToClassConstantRector

Changes strings to specific constants

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\String_\StringToClassConstantRector`](../rules/Transform/Rector/String_/StringToClassConstantRector.php)

```diff
 final class SomeSubscriber
 {
     public static function getSubscribedEvents()
     {
-        return ['compiler.post_dump' => 'compile'];
+        return [\Yet\AnotherClass::CONSTANT => 'compile'];
     }
 }
```

<br>

### WrapReturnRector

Wrap return value of specific method

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ClassMethod\WrapReturnRector`](../rules/Transform/Rector/ClassMethod/WrapReturnRector.php)

```diff
 final class SomeClass
 {
     public function getItem()
     {
-        return 1;
+        return [1];
     }
 }
```

<br>

## TypeDeclaration

### AddArrowFunctionReturnTypeRector

Add known return type to arrow function

- class: [`Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector`](../rules/TypeDeclaration/Rector/ArrowFunction/AddArrowFunctionReturnTypeRector.php)

```diff
-fn () => [];
+fn (): array => [];
```

<br>

### AddClosureNeverReturnTypeRector

Add "never" return-type for closure that never return anything

- class: [`Rector\TypeDeclaration\Rector\Closure\AddClosureNeverReturnTypeRector`](../rules/TypeDeclaration/Rector/Closure/AddClosureNeverReturnTypeRector.php)

```diff
-function () {
+function (): never {
     throw new InvalidException();
 }
```

<br>

### AddClosureVoidReturnTypeWhereNoReturnRector

Add closure return type void if there is no return

- class: [`Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector`](../rules/TypeDeclaration/Rector/Closure/AddClosureVoidReturnTypeWhereNoReturnRector.php)

```diff
-function () {
+function (): void {
 };
```

<br>

### AddFunctionVoidReturnTypeWhereNoReturnRector

Add function return type void if there is no return

- class: [`Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector`](../rules/TypeDeclaration/Rector/Function_/AddFunctionVoidReturnTypeWhereNoReturnRector.php)

```diff
-function restore() {
+function restore(): void {
 }
```

<br>

### AddMethodCallBasedStrictParamTypeRector

Change private method param type to strict type, based on passed strict types

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddMethodCallBasedStrictParamTypeRector.php)

```diff
 final class SomeClass
 {
     public function run(int $value)
     {
         $this->resolve($value);
     }

-    private function resolve($value)
+    private function resolve(int $value)
     {
     }
 }
```

<br>

### AddParamTypeBasedOnPHPUnitDataProviderRector

Adds param type declaration based on PHPUnit provider return type declaration

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeBasedOnPHPUnitDataProviderRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddParamTypeBasedOnPHPUnitDataProviderRector.php)

```diff
 use PHPUnit\Framework\TestCase;

 final class SomeTest extends TestCase
 {
     /**
      * @dataProvider provideData()
      */
-    public function test($value)
+    public function test(string $value)
     {
     }

     public static function provideData()
     {
         yield ['name'];
     }
 }
```

<br>

### AddParamTypeDeclarationRector

Add param types where needed

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddParamTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function process($name)
+    public function process(string $name)
     {
     }
 }
```

<br>

### AddParamTypeForFunctionLikeWithinCallLikeArgDeclarationRector

Add param types where needed

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\FunctionLike\AddParamTypeForFunctionLikeWithinCallLikeArgDeclarationRector`](../rules/TypeDeclaration/Rector/FunctionLike/AddParamTypeForFunctionLikeWithinCallLikeArgDeclarationRector.php)

```diff
-(new SomeClass)->process(function ($parameter) {});
+(new SomeClass)->process(function (string $parameter) {});
```

<br>

### AddParamTypeFromPropertyTypeRector

Adds param type declaration based on property type the value is assigned to PHPUnit provider return type declaration

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromPropertyTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddParamTypeFromPropertyTypeRector.php)

```diff
 final class SomeClass
 {
     private string $name;

-    public function setName($name)
+    public function setName(string $name)
     {
         $this->name = $name;
     }
 }
```

<br>

### AddParamTypeSplFixedArrayRector

Add exact fixed array type in known cases

- class: [`Rector\TypeDeclaration\Rector\FunctionLike\AddParamTypeSplFixedArrayRector`](../rules/TypeDeclaration/Rector/FunctionLike/AddParamTypeSplFixedArrayRector.php)

```diff
+use PhpCsFixer\Tokenizer\Token;
 use PhpCsFixer\Tokenizer\Tokens;

 class SomeClass
 {
+    /**
+     * @param Tokens<Token>
+     */
     public function run(Tokens $tokens)
     {
     }
 }
```

<br>

### AddPropertyTypeDeclarationRector

Add type to property by added rules, mostly public/property by parent type

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\Property\AddPropertyTypeDeclarationRector`](../rules/TypeDeclaration/Rector/Property/AddPropertyTypeDeclarationRector.php)

```diff
 class SomeClass extends ParentClass
 {
-    public $name;
+    public string $name;
 }
```

<br>

### AddReturnTypeDeclarationBasedOnParentClassMethodRector

Add missing return type declaration based on parent class method

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationBasedOnParentClassMethodRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddReturnTypeDeclarationBasedOnParentClassMethodRector.php)

```diff
 class A
 {
     public function execute(): int
     {
     }
 }

 class B extends A{
-    public function execute()
+    public function execute(): int
     {
     }
 }
```

<br>

### AddReturnTypeDeclarationFromYieldsRector

Add return type declarations from yields

- class: [`Rector\TypeDeclaration\Rector\FunctionLike\AddReturnTypeDeclarationFromYieldsRector`](../rules/TypeDeclaration/Rector/FunctionLike/AddReturnTypeDeclarationFromYieldsRector.php)

```diff
 class SomeClass
 {
-    public function provide()
+    /**
+     * @return Iterator<int>
+     */
+    public function provide(): Iterator
     {
         yield 1;
     }
 }
```

<br>

### AddReturnTypeDeclarationRector

Changes defined return typehint of method and class.

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddReturnTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function getData()
+    public function getData(): array
     {
     }
 }
```

<br>

### AddTestsVoidReturnTypeWhereNoReturnRector

Add void to PHPUnit test methods

- class: [`Rector\TypeDeclaration\Rector\Class_\AddTestsVoidReturnTypeWhereNoReturnRector`](../rules/TypeDeclaration/Rector/Class_/AddTestsVoidReturnTypeWhereNoReturnRector.php)

```diff
 use PHPUnit\Framework\TestCase;

 class SomeClass extends TestCase
 {
-    public function testSomething()
+    public function testSomething(): void
     {
     }
 }
```

<br>

### AddTypeFromResourceDocblockRector

Add param and return types on resource docblock

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddTypeFromResourceDocblockRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddTypeFromResourceDocblockRector.php)

```diff
 class SomeClass
 {
-    /**
-     * @param resource|null $resource
-     */
-    public function setResource($resource)
+    public function setResource(?App\ValueObject\Resource $resource)
     {
     }

-    /**
-     * @return resource|null
-     */
-    public function getResource()
+    public function getResource(): ?App\ValueObject\Resource
     {
     }
 }
```

<br>

### AddVoidReturnTypeWhereNoReturnRector

Add return type void to function like without any return

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddVoidReturnTypeWhereNoReturnRector.php)

```diff
 final class SomeClass
 {
-    public function getValues()
+    public function getValues(): void
     {
         $value = 1000;
         return;
     }
 }
```

<br>

### BinaryOpNullableToInstanceofRector

Change && and || between nullable objects to instanceof compares

- class: [`Rector\TypeDeclaration\Rector\BooleanAnd\BinaryOpNullableToInstanceofRector`](../rules/TypeDeclaration/Rector/BooleanAnd/BinaryOpNullableToInstanceofRector.php)

```diff
 function someFunction(?SomeClass $someClass)
 {
-    if ($someClass && $someClass->someMethod()) {
+    if ($someClass instanceof SomeClass && $someClass->someMethod()) {
         return 'yes';
     }

     return 'no';
 }
```

<br>

### BoolReturnTypeFromBooleanConstReturnsRector

Add return bool, based on direct true/false returns

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanConstReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/BoolReturnTypeFromBooleanConstReturnsRector.php)

```diff
 class SomeClass
 {
-    public function resolve($value)
+    public function resolve($value): bool
     {
         if ($value) {
             return false;
         }

         return true;
     }
 }
```

<br>

### BoolReturnTypeFromBooleanStrictReturnsRector

Add bool return type based on strict bool returns type operations

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanStrictReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/BoolReturnTypeFromBooleanStrictReturnsRector.php)

```diff
 class SomeClass
 {
-    public function resolve($first, $second)
+    public function resolve($first, $second): bool
     {
         return $first > $second;
     }
 }
```

<br>

### ChildDoctrineRepositoryClassTypeRector

Add return type to classes that extend `Doctrine\ORM\EntityRepository` based on return Doctrine method names

- class: [`Rector\TypeDeclaration\Rector\Class_\ChildDoctrineRepositoryClassTypeRector`](../rules/TypeDeclaration/Rector/Class_/ChildDoctrineRepositoryClassTypeRector.php)

```diff
 use Doctrine\ORM\EntityRepository;

 /**
  * @extends EntityRepository<SomeType>
  */
 final class SomeRepository extends EntityRepository
 {
-    public function getActiveItem()
+    public function getActiveItem(): ?SomeType
     {
         return $this->findOneBy([
             'something'
         ]);
     }
 }
```

<br>

### ClosureReturnTypeRector

Add return type to closures based on known return values

- class: [`Rector\TypeDeclaration\Rector\Closure\ClosureReturnTypeRector`](../rules/TypeDeclaration/Rector/Closure/ClosureReturnTypeRector.php)

```diff
-function () {
+function (): int {
     return 100;
 };
```

<br>

### DeclareStrictTypesRector

Add declare(strict_types=1) if missing

- class: [`Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector`](../rules/TypeDeclaration/Rector/StmtsAwareInterface/DeclareStrictTypesRector.php)

```diff
+declare(strict_types=1);
+
 function someFunction()
 {
 }
```

<br>

### EmptyOnNullableObjectToInstanceOfRector

Change `empty()` on nullable object to instanceof check

- class: [`Rector\TypeDeclaration\Rector\Empty_\EmptyOnNullableObjectToInstanceOfRector`](../rules/TypeDeclaration/Rector/Empty_/EmptyOnNullableObjectToInstanceOfRector.php)

```diff
 class SomeClass
 {
     public function run(?AnotherObject $anotherObject)
     {
-        if (empty($anotherObject)) {
+        if (! $anotherObject instanceof AnotherObject) {
             return false;
         }

         return true;
     }
 }
```

<br>

### IncreaseDeclareStrictTypesRector

Add declare strict types to a limited amount of classes at a time, to try out in the wild and increase level gradually

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\StmtsAwareInterface\IncreaseDeclareStrictTypesRector`](../rules/TypeDeclaration/Rector/StmtsAwareInterface/IncreaseDeclareStrictTypesRector.php)

```diff
+declare(strict_types=1);
+
 function someFunction()
 {
 }
```

<br>

### MergeDateTimePropertyTypeDeclarationRector

Set DateTime to DateTimeInterface for DateTime property with DateTimeInterface docblock

- class: [`Rector\TypeDeclaration\Rector\Class_\MergeDateTimePropertyTypeDeclarationRector`](../rules/TypeDeclaration/Rector/Class_/MergeDateTimePropertyTypeDeclarationRector.php)

```diff
 final class SomeClass
 {
-    /**
-     * @var DateTimeInterface
-     */
-    private DateTime $dateTime;
+    private DateTimeInterface $dateTime;
 }
```

<br>

### NumericReturnTypeFromStrictReturnsRector

Add int/float return type based on strict typed returns

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/NumericReturnTypeFromStrictReturnsRector.php)

```diff
 class SomeClass
 {
-    public function increase($value)
+    public function increase($value): int
     {
         return ++$value;
     }
 }
```

<br>

### NumericReturnTypeFromStrictScalarReturnsRector

Add int/float return type based on strict scalar returns type

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictScalarReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/NumericReturnTypeFromStrictScalarReturnsRector.php)

```diff
 class SomeClass
 {
-    public function getNumber()
+    public function getNumber(): int
     {
         return 200;
     }
 }
```

<br>

### ParamTypeByMethodCallTypeRector

Change param type based on passed method call type

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ParamTypeByMethodCallTypeRector.php)

```diff
 class SomeTypedService
 {
     public function run(string $name)
     {
     }
 }

 final class UseDependency
 {
     public function __construct(
         private SomeTypedService $someTypedService
     ) {
     }

-    public function go($value)
+    public function go(string $value)
     {
         $this->someTypedService->run($value);
     }
 }
```

<br>

### ParamTypeByParentCallTypeRector

Change param type based on parent param type

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByParentCallTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ParamTypeByParentCallTypeRector.php)

```diff
 class SomeControl
 {
     public function __construct(string $name)
     {
     }
 }

 class VideoControl extends SomeControl
 {
-    public function __construct($name)
+    public function __construct(string $name)
     {
         parent::__construct($name);
     }
 }
```

<br>

### PropertyTypeFromStrictSetterGetterRector

Add property type based on strict setter and getter method

- class: [`Rector\TypeDeclaration\Rector\Class_\PropertyTypeFromStrictSetterGetterRector`](../rules/TypeDeclaration/Rector/Class_/PropertyTypeFromStrictSetterGetterRector.php)

```diff
 final class SomeClass
 {
-    private $name = 'John';
+    private string $name = 'John';

     public function setName(string $name): void
     {
         $this->name = $name;
     }

     public function getName(): string
     {
         return $this->name;
     }
 }
```

<br>

### ReturnNeverTypeRector

Add "never" return-type for methods that never return anything

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnNeverTypeRector.php)

```diff
 final class SomeClass
 {
-    public function run()
+    public function run(): never
     {
         throw new InvalidException();
     }
 }
```

<br>

### ReturnNullableTypeRector

Add basic ? nullable type to class methods and functions, as of PHP 7.1

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnNullableTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnNullableTypeRector.php)

```diff
 final class SomeClass
 {
-    public function getData()
+    public function getData(): ?int
     {
         if (rand(0, 1)) {
             return null;
         }

         return 100;
     }
 }
```

<br>

### ReturnTypeFromMockObjectRector

Add known property and return MockObject types

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromMockObjectRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromMockObjectRector.php)

```diff
 class SomeTest extends TestCase
 {
-    public function createSomeMock()
+    public function createSomeMock(): \PHPUnit\Framework\MockObject\MockObject
     {
         $someMock = $this->createMock(SomeClass::class);
         return $someMock;
     }
 }
```

<br>

### ReturnTypeFromReturnCastRector

Add return type to function like with return cast

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnCastRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromReturnCastRector.php)

```diff
 final class SomeClass
 {
-    public function action($param)
+    public function action($param): array
     {
         try {
             return (array) $param;
         } catch (Exception $exception) {
             // some logging
             throw $exception;
         }
     }
 }
```

<br>

### ReturnTypeFromReturnDirectArrayRector

Add return type from return direct array

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromReturnDirectArrayRector.php)

```diff
 final class AddReturnArray
 {
-    public function getArray()
+    public function getArray(): array
     {
         return [1, 2, 3];
     }
 }
```

<br>

### ReturnTypeFromReturnNewRector

Add return type to function like with return new

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromReturnNewRector.php)

```diff
 final class SomeClass
 {
-    public function create()
+    public function create(): Project
     {
         return new Project();
     }
 }
```

<br>

### ReturnTypeFromStrictConstantReturnRector

Add strict type declaration based on returned constants

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictConstantReturnRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictConstantReturnRector.php)

```diff
 class SomeClass
 {
     public const NAME = 'name';

-    public function run()
+    public function run(): string
     {
         return self::NAME;
     }
 }
```

<br>

### ReturnTypeFromStrictFluentReturnRector

Add return type from strict return `$this`

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictFluentReturnRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictFluentReturnRector.php)

```diff
 final class SomeClass
 {
-    public function run()
+    public function run(): self
     {
         return $this;
     }
 }
```

<br>

### ReturnTypeFromStrictNativeCallRector

Add strict return type based native function or native method

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictNativeCallRector.php)

```diff
 final class SomeClass
 {
-    public function run()
+    public function run(): int
     {
         return strlen('value');
     }
 }
```

<br>

### ReturnTypeFromStrictNewArrayRector

Add strict return array type based on created empty array and returned

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictNewArrayRector.php)

```diff
 final class SomeClass
 {
-    public function run()
+    public function run(): array
     {
         $values = [];

         return $values;
     }
 }
```

<br>

### ReturnTypeFromStrictParamRector

Add return type based on strict parameter type

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictParamRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictParamRector.php)

```diff
 class SomeClass
 {
-    public function resolve(ParamType $item)
+    public function resolve(ParamType $item): ParamType
     {
         return $item;
     }
 }
```

<br>

### ReturnTypeFromStrictTernaryRector

Add method return type based on strict ternary values

- class: [`Rector\TypeDeclaration\Rector\Class_\ReturnTypeFromStrictTernaryRector`](../rules/TypeDeclaration/Rector/Class_/ReturnTypeFromStrictTernaryRector.php)

```diff
 final class SomeClass
 {
-    public function getValue($number)
+    public function getValue($number): int
     {
         return $number ? 100 : 500;
     }
 }
```

<br>

### ReturnTypeFromStrictTypedCallRector

Add return type from strict return type of call

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictTypedCallRector.php)

```diff
 final class SomeClass
 {
-    public function getData()
+    public function getData(): int
     {
         return $this->getNumber();
     }

     private function getNumber(): int
     {
         return 1000;
     }
 }
```

<br>

### ReturnTypeFromStrictTypedPropertyRector

Add return method return type based on strict typed property

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictTypedPropertyRector.php)

```diff
 final class SomeClass
 {
     private int $age = 100;

-    public function getAge()
+    public function getAge(): int
     {
         return $this->age;
     }
 }
```

<br>

### ReturnTypeFromSymfonySerializerRector

Add return type from symfony serializer

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromSymfonySerializerRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromSymfonySerializerRector.php)

```diff
 final class SomeClass
 {
     private \Symfony\Component\Serializer\Serializer $serializer;

-    public function resolveEntity($data)
+    public function resolveEntity($data): SomeType
     {
         return $this->serializer->deserialize($data, SomeType::class, 'json');
     }
 }
```

<br>

### ReturnUnionTypeRector

Add union return type

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnUnionTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnUnionTypeRector.php)

```diff
 final class SomeClass
 {
-    public function getData()
+    public function getData(): null|\DateTime|\stdClass
     {
         if (rand(0, 1)) {
             return null;
         }

         if (rand(0, 1)) {
             return new DateTime('now');
         }

         return new stdClass;
     }
 }
```

<br>

### StrictArrayParamDimFetchRector

Add array type based on array dim fetch use

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector`](../rules/TypeDeclaration/Rector/ClassMethod/StrictArrayParamDimFetchRector.php)

```diff
 class SomeClass
 {
-    public function resolve($item)
+    public function resolve(array $item)
     {
         return $item['name'];
     }
 }
```

<br>

### StrictStringParamConcatRector

Add string type based on concat use

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\StrictStringParamConcatRector`](../rules/TypeDeclaration/Rector/ClassMethod/StrictStringParamConcatRector.php)

```diff
 class SomeClass
 {
-    public function resolve($item)
+    public function resolve(string $item)
     {
         return $item . ' world';
     }
 }
```

<br>

### StringReturnTypeFromStrictScalarReturnsRector

Add string return type based on returned string scalar values

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\StringReturnTypeFromStrictScalarReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/StringReturnTypeFromStrictScalarReturnsRector.php)

```diff
 final class SomeClass
 {
-    public function foo($condition)
+    public function foo($condition): string
     {
         if ($condition) {
             return 'yes';
         }

         return 'no';
     }
 }
```

<br>

### StringReturnTypeFromStrictStringReturnsRector

Add string return type based on returned strict string values

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\StringReturnTypeFromStrictStringReturnsRector`](../rules/TypeDeclaration/Rector/ClassMethod/StringReturnTypeFromStrictStringReturnsRector.php)

```diff
 final class SomeClass
 {
-    public function foo($condition, $value)
+    public function foo($condition, $value): string;
     {
         if ($value) {
             return 'yes';
         }

         return strtoupper($value);
     }
 }
```

<br>

### TypedPropertyFromAssignsRector

Add typed property from assigned types

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector`](../rules/TypeDeclaration/Rector/Property/TypedPropertyFromAssignsRector.php)

```diff
 final class SomeClass
 {
-    private $name;
+    private string|null $name = null;

     public function run()
     {
         $this->name = 'string';
     }
 }
```

<br>

### TypedPropertyFromCreateMockAssignRector

Add typed property from assigned mock

- class: [`Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromCreateMockAssignRector`](../rules/TypeDeclaration/Rector/Class_/TypedPropertyFromCreateMockAssignRector.php)

```diff
 use PHPUnit\Framework\TestCase;

 final class SomeTest extends TestCase
 {
-    private $someProperty;
+    private \PHPUnit\Framework\MockObject\MockObject $someProperty;

     protected function setUp(): void
     {
         $this->someProperty = $this->createMock(SomeMockedClass::class);
     }
 }
```

<br>

### TypedPropertyFromJMSSerializerAttributeTypeRector

Add typed property from JMS Serializer Type attribute

- class: [`Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromJMSSerializerAttributeTypeRector`](../rules/TypeDeclaration/Rector/Class_/TypedPropertyFromJMSSerializerAttributeTypeRector.php)

```diff
 final class SomeClass
 {
     #[\JMS\Serializer\Annotation\Type('string')]
-    private $name;
+    private ?string $name = null;
 }
```

<br>

### TypedPropertyFromStrictConstructorRector

Add typed properties based only on strict constructor types

- class: [`Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector`](../rules/TypeDeclaration/Rector/Property/TypedPropertyFromStrictConstructorRector.php)

```diff
 class SomeObject
 {
-    private $name;
+    private string $name;

     public function __construct(string $name)
     {
         $this->name = $name;
     }
 }
```

<br>

### TypedPropertyFromStrictSetUpRector

Add strict typed property based on `setUp()` strict typed assigns in TestCase

- class: [`Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector`](../rules/TypeDeclaration/Rector/Property/TypedPropertyFromStrictSetUpRector.php)

```diff
 use PHPUnit\Framework\TestCase;

 final class SomeClass extends TestCase
 {
-    private $value;
+    private int $value;

     public function setUp()
     {
         $this->value = 1000;
     }
 }
```

<br>

### WhileNullableToInstanceofRector

Change while null compare to strict instanceof check

- class: [`Rector\TypeDeclaration\Rector\While_\WhileNullableToInstanceofRector`](../rules/TypeDeclaration/Rector/While_/WhileNullableToInstanceofRector.php)

```diff
 final class SomeClass
 {
     public function run(?SomeClass $someClass)
     {
-        while ($someClass !== null) {
+        while ($someClass instanceof SomeClass) {
             // do something
         }
     }
 }
```

<br>

## Visibility

### ChangeConstantVisibilityRector

Change visibility of constant from parent class.

:wrench: **configure it!**

- class: [`Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector`](../rules/Visibility/Rector/ClassConst/ChangeConstantVisibilityRector.php)

```diff
 class FrameworkClass
 {
     protected const SOME_CONSTANT = 1;
 }

 class MyClass extends FrameworkClass
 {
-    public const SOME_CONSTANT = 1;
+    protected const SOME_CONSTANT = 1;
 }
```

<br>

### ChangeMethodVisibilityRector

Change visibility of method from parent class.

:wrench: **configure it!**

- class: [`Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector`](../rules/Visibility/Rector/ClassMethod/ChangeMethodVisibilityRector.php)

```diff
 class FrameworkClass
 {
     protected function someMethod()
     {
     }
 }

 class MyClass extends FrameworkClass
 {
-    public function someMethod()
+    protected function someMethod()
     {
     }
 }
```

<br>

### ExplicitPublicClassMethodRector

Add explicit public method visibility.

- class: [`Rector\Visibility\Rector\ClassMethod\ExplicitPublicClassMethodRector`](../rules/Visibility/Rector/ClassMethod/ExplicitPublicClassMethodRector.php)

```diff
 class SomeClass
 {
-    function foo()
+    public function foo()
     {
     }
 }
```

<br>
