<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * ログイン機能をテストする
     *
     * @return void
     */
    public function testLogin()
    {
        // ユーザーを作成しておく
        $user = factory(User::class)->create([
            'email' => 'dusk@foo.com',
            'password' => Hash::make('secret'),
        ]);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login') // ログインページへ移動
                    ->type('email', $user->email) // メールアドレスを入力
                    ->type('password', 'secret') // パスワードを入力
                    ->press('[type="submit"]') // 送信ボタンをクリック
                    ->assertPathIs('*/users/'.$user->id); // プロフィールページへ移動していることを確認
        });
    }
}
