<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('prt'))
{
    function prt($a)
    {
        echo '<pre style="padding: 0 3px 2px;font-size: 12px;color: #333333;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;display: block;padding: 8.5px;margin: 0 0 9px;font-size: 12.025px;line-height: 18px;word-break: break-all;word-wrap: break-word;white-space: pre;white-space: pre-wrap;background-color: #f5f5f5;border: 1px solid #ccc;border: 1px solid rgba(0, 0, 0, 0.15);-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;">';
        print_r($a);
        echo '</pre>';
    }
}

if(!function_exists('get_segment_uri'))
{
    function get_segment_uri($segment = 1)
    {
        if($segment < 1)
        {
            $segment = 1;
        }
        
        $CI =& get_instance();
        
        if($CI->config->item($CI->uri->segment(1), 'languages'))
        {
            $segment++;
        }
        
        return $CI->uri->segment($segment);
    }
}

if(!function_exists('redirect_back'))
{
    /**
     * Редирект на предыдущий URL
     * 
     * @param string: Если REFERER был не с текущего сайта то редирект будет на $other_url
     */
    function redirect_back($other_url = '')
    {
        if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false)
        {
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        redirect($other_url);
    }
}

/**
 * array(
 *     'links' => array(
 *         array('name' => 'Название ссылки', 'url' => 'ссылка', 'title' => 'титул ссылки', 'current' => true);
 *         array('name' => 'Название ссылки', 'url' => 'ссылка', 'title' => 'титул ссылки');
 *     ),
 *     'delimiter' => '/',
 */
if(!function_exists('breadcrumb'))
{
    function breadcrumb(array $data = NULL)
    {
        // Разделитель
        $delimiter = (isset($data['delimiter']) ? $data['delimiter'] : '/');
        
        $html = '<ul class="breadcrumb">';
        
        $count = count($data['links']);
        
        foreach($data['links'] as $key => $options)
        {
            $current = '';
            
            if(!empty($options['current']) && $options['current'] === true)
            {
                $current = ' class="active"';
            }
            
            $title = (!empty($options['title']) ? 'title="' . $options['title'] . '"' : '');
            
            $url = (isset($options['url']) ? anchor($options['url'], $options['name'], $title) : $options['name']);
            
            $divider = (($key+1) != $count ? '<span class="divider">' . $delimiter . '</span>' : '');
            
            $html .= '<li' . $current . '>' . $url . $divider . '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }
}

if(!function_exists('db_date'))
{
    function db_date($time = '')
    {
        return date('Y-m-d H:i:s', ($time == '' ? time() : $time));
    }
}

if(!function_exists('send_mail'))
{
    function send_mail($to, $title, $message)
    {
        $CI =& get_instance();

        $config['protocol']     = 'mail';
        $config['mailtype']     = 'html';
        $config['smtp_timeout'] = 30;
        $config['newline']      = "\r\n"; 

        if($CI->config->item('mail_method') == 'smtp')
        {
            $config['protocol']  = 'smtp';
            $config['smtp_host'] = $CI->config->item('mail_smtp_host');
            $config['smtp_user'] = $CI->config->item('mail_smtp_user');
            $config['smtp_pass'] = $CI->config->item('mail_smtp_pass');
            $config['smtp_port'] = $CI->config->item('mail_smtp_port');
        }
        
        $CI->load->library('email', $config);
               
        $CI->email->from($CI->config->item('mail_site_email'), $CI->config->item('mail_site_author'));
        $CI->email->to($to);
        $CI->email->subject($title);
        $CI->email->message($message);
        
        return $CI->email->send();
    }
}

if(!function_exists('uri_segment'))
{
    function uri_segment($number = 1)
    {
        $CI =& get_instance();
        
        $fsu = $CI->uri->segment(1);
        
        if($CI->config->item($fsu, 'languages'))
        {
            $number++;
        }
        
        return $number;
    }
}

if(!function_exists('nicEdit'))
{
    function nicEdit(array $textareas = NULL)
    {
        $nc = '
        <script type="text/javascript" src="/resources/libs/nicEdit/nicEdit.js"></script>
        <script type="text/javascript">
            //<![CDATA[
            $(function(){';
            
            foreach($textareas as $area)
            {
                $nc .= 'var nc_' . $area . ' = new nicEditor({fullPanel:true}).panelInstance("' . $area . '");';
            }
                
            $nc .= '
            });
            //]]>
        </script>';
        
        return $nc;
    }
}

if(!function_exists('get_templates'))
{
    function get_templates()
    {
        $tpl_dir = FCPATH . 'templates';
        
        $scan = scandir($tpl_dir);
        $res = array();
        
        foreach($scan as $k => $v)
        {
            if($v != '.' && $v != '..' && $v != 'backend')
            {
                $res[$v] = $v;
            }
        }
        
        return $res;
    }
}

if(!function_exists('tiny_mce'))
{
    function tiny_mce(array $textareas = NULL)
    {
        $ta = '';
        
        foreach($textareas as $id)
        {
            $ta .= '#' . $id . ', ';
        }
        
        $ta = substr(trim($ta), 0, -1);
        
        $nc = '
        <script type="text/javascript" src="/resources/libs/tiny_mce/jquery.tinymce.js"></script>
        <script type="text/javascript">
            $().ready(function() {
                $("' . $ta . '").tinymce({
                    // Location of TinyMCE script
                    script_url : "/resources/libs/tiny_mce/tiny_mce.js",
                    //language : "ru",
                    // General options
                    theme : "advanced",
                    plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,images",

                    // Theme options
                    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,images",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : true,
                    
                    relative_urls : false,
                    remove_script_host : true,
                    
                    forced_root_block : false,
                    force_br_newlines : true,
                    force_p_newlines : false,
                    
                    // Example content CSS (should be your site CSS)
                    content_css : "/templates/apress/css/style.css",

                    // Drop lists for link/image/media/template dialogs
                    template_external_list_url : "lists/template_list.js",
                    external_link_list_url : "lists/link_list.js",
                    external_image_list_url : "lists/image_list.js",
                    media_external_list_url : "lists/media_list.js",

                    // Replace values for the template plugin
                    template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                    }
                });
            });
        </script>';
        
        return $nc;
    }
}