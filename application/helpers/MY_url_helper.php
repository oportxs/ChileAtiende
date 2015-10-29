<?php
    function url_buscador($name = '', $value = '', $remove = false, $multiple = false)
    {   
        $CI =& get_instance();

        $full_url = current_url();

        $active_params = $CI->input->get();

        $url_params = array();

        //Se remueve el offset
        unset($active_params['offset']);

        if($multiple && isset($active_params[$name])){
            if($remove){
                $active_params[$name] = removeValueFromFilters($value, $active_params[$name]);
                if($active_params[$name] == '')
                    unset($active_params[$name]);
            }else{
                $active_params[$name] = $active_params[$name].','.htmlspecialchars($value);
            }
        }else{
            if($remove)
                unset($active_params[$name]);
            elseif($name != '')
                $active_params[$name] = htmlspecialchars($value);
        }

        if($active_params){
            foreach ($active_params as $name => $value) {
                $url_params[] = $name.'='.htmlspecialchars($value);
            }
        }

        if($url_params)
            return $full_url.'?'.implode('&', $url_params);
        else
            return $full_url.'?';
    }

    function removeValueFromFilters($value, $filters, $delimiter = ',')
    {
        $filters = explode($delimiter, $filters);
        unset($filters[array_search($value, $filters)]);
        return implode(',', $filters);
    }
?>