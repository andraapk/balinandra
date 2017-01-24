<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\API\Connectors\APIUser;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Style');
        // $this->visit('sign-in')
        //         ->type('andra.rifani@yahoo.com', 'email')
        //         ->type('1234567890', 'password')
        //         ->press('Sign In')
        //         ->seePageIs('me/redeem')
        //         ->see('IDR 0');

    }

    public function testSession()
    {
        $this->visit('/')
                ->dontSee('ANDRA');

        $this->visit('me/redeem')
                ->seePageIs('sign-in');

        $this->post('/sign-in', ['email' => 'andra.rifani@yahoo.com', 'password' => '1'])
                ->assertRedirectedToRoute('balin.get.login', ['type' => 'login']);

        $this->mockUser();

        $this->visit('/')
                ->see('ANDRA');

        $this->visit('me/redeem')
                ->see('IDR 0');
    }

    private function mockUser()
    {     
        $this->post('/sign-in', ['email' => 'andra.rifani@yahoo.com', 'password' => '1234567890']);
    }

    public function testCheckout()
    {
        $this->mockUser();

        $this->visit('/')
                ->see('ANDRA');

        $this->visit('me/checkout')
                ->type('Andra Rifani', 'receiver_name')
                ->type('081977661994', 'phone')
                ->type('Perum Graha Laksana Tidar Blok B No 3', 'address')
                ->type('65151', 'zipcode')
                ->click('Lanjutkan')
                ->seePageIs('me/checkout?section=sc2');
    }

    public function testCheckoutExtension2()
    {
        $this->testCheckout();

        $this->visit('me/checkout?section=sc2')    
                ->see('Punya Kode Voucher ?')  
                ->click('Lanjutkan')
                ->seePageIs('me/checkout?section=sc3');  
    }

        public function testCheckoutExtension3()
    {
        $this->testCheckoutExtension2();

        $this->visit('me/checkout?section=sc3')    
                ->see('Packaging Option')  
                ->click('Lanjutkan')
                ->seePageIs('me/checkout?section=sc4');  
    }

        public function testCheckoutExtension4()
    {
        $this->testCheckoutExtension3();

        $this->visit('me/checkout?section=sc4')    
                ->see('Pilih Pembayaran')  
                ->click('Lanjutkan')
                ->seePageIs('me/checkout?section=sc5');  
    }        
}

