<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $firebaseConfig = config('firebase');

        // Ensure Firebase config returns an array to prevent errors
        if (!is_array($firebaseConfig)) {
            $firebaseConfig = [];
        }

        $this->app->singleton('firebase.messaging', function () use ($firebaseConfig) {
            try {
                return (new Factory)
                    ->withServiceAccount($firebaseConfig['credentials'])
                    ->createMessaging();
            } catch (FirebaseException $e) {
                \Log::error("Firebase messaging service initialization failed: " . $e->getMessage());
                throw $e;
            }
        });
    }
}

