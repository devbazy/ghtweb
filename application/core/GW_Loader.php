<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class GW_Loader extends CI_Loader
{
    /**
     * Устанавливает путь до папки с VIEW
     * 
     * @param string $path 
     */
    public function set_view_path($path)
    {
        $this->_ci_view_paths = array('templates/' . $path . '/' => true);
    }
    
    /**
	 * Database Loader
	 *
	 * @param	string	the DB credentials
	 * @param	bool	whether to return the DB object
	 * @param	bool	whether to enable active record (this allows us to override the config setting)
	 * @return	object
	 */
	public function database($params = '', $return = FALSE, $active_record = NULL)
	{
		// Grab the super object
		$CI =& get_instance();

		// Do we even need to load the database class?
		if (class_exists('CI_DB') AND $return == FALSE AND $active_record == NULL AND isset($CI->db) AND is_object($CI->db))
		{
			return FALSE;
		}

		require_once(BASEPATH.'database/DB.php');
        
		if ($return === TRUE)
		{
			$d = DB($params, $active_record);
            $this->_ci_db[] = $d;
            return $d;
		}

		// Initialize the db variable.  Needed to prevent
		// reference errors with some configurations
		$CI->db = '';

		// Load the DB class
		$CI->db =& DB($params, $active_record);
        
        //prt($CI->db);
        $this->_ci_db[] = $CI->db;
	}
}