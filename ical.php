<?php
class modules_ical {
    /**
     * @brief The base URL to the tagger module.  This will be correct whether it is in the 
     * application modules directory or the xataface modules directory.
     *
     * @see getBaseURL()
     */
    private $baseURL = null;
    
        /**
     * @brief Returns the base URL to this module's directory.  Useful for including
     * Javascripts and CSS.
     *
     */
    public function getBaseURL(){
        if ( !isset($this->baseURL) ){
            $this->baseURL = Dataface_ModuleTool::getInstance()->getModuleURL(__FILE__);
        }
        return $this->baseURL;
    }
    
    public function __construct(){
      define('XF_MODULES_ICAL_BASE_URL', $this->getBaseURL());
    }
    
}