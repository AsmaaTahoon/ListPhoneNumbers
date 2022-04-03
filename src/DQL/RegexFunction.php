<?php
namespace App\DQL;

use \Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;


class RegexFunction extends FunctionNode
{

  public $value = null;

  public $regexp = null;

  /**
   * @inheritdoc
   */
  public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
  {
//    dump('(' . $this->value->dispatch($sqlWalker) . ' REGEXP ' . $this->regexp->dispatch($sqlWalker) . ')'); die;
    return '' . $this->value->dispatch($sqlWalker) . ' REGEXP ' . $this->regexp->dispatch($sqlWalker) . '';
  }

  public function parse(\Doctrine\ORM\Query\Parser $parser)
  {
    $parser->match(Lexer::T_IDENTIFIER);
    $parser->match(Lexer::T_OPEN_PARENTHESIS);
    $this->value = $parser->StringPrimary();
    $parser->match(Lexer::T_COMMA);
    $this->regexp = $parser->StringExpression();
    $parser->match(Lexer::T_CLOSE_PARENTHESIS);
  }

}