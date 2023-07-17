# Leaf  
Leaf is PHP library for basic HTTP request routing  

# Example of usage  

    //boostrap.php
    use \puffin\http\HTTPServer;
    use \puffin\http\RouteCollection;
    use \puffin\http\SimpleRouter;
    use \puffin\http\SimpleResponse;
    
    $request = HTTPServer::accept();

    $not_found = new SimpleResponse(404);
    $router = new SimpleRouter( $not_found );

    $routes = new RouteCollection();

    $declare_routes = include( 'routes.php' );
    $declare_routes( $routes );

    $response = $router->route( $request, $routes );

    HTTPServer::send( $response );
    //EOF

    //routes.php
    use \puffin\http\RouteCollection;
    use \puffin\http\Request;
    use \puffin\http\SimpleResponse;

    return function(RouteCollection $routes) {

        $routes->get( '/api/awesome/v1/@object', function( Request $r, string $object ) {
            if ( $object === 'ok' ) {
                return new SimpleResponse( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'success' => true ] ) );
            } else {
                $get_query = $r->query();
                if ( isset( $r[ 'id' ] ) ) {
                    //etc
                }
                return new SimpleResponse( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'success' => true, 'data' => [] ] ) );
            }
        };

    };
    //EOF
