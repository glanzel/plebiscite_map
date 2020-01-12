<?php
use Migrations\AbstractMigration;

class PointsName extends AbstractMigration
{

    public function up()
    {

        $this->table('points')
            ->addColumn('Name', 'string', [
                'after' => 'id',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('Beschreibung', 'text', [
                'after' => 'Stadt',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('points')
            ->removeColumn('Name')
            ->removeColumn('Beschreibung')
            ->update();
    }
}

