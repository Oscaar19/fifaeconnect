<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Club;

class ClubTest extends TestCase
{
    public static array $validData = [];
    public static array $invalidData = [];

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
        Log::debug("Empiezo a crear la foto fake");
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // TODO Omplir amb dades vàlides
        self::$validData = [
            "upload" => $upload,
            'nom'        => 'Team DUX Gaming',
        ];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [
            "upload" => $upload,
            'name'        => 34,
        ];
        
    }

    public function test_club_list()
    {
        Log::debug("Entro al test de listar");
        // List all files using API web service
        $response = $this->getJson("/api/clubs");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
        Log::debug("Salgo del test de listar");


    }

    public function test_club_create() : object
    {
        // Cridar servei web de l'API
        $response = $this->postJson("/api/clubs", self::$validData);
        // Revisar que no hi ha errors de validació
        $params = array_keys(self::$validData);
        $response->assertValid($params);
                
        // Check OK response
        $this->_test_ok($response, 201);
    
        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }

    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("data", 
            fn ($data) => is_array($data)
        ); 
    }
}
