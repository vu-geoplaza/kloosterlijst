<?php

# safe_params.inc - safe parameter handling for scripts that insert user input
# into sql, html or url code.

# functions to escape special characters in a parameter value in order to insert
# it in a template in a safe way depending on the context in which it is used.
# WARNING:
#   The correct working of safe_str_sql depends on information about the
#   character encoding expected by the database server as is provided
#   by the active mysql connection object. So it is important to set up the
#   database connection first by a call to mysqli_connect BEFORE safe_str_sql
#   is used.
# for insertion as a string parameter in mysql queries
function safe_str_sql($value){
	$db = include('db_connect.inc');
	if(! $db) {
		die("Kan niet verbinden: ".mysqli_error());
	}
   return mysqli_real_escape_string($db, $value);
} 

# for insertion as a string parameter in html output
function safe_str_html($value){ 
   return  htmlspecialchars($value); 
} 

# for insertion as a string parameter in the query string of an url
function safe_str_url($value){ 
   return urlencode($value); 
} 

# for insertion as a integer parameter in any context
function safe_int($value){ 
   return (int) $value; 
} 

# for insertion as a floating point parameter in any context
function safe_float($value){ 
   return (float) $value; 
} 


# the purpose of class Template_params is to define an object which is used to
# collect parameters in its properties as an alternative to an hash array.
class Template_params {
}


# class Safe_template and its subclasses
# implement functions to safely interpolate parameters into template strings
# depending on the context in which they are used: sql, html or url.
# The parent class Safe_template can not be used directly.
# There are specific subclasses for each context:
# Sql_template, Html_template and Url_template.
#
#  The object contains a template string with a format
#  in the style of dictionary-based variable interpolation of python:
#    "text %(var1)s %(var2)d %(var3)f text" % dictionary
#  This is similar to the syntax of sprintf templates without the formatting
#  options, but with parameter references using variable names.
#  A literal %-character can be included in the template string by specifying
#  a double %%.
# The interpolate($params) method can be used to bind these variable names to
# values and replace the references by the corresponding values.
#  Example:
#    $query_template = new Sql_template();
#    $query_template->template = "SELECT name, id, weight FROM items WHERE name = '%(var1)s' and id = %(var2)d and weight = %(var3)f";
#    $params = array();
#    $params['var1'] = 'pencil';
#    $params['var2'] = 27;
#    $params['var3'] = 12.5;
#    $query = $query_template->interpolate($params)
#  where
#  $params
#	is an associative array (hash) containing key-value pairs with
# 	the variable names as keys or $params is an object having the variables
#	as attributes.
#  %(var1)s
#	substitutes parameter named var1 as a string value
#  %(var2)d
#	substitutes parameter named var2 as an integer formatted in decimal
#  %(var3)f
#	substitutes parameter named var3 as a number formatted in floating
#	point notation
#
# Property template is the template string. This string can be set when the
# object is created or by modifying the value of the template property.
class Safe_template {
    public $context = 'none';
    protected $_delim1 = '%(';	# opening delimiter
    protected $_delim2 = ')';	# closing delimiter of variable names
    protected $_percent = '%';
    protected $_double_percent = '%%';
    protected $_percent_code = '%(_PERCENT_)s';

    function __construct($template='') {
	$this->template = $template;	# template string
	$this->references = null;	# result of search for variable
					# references using preg_match_all
	$this->mapping = array();	# mapping of references to values
    }

    # prepares template object for use by fetching the variable references
    # and conversion types from the template string into an array
    function prepare() {
	# encode literal percent characters notated by double percent
	$this->template = str_replace($this->_double_percent, $this->_percent_code, $this->template);

	# collect variable references '%(var)s', '%(var)d' or '%(var)f'
	$delim1 = preg_quote($this->_delim1, '/');
	$delim2 = preg_quote($this->_delim2, '/');
	$pattern = '/' . $delim1 . '(\w+)' . $delim2 . '([sdf])/';
	$m = preg_match_all($pattern, $this->template, $matches, PREG_SET_ORDER);
	if($m === FALSE) {
	    die("template parsing error in ". safe_str_html($this->template));
	}
	if($m == 0) {	# no matches, template has no variable references
	    $this->references = array();
	} else {
	    $this->references = $matches;
	}
    }


