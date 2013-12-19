<?php

namespace PDODblibModule\Doctrine\DBAL\Schema;

/**
 * The PDO-based Dblib schema manager.
 *
 * @since 2.0
 */
class PDODblibSchemaManager extends \Doctrine\DBAL\Schema\MsSqlSchemaManager {

    /**
     * @override
     */
    protected function _getPortableTableColumnDefinition($tableColumn) {
        foreach ($tableColumn as $key => $value) {
            $tableColumn[strtoupper($key)] = $value;
        }
        return parent::_getPortableTableColumnDefinition($tableColumn);
    }

}
