<?php
use Migrations\AbstractMigration;

class Points extends AbstractMigration
{
    public function up()
    {

        $this->table('points', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('Strasse', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('Nr', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('PLZ', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('Stadt', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('Laengengrad', 'float', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('Breitengrad', 'float', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('Kategorie', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {
        $this->table('points')->drop()->save();
    }
}
