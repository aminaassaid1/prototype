<?php

namespace Tests\Feature\pkg_rh;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\pkg_rh\Personne;

use App\Models\pkg_rh\Groupe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PersonneTest extends TestCase
{use DatabaseTransactions;

    protected $personneModel;
    protected $groupeModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->personneModel = new Personne;
        $this->groupeModel = new Groupe;
    }

    public function test_paginate_personnes(): void
    {
        // Create some personnes for pagination test
        $groupe = $this->groupeModel->create(['nom' => 'groupTest1','created_at' => now(), 'updated_at' => now()]);
        $this->personneModel->create([
            'nom' => 'Doe1',
            'prenom' => 'John1',
            'created_at' => now(),
            'updated_at' => now(),
            'groupe_id' => $groupe->id,
        ]);
        $this->personneModel->create([
            'nom' => 'Doe2',
            'prenom' => 'John2',
            'created_at' => now(),
            'updated_at' => now(),
            'groupe_id' => $groupe->id,
        ]);

        $personnes = $this->personneModel->paginate(2);
        $this->assertNotNull($personnes);
        $this->assertNotEmpty($personnes);
        $this->assertCount(2, $personnes);
    }

    public function test_create_personne(): void
    {
        $groupe = $this->groupeModel->create(['nom' => 'groupTest1','created_at' => now(), 'updated_at' => now()]);
        $data = [
            'nom' => 'Doe',
            'prenom' => 'John',
            'created_at' => now(),
            'updated_at' => now(),
            'groupe_id' => $groupe->id,
        ];

        $this->personneModel->create($data);
        $this->assertDatabaseHas('personnes', [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'groupe_id' => $data['groupe_id'],
        ]);
    }

    public function test_update_personne(): void
    {
        $groupe = $this->groupeModel->create(['nom' => 'groupTest1','created_at' => now(), 'updated_at' => now()]);
        $existingPersonne = $this->personneModel->create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'created_at' => now(),
            'updated_at' => now(),
            'groupe_id' => $groupe->id,
        ]);

        $newName = 'Updated Doe';
        $existingPersonne->update(['nom' => $newName]);

        $this->assertEquals($newName, $existingPersonne->nom);
        $this->assertDatabaseHas('personnes', ['nom' => $newName]);
    }

    public function test_delete_personne(): void
    {
        $groupe = $this->groupeModel->create(['nom' => 'groupTest1','created_at' => now(), 'updated_at' => now()]);
        $existingPersonne = $this->personneModel->create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'created_at' => now(),
            'updated_at' => now(),
            'groupe_id' => $groupe->id,
        ]);

        $existingPersonne->delete();

        $this->assertDatabaseMissing('personnes', ['id' => $existingPersonne->id]);
    }
}