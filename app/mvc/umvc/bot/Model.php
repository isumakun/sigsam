<?php

namespace umvc_bot;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET  TABLES
 ---------------------------------------------------------------------*/
	public function get_tables()
	{
		return $this->db->query("

			SELECT		TABLE_NAME
			FROM		information_schema.TABLES
			WHERE		TABLE_SCHEMA = '{$this->db_schema}'

		")->fetchAll();
	}

	public function get_columns($table_name)
	{
		return $this->db->query("

			SELECT		COLUMN_NAME,
						IS_NULLABLE,
						DATA_TYPE,
						CHARACTER_MAXIMUM_LENGTH,
						NUMERIC_PRECISION,
						COLUMN_COMMENT
			FROM		information_schema.COLUMNS
			WHERE		TABLE_SCHEMA = '{$this->db_schema}'
						AND TABLE_NAME = '$table_name'
			ORDER BY	ORDINAL_POSITION ASC

		")->fetchAll();
	}

	public function get_referenced_table($table_name, $column_name)
	{
		return $this->db->query("

			SELECT		referenced_table_name,
						referenced_column_name
			FROM		information_schema.key_column_usage
			WHERE		TABLE_SCHEMA = '{$this->db_schema}'
						AND TABLE_NAME = '$table_name'
						AND constraint_name NOT LIKE 'PRIMARY'
						AND referenced_table_name IS NOT NULL
						AND referenced_column_name IS NOT NULL
						AND COLUMN_NAME = '$column_name'
			ORDER BY	constraint_name
			LIMIT		1

		")->fetchAll()[0];
	}
}
