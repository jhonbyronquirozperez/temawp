<?php

    Class ATR_Master{
    protected $cargador;
    protected $theme_name;
    protected $version;

    public function __construct() {
        $this->theme_name = 'ATR_Prueba';
        $this->version = '1.0.0';
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->set_idiomas();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();

    }

    private function cargar_dependencias() {
    
    /**
     * la clase responsable de iterar las acciones y filtros del nucleo del tema
     */
        require_once ATR_DIR_PATH . 'includes/class-atr-cargador.php';

    /**
     * la clase responsable de definir la funcionalidad internacionalización del tema
     */
        require_once ATR_DIR_PATH . 'includes/class-atr-i18n.php';

     /**
      * la clase responsable de definir la los menus y submenus del tema en el panel de administración
      *  */   
    
       require_once ATR_DIR_PATH . 'includes/class-atr-build-menupage.php';

    /**
     * la clase responsable de definir la funcionalidad del lado del administrador      
     * */   
        require_once ATR_DIR_PATH . 'admin/class-atr-admin.php'; 

    /**
     * la clase responsable de definir la funcionalidad del lado del publico    
     * */   
        require_once ATR_DIR_PATH . 'public/class-atr-public.php'; 

    

       
        
       
    }


    private function set_idiomas() {
        $i18n = new ATR_i18n();
        $this->cargador->add_action("after_setup_theme", $i18n, "cargar_textdomain");
    }

    private function cargar_instancias() {

    /**
     * instancia de la clase ATR_Cargador que se encarga de registrar y cargar las acciones y filtros del tema
     */
        $this->cargador = new ATR_Cargador;
        $this->atr_admin = new ATR_Admin($this->get_theme_name(), $this->get_version());
        $this->atr_public = new ATR_Public($this->get_theme_name(), $this->get_version());
    }

    private function definir_admin_hooks() {
    }

    private function definir_public_hooks() {
        $this->cargador->add_action("wp_enqueue_scripts", $this->atr_public, "enqueue_styles");
        $this->cargador->add_action("wp_enqueue_scripts", $this->atr_public, "enqueue_scripts");
    }

    public function get_theme_name(){
        return $this->theme_name;
    }

    public function get_version(){
        return $this->version;
    }

    public function get_cargador(){
        return $this->cargador;
    }   

    public function run() {
        $this->cargador->run();
    }
}