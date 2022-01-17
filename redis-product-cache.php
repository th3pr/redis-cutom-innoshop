<?php
/**
 * Redis Product Cache
 *
 * @package       REDISPRODU
 * @author        Mohamed Ahmed Bahnsawy
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Redis Product Cache
 * Plugin URI:    https://innoshop.co/
 * Description:   Redis product cahce , task for innoshop.co by Mohamed A. Bahnsawy, based on some opensource plugins.
 * Version:       1.0.0
 * Author:        Mohamed Ahmed Bahnsawy
 * Author URI:    https://www.linkedin.com/in/bahnsawy
 * Text Domain:   redis-product-cache
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Redis Product Cache. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'REDISPRODU_NAME',			'Redis Product Cache' );

// Plugin version
define( 'REDISPRODU_VERSION',		'1.0.0' );

// Plugin Root File
define( 'REDISPRODU_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'REDISPRODU_PLUGIN_BASE',	plugin_basename( REDISPRODU_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'REDISPRODU_PLUGIN_DIR',	plugin_dir_path( REDISPRODU_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'REDISPRODU_PLUGIN_URL',	plugin_dir_url( REDISPRODU_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once REDISPRODU_PLUGIN_DIR . 'core/class-redis-product-cache.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Mohamed Ahmed Bahnsawy
 * @since   1.0.0
 * @return  object|Redis_Product_Cache
 */
function REDISPRODU() {
	return Redis_Product_Cache::instance();
}

REDISPRODU();
