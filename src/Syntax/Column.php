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

use NilPortugues\Sql\QueryBuilder\Manipulation\QueryException;

/**
 * Class Column.
 */
class Column implements QueryPartInterface
{
    const ALL = '*';

    /**
     * @var Table|null
     */
    protected $table;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $alias;

    /**
     * @internal This class should be instantiated only by {@link SyntaxFactory}.
     * @param string $name
     * @param Table|null $table
     * @param string|null $alias
     */
    public function __construct($name, $table, $alias = '')
    {
        $this->setName($name)->setAlias($alias);
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function partName()
    {
        return 'COLUMN';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $name = \trim($name);
        if ($name === ''){
            throw new QueryException();
        }
        $this->name = $name;
        return $this;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        if ($this->table === null){
            throw new QueryException();
        }
        return $this->table;
    }

    /**
     * @param Table|null $table
     *
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param null|string $alias
     *
     * @return $this
     *
     * @throws QueryException
     */
    public function setAlias($alias)
    {
        if ($alias === null){
            $this->alias = null;
            return $this;
        }
        else {
            $alias = \trim($alias);
            if ($alias === ''){
                $this->alias = null;
                return $this;
            }
        }
        if ($this->isAll()) {
            throw new QueryException("Can't use alias because column name is ALL (*)");
        }
        $this->alias = $alias;
        return $this;
    }

    /**
     * Check whether column name is '*' or not.
     *
     * @return bool
     */
    public function isAll()
    {
        return $this->getName() == self::ALL;
    }
}
