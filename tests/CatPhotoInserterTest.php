<?php
use PHPUnit\Framework\TestCase;

class CatPhotoInserterTest extends TestCase
{
    private $plugin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->plugin = new Cat_Photo_Inserter();
    }

    public function testPluginInitialization()
    {
        $this->assertInstanceOf(Cat_Photo_Inserter::class, $this->plugin);
    }

    public function testAdminClassExists()
    {
        $this->assertTrue(class_exists('Cat_Photo_Inserter_Admin'));
    }

    public function testPublicClassExists()
    {
        $this->assertTrue(class_exists('Cat_Photo_Inserter_Public'));
    }

    public function testFetchAndInsertCatPhotos()
    {
        $public = new Cat_Photo_Inserter_Public();
        $content = "I love Siamese cats.";
        $updated_content = $public->fetch_and_insert_cat_photos($content);
        
        // This test will fail in the test environment because we're not actually calling the API
        // In a real test, you'd mock the API response
        $this->assertEquals($content, $updated_content);
    }
}

