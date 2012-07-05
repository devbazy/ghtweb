<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class GW_Profiler extends CI_Profiler
{
	/**
	 * Compile Queries
	 *
	 * @return	string
	 */
	protected function _compile_queries()
	{
		$dbs = $this->CI->load->_ci_db;
        
		if (count($dbs) == 0)
		{
			$output  = "\n\n";
			$output .= '<fieldset id="ci_profiler_queries" style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_queries').'&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table style='border:none; width:100%'>\n";
			$output .="<tr><td style='width:100%;color:#0000FF;font-weight:normal;background-color:#eee;padding:5px'>".$this->CI->lang->line('profiler_no_db')."</td></tr>\n";
			$output .= "</table>\n";
			$output .= "</fieldset>";

			return $output;
		}
        
        // Load the text helper so we can highlight the SQL
		$this->CI->load->helper('text');

		// Key words we want bolded
		$highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');
        
        $d = array();
        
		foreach ($dbs as $db)
		{
            if(count($db->queries) == 0)
            {
                $d[$db->database] = array();
                continue;
            }
            
            foreach ($db->queries as $key => $val)
            {
                $time = number_format($db->query_times[$key], 4);

                $val = highlight_code($val, ENT_QUOTES);

                foreach ($highlight as $bold)
                {
                    $val = str_replace($bold, '<strong>'.$bold.'</strong>', $val);
                }
                
                $d[$db->database][] = array(
                    'time' => $time,
                    'sql'  => $val,
                );
            }
        }

        $output  = "\n\n";
        
        // Формирую вид
        foreach($d as $db_name => $querys)
        {
			$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_database').':&nbsp; '.$db_name.'&nbsp;&nbsp;&nbsp;'.$this->CI->lang->line('profiler_queries').': '.count($d[$db_name]).'&nbsp;&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table style='width:100%;'>\n";
            
            if (count($d[$db_name]) < 1)
			{
				$output .= "<tr><td style='width:100%;color:#0000FF;font-weight:normal;background-color:#eee;padding:5px;'>".$this->CI->lang->line('profiler_no_queries')."</td></tr>\n";
			}
			else
			{
				foreach ($querys as $val)
				{
					$output .= "<tr><td style='padding:5px; vertical-align: top;width:1%;color:#900;font-weight:normal;background-color:#ddd;'>".$val['time']."&nbsp;&nbsp;</td><td style='padding:5px; color:#000;font-weight:normal;background-color:#ddd;'>".$val['sql']."</td></tr>\n";
				}
			}
            
            $output .= "</table>\n";
			$output .= "</fieldset>";
        }

		return $output;
	}
}