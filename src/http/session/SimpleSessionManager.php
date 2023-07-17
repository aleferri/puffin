<?php

namespace puffin\http\session;

use puffin\http\Request;
use puffin\auth\Login;

class SimpleSessionManager {

    private $repository;
    private $classname;
    private $guest_login;

    public function __construct($repository, string $classname, Login $guest_login) {
        $this->repository = $repository;
        $this->classname = $classname;
        $this->guest_login = $guest_login;
    }

    public function create(Request $request): Session {
        $ctor = $this->classname . '::' . 'init';

        $session_id = \base64_encode( \random_bytes( 48 ) );
        $expire_after = ( new \DateTimeImmutable() )->plus( new \DateInterval( 'P1h' ) );

        $session = $ctor( $session_id, $expire_after, $request->origin(), $this->guest_login, [], $request->uri() );

        return $this->repository->store( $session );
    }

    public function restore(string $id): Session {
        return $this->repository
                ->find_by_key( $this->classname, 'session_cookie', $id )
                ->element();
    }

    public function sync(Session $session): Session {
        if ( ! $session->is_synced() ) {
            return $this->repository->store( $session );
        }

        return $session;
    }

    public function destroy(Session $session): void {
        $this->repository->drop( $session );
    }

    public function invalidate(string $id, int $reason = self::EXPIRED): void {
        $this->repository->drop_by_key( $this->classname, 'session_cookie', $id );
    }

}
