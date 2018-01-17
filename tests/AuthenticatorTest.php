<?php 

use Tuiter\Core\AuthAuth\Authenticator;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    public function testAuthenticate()
    {
        $storage = \Mockery::mock('\TuiterSupport\StorageInterface'); 
        $provider = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthProviderInterface');
        $user = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthInterface');

        $authenticator = new Authenticator($provider, $storage);

        $credentials = ['username' => 'walison', 'password' => 'password'];

        $user->shouldReceive('getAuthIdentifier')->andReturn(1);

        $provider->shouldReceive('retrieveByCredentials')->with($credentials)->andReturn($user);

        $storage->shouldReceive('set')->with('user_id', $user->getAuthIdentifier());
        $storage->shouldReceive('get')->with('user_id')->andReturn($user->getAuthIdentifier());
        
        $authenticator->authenticate($credentials);

        $this->assertEquals(1, $storage->get('user_id'));
        $this->assertNotEquals(99, $storage->get('user_id'));
    }

    public function testWhenUserIsAuthenticated()
    {
        $storage = \Mockery::mock('\TuiterSupport\StorageInterface'); 
        $provider = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthProviderInterface');
        $user = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthInterface');

        $storage->shouldReceive('exists')->andReturnTrue();

        $authenticator = new Authenticator($provider, $storage);

        $this->assertTrue($authenticator->check());
    }

    public function testWhenUserIsNotAuthenticated()
    {
        $storage = \Mockery::mock('\TuiterSupport\StorageInterface'); 
        $provider = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthProviderInterface');
        $user = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthInterface');

        $storage->shouldReceive('exists')->andReturnFalse();

        $authenticator = new Authenticator($provider, $storage);

        $this->assertFalse($authenticator->check());
    }
    
    public function testGetTheActiveUser()
    {
        $storage = \Mockery::mock('\TuiterSupport\StorageInterface'); 
        $provider = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthProviderInterface');
        $user = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthInterface');

        $authenticator = new Authenticator($provider, $storage);

        $storage->shouldReceive('get')->andReturn(1);
        $storage->shouldReceive('exists')->andReturnTrue();

        $provider->shouldReceive('retrieveByIdentifier')->with(1)->andReturn($user);

        $this->assertEquals($user, $authenticator->user());
    }

    public function testLogoutUser()
    {
        /** @var \Mockery\MockInterface */
        $storage = \Mockery::spy('\TuiterSupport\StorageInterface'); 

        /** @var \Mockery\MockInterface */
        $provider = \Mockery::mock('\Tuiter\Core\AuthAuth\AuthProviderInterface');

        $authenticator = new Authenticator($provider, $storage);

        $authenticator->logout();

        $storage->shouldHaveReceived('remove')->with('user_id');

        $this->assertTrue(true); //apenas para desmarcar o risco
    }

    public function tearDown() {
        \Mockery::close();
    }
}   