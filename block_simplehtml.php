<?php
class block_simplehtml extends block_base 
{
    public function init() 
    {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
    public function has_config()
    {
        return true;
    }
    public function get_content() 
    {
        if ($this->content !== null) 
        {
          return $this->content;
        }
     
        $this->content         =  new stdClass;
        $this->content->text   = 'The content of our SimpleHTML block!';
        $this->content->footer = 'Footer here...';
     
        return $this->content;
    }
    public function specialization() 
    {
        if (isset($this->config)) 
        {
            if (empty($this->config->title)) 
            {
                //$this->config->title
                                                        //'defaulttitle'
                $this->title  = $this->title = get_string($this->title, 'block_simplehtml');            
            } 
            else 
            {
                $this->title = $this->config->title;
            }
     
            if (empty($this->config->text)) 
            {
                $this->config->text = get_string('defaulttext', 'block_simplehtml');
            }    
        }
    }
    public function instance_allow_multiple()
    {
        return true;
    }
    /**
     * Return the plugin config settings for external functions.
     *
     * @return stdClass the configs for both the block instance and plugin
     * @since Moodle 3.8
     */
    public function get_config_for_external() 
    {
        global $CFG;

        // Return all settings for all users since it is safe (no private keys, etc..).
        $instanceconfigs = !empty($this->config) ? $this->config : new stdClass();
        $pluginconfigs = (object) ['allowcssclasses' => $CFG->block_simplehtml_allowcssclasses];

        return (object) [
            'instance' => $instanceconfigs,
            'plugin' => $pluginconfigs,
        ];
    }
    public function instance_config_save($data,$nolongerused =false) 
    {
        if(get_config('simplehtml', 'Allow_HTML') == '1') 
        {
          $data->text = strip_tags($data->text);
        }
       
        // And now forward to the default implementation defined in the parent class
        return parent::instance_config_save($data,$nolongerused);
    }
    /*public function hide_header() 
    {
        return true;
    }*/
    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
        return $attributes;
    }
    public function applicable_formats() 
    {
        return array(
                        'course-view' => true, 
                        'course-view-social' => false,
                        'site-index' => true,
                        'mod' => true, 
                        'mod-quiz' => false
                    );
    }
}
/*class block_my_menu extends block_list 
{
    // The init() method does not need to change at all
    public function init() 
    {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }
    public function get_content() 
    {
        if ($this->content !== null) 
        {
          return $this->content;
        }
       
        $this->content         = new stdClass;
        $this->content->items  = array();
        $this->content->icons  = array();
        $this->content->footer = 'Footer here...';
       
        $this->content->items[] = html_writer::tag('a', 'Menu Option 1', array('href' => 'some_file.php'));
        $this->content->icons[] = html_writer::empty_tag('img', array('src' => 'images/icons/1.gif', 'class' => 'icon'));
       
        // Add more list items here
       
        return $this->content;
      }
}*/