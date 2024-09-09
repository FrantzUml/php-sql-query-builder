<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/3/14
 * Time: 12:07 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Sql\QueryBuilder\Syntax;

/**
 * Class Table.
 */
class Table
{
    /**
     * @var non-empty-string
     */
    protected $name;

    /**
     * @var non-empty-string|null
     */
    protected $alias;

    /**
     * @var non-empty-string|null
     */
    protected $schema;

    /**
     * @var bool
     */
    protected $view = false;

    /**
     * @param string $name
     * @param string|null $schema
     * @param string|null $alias
     */
    public function __construct($name, $schema = null, $alias = null)
    {
        $this->setName($name)->setSchema($schema)->setAlias($alias);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @param bool $view
     *
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return bool
     */
    public function isView()
    {
        return $this->view;
    }

    /**
     * @return non-empty-string
     */
    public function getName()
    {
        return $this->name;
    }

    private function setName(string $name): self {
        $name = \trim($name);
        if ($name === ''){
            throw new QueryException();
        }
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getCompleteName()
    {
        $alias = ($this->alias) ? " AS {$this->alias}" : '';
        $schema = ($this->schema) ? "{$this->schema}." : '';

        return $schema.$this->name.$alias;
    }

    /**
     * @param string|null $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        if ($alias === null){
            $this->alias = null;
        }
        else {
            $alias = \trim($alias);
            $this->alias = ($alias === '') ? null : $alias;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param string|null
     * @param string $schema
     *
     * @return $this
     */
    public function setSchema($schema)
    {
        if ($schema === null){
            $this->schema = null;
        }
        else {
            $schema = \trim($schema);
            $this->schema = ($schema === '') ? null : $schema;
        }
        return $this;
    }
}
