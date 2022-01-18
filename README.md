**Wordpress Redis Cache**  for innoshop
[Redis](https://redis.io/) is an open source (BSD licensed), in-memory data structure store, used as a database, cache, and message broker. Redis provides data structures such as strings, hashes, lists, sets, sorted sets with range queries, bitmaps, hyperloglogs, geospatial indexes, and streams. Redis has built-in replication, Lua scripting, LRU eviction, transactions, and different levels of on-disk persistence, and provides high availability via Redis Sentinel and automatic partitioning with Redis Cluster.

== Installation ==

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Make sure [Redis is installed and running](http://redis.io/topics/quickstart).
2. Install and activate plugin.
3. Enable the object cache under _Settings -> Redis_, or in Multisite setups under _Network Admin -> Settings -> Redis_.
4. If necessary, adjust [connection parameters](http://wordpress.org/extend/plugins/redis-cache/other_notes/).

If your server doesn't support the [WordPress Filesystem API](https://codex.wordpress.org/Filesystem_API), you have to manually copy the `object-cache.php` file from the `/plugins/redis-cache/includes/` directory to the `/wp-content/` directory.


== Connection Parameters ==

By default the object cache drop-in will connect to Redis over TCP at `127.0.0.1:6379` and select database `0`.

To adjust the connection parameters, client, timeouts and intervals, please see the [connection parameters wiki page](https://github.com/rhubarbgroup/redis-cache/wiki/Connection-Parameters).


== Configuration Options ==

The plugin comes with quite a few configuration options, such as key prefixes, a maximum time-to-live for keys, ignored group and many more.


== More Details ==

    private static $redis_host = '127.0.0.1';  
    private static $redis_port = 6379;  
    private static $redis_db = 0;  
    private static $redis_auth = '';  
    private static $redis_persistent = false;
here's the authentication for redis server

    public static function clear_cache_by_product_id ( $product_id, $expire = true ) {  
      $product = wc_get_product( $product_id );  
       $home    = get_option( 'home' );  
      
       self::clear_cache_by_url( array(  
      trailingslashit( $home ),  
          $home,  
       ), $expire );  
      
       self::clear_cache_by_flag( array(  
      sprintf( 'product:%d:%d', $product, $product_id ),  
       ), $expire );  
    }
Clear cache by product id

    public static function clean_product_cache ( $product_id ){  
      $product = wc_get_product( $product_id );  
          if ( empty( $product->get_status ) || $product->get_status != 'publish' ) {  
      return;  
          }  
    //    self::clear_cache_by_flag( 'product' );  
      self::clear_cache_by_product_id( $product_id, false);  
       }
Clear product cache after editing or modifying the product 

    public static function template_redirect() {  
    //    Get Current Post id  
      $blog_id = get_current_blog_id();  
    //    Get Current Product id  
      $product_id = wc_get_product()->get_id();  
      
          if ( is_singular() ) {  
      self::flag( sprintf( 'post:%d:%d', $blog_id, get_queried_object_id() ) );  
          }  
      
      if ( is_feed() ) {  
      self::flag( sprintf( 'feed:%d', $blog_id ) );  
          }  
      
      if ( is_woocommerce() || has_tag('product') ) {  
      self::flag( sprintf( 'product:%d:%d', $product_id, get_queried_object_id() ) );  
          }  
     }
