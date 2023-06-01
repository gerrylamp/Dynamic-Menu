<!-- Import Dynamic Menu -->
<?php
    wp_nav_menu(array(
        'theme_location' => 'custom-menu',
        'menu_class'     => 'nav navbar-nav',
        'walker'         => new Custom_Nav_Walker()
    ));
?>


<!-- Dynamic Menu Css -->
<style>
            .navbar-nav .dropdown-menu {
    display: none;
    position: absolute;
    z-index: 1000;
    background-color: #fff;
    padding: 0;
    margin-top: 0.5rem;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}

.navbar-nav .dropdown:hover > .dropdown-menu {
    display: block;
}

.navbar-nav .dropdown-menu a {
    display: block;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    background-color: #fff;
}

.navbar-nav .dropdown-menu a:hover {
    background-color: #f5f5f5;
}



<?php
function register_custom_menu() {
    register_nav_menu('custom-menu', __('Custom Menu'));

    //Add theme support for document title tag
    add_theme_support( "title-tag" );
}
add_action('after_setup_theme', 'register_custom_menu');
?>



/* Dynamic Menu Dropdown Function  */
<?php
class Custom_Nav_Walker extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = array();
        if ($item->current || $item->current_item_ancestor) {
            $classes[] = 'active';
        }
        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
        }
        
        $class_names = implode(' ', $classes);
        
        $output .= $indent . '<li class="' . $class_names . '">';
        
        if ($item->url && $item->url !== '#') {
            $output .= '<a class="nav-link" href="' . $item->url . '">' . $item->title . '</a>';
        } else {
            $output .= '<span class="nav-link">' . $item->title . '</span>';
        }
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "</ul>\n";
    }
}
?>