    function interpolate($params)
    {
	# fetch variable references from template string
	$this->prepare();

	if(!empty($this->references)) {
	    if(is_object($params)) {
		$params = get_object_vars($params);
	    }
	    if(!is_array($params)) {
		return null;
	    }
	    
	    $this->resolve_references($params);
	    # add mapping entry for decoding the literal percent characters
	    $this->mapping[$this->_percent_code] = $this->_percent;

	    # perform substitutions using the constructed mapping
	    $result = str_replace(array_keys($this->mapping), array_values($this->mapping), $this->template);
	} else {	# template is fixed string
	    $result = $this->template;
	    # decode literal percent characters
	    $result = str_replace($this->_percent_code, $this->_percent, $result);
	}
	return $result;
    }

    # The subclasses implement context dependent versions of resolve_references
    function resolve_references($params)
    {
    }

    function get_default_value($type) {
	switch($type) {
	case 's':
	    return (string) '';
	case 'd':
	    return (string) 0;
	case 'f':
	    return (string) 0.0;
	}
	return null;
    }

}		#--- end of class Safe_template ---


# The subclasses implement context dependent versions of resolve_references

class Sql_template extends Safe_template {
    public $context = 'sql';

    function resolve_references($params)
    {
	$mapping = array();
	foreach($this->references as $ref_item)
	{
	    $refstr = $ref_item[0];
	    $var = $ref_item[1];
	    $type = $ref_item[2];
	    if(!isset($mapping[$refstr])) {
		if(isset($params[$var])) {
		    $val = $params[$var];
		    switch($type) {
		    case 's':
			$mapping[$refstr] = (string) safe_str_sql($val);
			break;
		    case 'd':
			$mapping[$refstr] = (string) safe_int($val);
			break;
		    case 'f':
			$mapping[$refstr] = (string) safe_float($val);
			break;
		    }
		} else {	# if the parameter is absent in params
		    $mapping[$refstr] = $this->get_default_value($type);
		}
	    }
	}
	$this->mapping = $mapping;
	return;
    }

}	#--- end of class Sql_template ---


class Html_template extends Safe_template {
    public $context = 'html';

    function resolve_references($params)
    {
	$mapping = array();
	foreach($this->references as $ref_item)
	{
	    $refstr = $ref_item[0];
	    $var = $ref_item[1];
	    $type = $ref_item[2];
	    if(!isset($mapping[$refstr])) {
		if(isset($params[$var])) {
		    $val = $params[$var];
		    switch($type) {
		    case 's':
			$mapping[$refstr] = (string) safe_str_html($val);
			break;
		    case 'd':
			$mapping[$refstr] = (string) safe_int($val);
			break;
		    case 'f':
			$mapping[$refstr] = (string) safe_float($val);
			break;
		    }
		} else {	# if the parameter is absent in params
		    $mapping[$refstr] = $this->get_default_value($type);
		}
	    }
	}
	$this->mapping = $mapping;
	return;
    }

}	#--- end of class Html_template ---


class Url_template extends Safe_template {
    public $context = 'url';

    function resolve_references($params)
    {
	$mapping = array();
	foreach($this->references as $ref_item)
	{
	    $refstr = $ref_item[0];
	    $var = $ref_item[1];
	    $type = $ref_item[2];
	    if(!isset($mapping[$refstr])) {
		if(isset($params[$var])) {
		    $val = $params[$var];
		    switch($type) {
		    case 's':
			$mapping[$refstr] = (string) safe_str_url($val);
			break;
		    case 'd':
			$mapping[$refstr] = (string) safe_int($val);
			break;
		    case 'f':
			$mapping[$refstr] = (string) safe_float($val);
			break;
		    }
		} else {	# if the parameter is absent in params
		    $mapping[$refstr] = $this->get_default_value($type);
		}
	    }
	}
	$this->mapping = $mapping;
	return;
    }

}	#--- end of class Url_template ---


#--- end of subclasses of class Safe_template ---



?>
