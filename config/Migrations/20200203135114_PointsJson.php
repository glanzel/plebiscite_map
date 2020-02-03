<?php
use Migrations\AbstractMigration;

class PointsJson extends AbstractMigration
{

    public function up()
    {
        $this->table('points')
            ->addColumn('Details', 'text', [
                'after' => 'Kategorie',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('Details_intern', 'text', [
                'after' => 'Details',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('active', 'boolean', [
                'after' => 'Details_intern',
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->update();

    }

    public function down()
    {
        $this->table('points')
            ->removeColumn('Details')
            ->removeColumn('Details_intern')
            ->removeColumn('active')
            ->update();
    }
}

