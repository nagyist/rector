<?php

declare (strict_types=1);
namespace Rector\Symfony\Symfony30\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\ArrayItem;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Rector\Symfony\NodeAnalyzer\FormAddMethodCallAnalyzer;
use Rector\Symfony\NodeAnalyzer\FormCollectionAnalyzer;
use Rector\Symfony\NodeAnalyzer\FormInstanceToFormClassConstFetchConverter;
use Rector\Symfony\NodeAnalyzer\FormOptionsArrayMatcher;
use Rector\Symfony\TypeAnalyzer\ControllerAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Best resource with clear example:
 *
 * @changelog https://stackoverflow.com/questions/34027711/passing-data-to-buildform-in-symfony-2-8-3-0
 *
 * @changelog https://github.com/symfony/symfony/commit/adf20c86fb0d8dc2859aa0d2821fe339d3551347
 * @changelog http://www.keganv.com/passing-arguments-controller-file-type-symfony-3/
 * @changelog https://github.com/symfony/symfony/blob/2.8/UPGRADE-2.8.md#form
 *
 * @see \Rector\Symfony\Tests\Symfony30\Rector\MethodCall\FormTypeInstanceToClassConstRector\FormTypeInstanceToClassConstRectorTest
 */
final class FormTypeInstanceToClassConstRector extends AbstractRector
{
    /**
     * @readonly
     */
    private FormInstanceToFormClassConstFetchConverter $formInstanceToFormClassConstFetchConverter;
    /**
     * @readonly
     */
    private FormAddMethodCallAnalyzer $formAddMethodCallAnalyzer;
    /**
     * @readonly
     */
    private FormOptionsArrayMatcher $formOptionsArrayMatcher;
    /**
     * @readonly
     */
    private FormCollectionAnalyzer $formCollectionAnalyzer;
    /**
     * @readonly
     */
    private ControllerAnalyzer $controllerAnalyzer;
    /**
     * @readonly
     */
    private ValueResolver $valueResolver;
    public function __construct(FormInstanceToFormClassConstFetchConverter $formInstanceToFormClassConstFetchConverter, FormAddMethodCallAnalyzer $formAddMethodCallAnalyzer, FormOptionsArrayMatcher $formOptionsArrayMatcher, FormCollectionAnalyzer $formCollectionAnalyzer, ControllerAnalyzer $controllerAnalyzer, ValueResolver $valueResolver)
    {
        $this->formInstanceToFormClassConstFetchConverter = $formInstanceToFormClassConstFetchConverter;
        $this->formAddMethodCallAnalyzer = $formAddMethodCallAnalyzer;
        $this->formOptionsArrayMatcher = $formOptionsArrayMatcher;
        $this->formCollectionAnalyzer = $formCollectionAnalyzer;
        $this->controllerAnalyzer = $controllerAnalyzer;
        $this->valueResolver = $valueResolver;
    }
    public function getRuleDefinition() : RuleDefinition
    {
        return new RuleDefinition('Changes createForm(new FormType), add(new FormType) to ones with "FormType::class"', [new CodeSample(<<<'CODE_SAMPLE'
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class SomeController extends Controller
{
    public function action()
    {
        $form = $this->createForm(new TeamType);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class SomeController extends Controller
{
    public function action()
    {
        $form = $this->createForm(TeamType::class);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(Node $node) : ?Node
    {
        if ($this->controllerAnalyzer->isController($node->var) && $this->isName($node->name, 'createForm')) {
            return $this->formInstanceToFormClassConstFetchConverter->processNewInstance($node, 0, 2);
        }
        if (!$this->formAddMethodCallAnalyzer->isMatching($node)) {
            return null;
        }
        // special case for collections
        if ($this->formCollectionAnalyzer->isCollectionType($node)) {
            $this->refactorCollectionOptions($node);
        }
        return $this->formInstanceToFormClassConstFetchConverter->processNewInstance($node, 1, 2);
    }
    private function refactorCollectionOptions(MethodCall $methodCall) : void
    {
        $optionsArray = $this->formOptionsArrayMatcher->match($methodCall);
        if (!$optionsArray instanceof Array_) {
            return;
        }
        foreach ($optionsArray->items as $arrayItem) {
            if (!$arrayItem instanceof ArrayItem) {
                continue;
            }
            if (!$arrayItem->key instanceof Expr) {
                continue;
            }
            if (!$this->valueResolver->isValues($arrayItem->key, ['entry', 'entry_type'])) {
                continue;
            }
            if (!$arrayItem->value instanceof New_) {
                continue;
            }
            $newClass = $arrayItem->value->class;
            if (!$newClass instanceof Name) {
                continue;
            }
            $arrayItem->value = $this->nodeFactory->createClassConstReference($newClass->toString());
        }
    }
}
