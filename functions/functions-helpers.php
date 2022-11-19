<?php

    // Include SVG inline
    function theme_svg($file){
        $return_svg = '';
        if ( file_exists(STYLESHEETPATH . '/assets/img/' . $file . '.svg')){
            ob_start();
            include(STYLESHEETPATH . '/assets/img/' . $file . '.svg');
            $return_svg = ob_get_clean();
        }
        return $return_svg;
    }




    // check if link is external
    function externalLink($link){
        // returns bool val if link contains http and has home url
        // checks, doesn't contain home url and has http
        // true is _blanks, false is _self
        
        // order, check if home url in link, _self if 
        // check if link is then a http, presume going elsewhere _blank
        // default to _self if anything else

        if(strpos($link, get_home_url()) !== false){
            return false;
        } elseif(strpos($link, 'http') !== false) {
            return true;
        } else {
            return false;
        }
    }




    function includeComponent($slug, $echo = false, $args = array()){
        $returnComponent = '';
        $path = 'components/'.$slug.'/'.$slug.'.php';

        foreach($args as $k => $v){
            $$k = $v;
        }

        if ( file_exists(STYLESHEETPATH . '/'. $path)){
            ob_start();
            include(locate_template($path));
            $returnComponent = ob_get_clean();
        } else { $returnComponent = 'Component does not exist'; }
        
        if($echo)
            echo $returnComponent;
        else
            return $returnComponent;
    }



    function addFormItem($options = array()){

        [
            'type' => $type, // !required
            'atts' => $atts, // !required  
            'vueEvents' => $vue, // !optional
        ] = $options;

        if($type && $atts){

            [
                'name' => $name, 
                'options' => $options, 
                'default_option' => $default, 
                'required' => $required 
            ] = $atts;

            if($vue)
                $vue = buildVue($vue);

            ob_start();
            include(locate_template('components/form/'.$type.'/'.$type.'.php'));
            echo ob_get_clean();

        }
    }

    function buildVue($propsArr){
        $vue = array();
        foreach($propsArr as $prop){
            foreach($prop as $k => $v){
                $vue[] = $k.'="'.$v.'"';
            }
        }
        return implode(' ', $vue);
    }

    function buildBrand($id){
        if($id > 0)
            $arr = array(
                'featured_image' => wp_get_attachment_image_src(get_post_thumbnail_id($id), 'large'),
                'brand_color' => get_field('brand_color', $id),
                'font_color' => get_field('font_color', $id),
                'brand_logo' => get_field('brand_logo', $id),
                'content' => get_field('content', $id),
                'title' => get_the_title($id),
                'schema' => array(
                    'logo' => get_field('schema_logo', $id),
                    'address' => get_field('schema_address', $id)
                )
            );
        else
            $arr = array(
                'featured_image' => false,
                'brand_color' => '#072A3A',
                'font_color' => '#FFF',
                'brand_logo' => theme_svg('branding/ITC'),
                'content' => '',
                'title' => get_bloginfo('name'),
            );

        return $arr;
    }


    function jobSchema($brandArr){
        
        $qo = get_queried_object();
        
        foreach($brandArr as $k => $v)
            $$k = $v;

        return '
            <script type="application/ld+json">
                {
                    "@context" : "https://schema.org/",
                    "@type" : "JobPosting",
                    "title" : "'. get_the_title() .'",
                    "description" : "<p>Apply for the role here.</p>",
                    "datePosted" : "'. get_the_date() .'",
                    "employmentType" : "CONTRACTOR",
                    "hiringOrganization" : {
                        "@type" : "Organization",
                        "name" : "'. get_bloginfo('name') .'",
                        "sameAs" : "'. get_home_url() .'",
                        "logo" : "'. $schema['logo']['sizes']['large'] .'"
                    },
                    "jobLocation": {
                    "@type": "Place",
                        "address": {
                            "@type": "PostalAddress",
                            "streetAddress": "'. $schema['address']['street'] .'",
                            "addressLocality": "'. $schema['address']['town'] .'",
                            "addressRegion": "'. $schema['address']['county'] .'",
                            "postalCode": "'. $schema['address']['postcode'] .'",
                            "addressCountry": "'. $schema['address']['country'] .'"
                        }
                    }
                }
            </script>
        ';
    }