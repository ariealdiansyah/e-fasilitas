<?php

if(!function_exists('getImg'))
{
	function getImg($file="",$width="",$height="auto",$class="",$type="")
	{
		$img = "<img src='".base_url('assets/images/'.$file)."' width='".$width."' height='".$height."' ".$class.">";
		if ($type == 'url') {
			$img = "<img src='".$file."' width='".$width."' height='".$height."' ".$class.">";
		}

		return $img;

	}
}

if (!function_exists('getModule')) {
	function getModule()
	{
		$CI = get_instance();
		$query = $CI->router->fetch_module();
		return $query;
	}
}

if (!function_exists('getController')) {
	function getController()
	{
		$CI = get_instance();
		$query = $CI->router->fetch_class();
		return $query;
	}
}

if (!function_exists('getFunction')) {
	function getFunction()
	{
		$CI = get_instance();
		$query = $CI->router->fetch_method();
		return $query;
	}
}

if(!function_exists('deleteDir')){
	function deleteDir($dirPath)
	{
		if(is_dir($dirPath)){
			$files = glob( $dirPath . '*', GLOB_MARK ); 
			foreach( $files as $file )
			{
				deleteDir( $file );      
			}

			rmdir( $dirPath );
		} elseif(is_file($dirPath)) {
			unlink( $dirPath );  
		}
	}
}

if ( ! function_exists('basic_select'))
{
	function basic_select($table="",$field="",$params="",$placeholder="",$required="")
	{
		$CI =& get_instance();

		$type = $CI->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		$enum = explode("','", $matches[1]);
		$select = "<select class='form-control search-select' name='".$field."' id='".$field."' style='color:black;' data-validation='".$required."' data-placeholder='".$placeholder."'>";
		$select .= "<option></option>";
		foreach ($enum as $key => $value) {
			$key = $key + 1;
			if($value==$params)
			{
				$select .= "<option value='".$key."' selected>".$value."</option>";
			}
			else{
				$select .= "<option value='".$key."'>".$value."</option>";
			}
		}
		$select .= "</select>";
		return $select;
	}
}

if ( ! function_exists('select_join'))
{
	function select_join($show="",$column="",$table="",$id="",$field="",$condition="",$params="",$required="",$placeholder="",$disabled="", $width = "100%")
	{
		$CI =& get_instance();
		$CI->load->model('model','',FALSE);
		if (!empty($condition)) {
			$query = $CI->model->get($table,$column,$condition);
		}
		else{
			$query = $CI->model->get($table,$column);
		}		

		$select  = "<select class='form-control search-select' '".$required."' data-placeholder='".$placeholder."' name='".$field."' id='".$field."' style='color:black;width:{$width};' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' $disabled>";
		$select .= "<option></option>";
		foreach ($query as $key => $value) {
			// $select .="<option value=''>No Select</option>";
			if($value[$id]==$params)
			{
				$select .= "<option value='".$value[$id]."' selected>".$value[$show]."</option>";
			}
			else {
				$select .= "<option value='".$value[$id]."'>".$value[$show]."</option>";

			}
		}

		$select .= "</select>";

		$select .= "<div class='text-danger'>".form_error($field)."</div>";

		return $select;
	}
}

if ( ! function_exists('select_array'))
{
	function select_array($arr, $params, $field, $placeholder = "", $width = "100%", $search = TRUE)
	{
		$select  = "<select class='form-control " . ($search ? "search-select" : "") . "' name='".$field."' id='".$field."' style='color:black;width:{$width};' data-placeholder='".$placeholder."'>";
		$select .= $search ? "<option></option>" : "<option>{$placeholder}</option>";
		foreach ($arr as $key => $value) {
			// $select .="<option value=''>No Select</option>";
			if($key==$params)
			{
				$select .= "<option value='".$key."' selected>".$value."</option>";
			}
			else {
				$select .= "<option value='".$key."'>".$value."</option>";

			}
		}

		$select .= "</select>";

		return $select;
	}
}

if ( ! function_exists('select_checkbox'))
{
	function select_checkbox($arr, $params, $placeholder = "")
	{
		$select = "<div class='button-group'>";
		$select .= "<button type='button' class='btn btn-default dropdown-toggle waves-effect' data-toggle='dropdown' aria-expanded='false'>{$placeholder} <span class='caret'></span></button>";
		$select .= "<ul class='dropdown-menu' role='menu'>";
		foreach ($arr as $key => $value) {
			$select .= "<li>";
			$select .= "<a href='#' class='small' data-value='{$key}' tabIndex='-1'>";
			$select .= "		<div class='checkbox checkbox-success'>";
			$select .= "			<input type='checkbox' " . ($key == $params || $params == "all" ? "checked" : "") . ">";
			$select .= "			<label>";
			$select .= "				{$value}";
			$select .= "			</label>";
			$select .= "		</div>";
			$select .= "	</a>";
			$select .= "</li>";
		}

		$select .= "</ul>";
		$select .= "</div>";

		return $select;
	}
}

if ( ! function_exists('select_join_multiple_group'))
{
	function select_join_multiple($show="",$column="",$table="",$id="",$field="",$condition="",$params="",$required="",$placeholder="",$disabled="")
	{
		$CI =& get_instance();
		$CI->load->model('model','',FALSE);
		if (!empty($condition)) {
			$query = $CI->model->get($table,$column,$condition);
		}
		else{
			$query = $CI->model->get($table,$column);
		}		

		$select  = "<select class='form-control search-select' '".$required."' data-placeholder='".$placeholder."' name='".$field."' id='".$field."' style='color:black;width:100%;' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' $disabled multiple>";
		$select .= "<option></option>";
		foreach ($query as $key => $value) {
			// $select .="<option value=''>No Select</option>";
			if($value[$id]==$params)
			{
				$select .= "<option value='".$value[$id]."' selected>".$value[$show]."</option>";
			}
			else {
				$select .= "<option value='".$value[$id]."'>".$value[$show]."</option>";

			}
		}

		$select .= "</select>";
		return $select;
	}
}

if (!function_exists('input_text')) {
	function input_text($name="",$value="",$placeholder="",$required="",$attr = array(),$help="",$lenght="",$type=""){
		$CI =& get_instance();
		$attribute = ' ';
		if (empty($type)) {
			$type = "text";
		}else{
			$type = $type;
		}
		if(!empty($attr) OR is_array($attr))
		{
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}

		$query = "<input type='".$type."' name='".$name."' id=".$name." class='form-control' placeholder='".$placeholder."' value='".$value."' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."'>";
		
		$query .= "<div class='text-danger'>".form_error($name)."</div>";

		return $query;
	}
}

if (!function_exists('input_email')) {
	function input_email($name="",$value="",$placeholder="",$required="",$attr = array(),$lenght=""){
		$CI =& get_instance();
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}

		$query = "<input type='text' name='".$name."' id=".$name." class='form-control' placeholder='".$placeholder."' value='".$value."' data-validation='".$required." email' data-validation-error-msg-required='Anda belum mengisi field ini' data-validation-error-msg-email='Anda belum memberikan alamat email yang benar' '".$attribute."'>";

		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		
		return $query;
	}
}

if (!function_exists('input_text_group')) {
	function input_text_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$help="",$lenght="",$type=""){
		$CI =& get_instance();
		$attribute = ' ';
		if (empty($type)) {
			$type = "text";
		}else{
			$type = $type;
		}
		if(!empty($attr) OR is_array($attr))
		{
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<input type='".$type."' name='".$name."' id=".$name." class='form-control' placeholder='".$placeholder."' value='".$value."' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."'>";
		if ($help) {
			$query .= "<span class='help-block'><small>".$help."</small></span>";
		}
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}


if (!function_exists('input_price_group')) {
	function input_price_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$help="",$lenght=""){
		$CI =& get_instance();
		$attribute = ' ';
		if(!empty($attr) OR is_array($attr))
		{
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<input type='text' name='".$name."' id=".$name." class='form-control' placeholder='".$placeholder."' value='".$value."' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."' onkeyup='nominal(this)'>";
		if ($help) {
			$query .= "<span class='help-block'><small>".$help.".</small></span>";
		}
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if (!function_exists('input_textarea')) {
	function input_textarea($name="",$value="",$placeholder="",$required="",$attr = array(),$lenght="",$help=""){
		$CI =& get_instance();
		$attribute = ' ';		
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}

		$query = "<textarea name='".$name."' placeholder='".$placeholder."' class='form-control' rows='6' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."'>".$value."</textarea>";
		
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		return $query;
	}
}

if (!function_exists('input_textarea_group')) {
	function input_textarea_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$lenght="",$help=""){
		$CI =& get_instance();
		$attribute = ' ';		
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<textarea name='".$name."' placeholder='".$placeholder."' class='form-control' rows='6' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."'>".$value."</textarea>";
		if ($help) {
			$query .= "<span class='help-block'><small>".$help.".</small></span>";
		}
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}


if (!function_exists('input_texteditor_group')) {
	function input_texteditor_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$lenght=""){
		$CI =& get_instance();
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<textarea name='".$name."' placeholder='".$placeholder."' class='form-control editor' rows='6' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attr."'>".$value."</textarea>";
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if ( ! function_exists('input_daterange'))
{
	function input_daterange($name="",$value="",$placeholder="",$required="")
	{
		$query = "<input type='text' name='".$name."' value='".$value."' class='form-control date-picker' id='".$name."' placeholder='".$placeholder."' onkeyup='nominal(this)' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini'>";
		return $query;
	}
}

if ( ! function_exists('input_daterange_group'))
{
	function input_daterange_group($name="",$value="",$placeholder="",$required="",$label="",$lenght="")
	{
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<input type='text' name='".$name."' value='".$value."' class='form-control date-picker' id='".$name."' placeholder='".$placeholder."' onkeyup='nominal(this)' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini'>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if (!function_exists('input_email_group')) {
	function input_email_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$lenght=""){
		$CI =& get_instance();
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<input type='text' name='".$name."' id=".$name." class='form-control' placeholder='".$placeholder."' value='".$value."' data-validation='".$required." email' data-validation-error-msg-required='Anda belum mengisi field ini' data-validation-error-msg-email='Anda belum memberikan alamat email yang benar' '".$attribute."'>";
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if (!function_exists('input_icon_group')) {
	function input_icon_group($name="",$label="",$value="",$placeholder="",$required="",$attr = array(),$lenght=""){
		$CI =& get_instance();
		if(!empty($attr) OR is_array($attr))
		{
			$attribute = ' ';
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		$query .= "<input type='text' name='".$name."' id=".$name." class='form-control icp icp-auto' placeholder='".$placeholder."' value='".$value."' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' '".$attribute."'>";
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if (!function_exists('input_radio_group')) {
	function input_radio_group($name="",$label="",$val=array(),$params="",$required="",$lenght="")
	{
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		foreach ($val as $key => $value) {
			$query .= "<div class='radio radio-primary radio-inline'>";
			if ($key==$params) {
				$query .= "<input type='radio' checked name='".$name."' value='".$key."' data-validation='".$required."' data-validation-error-msg='Anda harus memilih salah satu dari opsi yang ada' data-validation-error-msg-container='.error-radio-msg'>";
			}else{
				$query .= "<input type='radio' name='".$name."' value='".$key."' data-validation='".$required."' data-validation-error-msg='Anda harus memilih salah satu dari opsi yang ada' data-validation-error-msg-container='.error-radio-msg'>";
			}
			$query .= "<label for='".$name."'> ".$value." </label>";
			$query .= "</div>";
		}
		$query .= "</div>";
		$query .= "<div class='error-radio-msg col-sm-6'></div>";
		$query .= "</div>";
		return $query;
	}
}

if (!function_exists('input_checkbox_group')) {
	function input_checkbox_group($name="",$label="",$val=array(),$params="",$required="",$lenght="")
	{
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		foreach ($val as $key => $value) {
			$query .= "<div class='checkbox-inline'>";
			if ($key==$params) {
				$query .= "<input type='checkbox' checked name='".$name."' data-validation='".$required."' >";
			}else{
				$query .= "<input type='checkbox' name='".$name."' data-validation='".$required."'>";
			}
			$query .= "<label for='".$name."'> ".$value." </label>";
			$query .= "</div>";
		}
		$query .= "</div>";
		$query .= "<div class='error-radio-msg col-sm-6'></div>";
		$query .= "</div>";
		return $query;
	}
}

if ( ! function_exists('input_file_image_group'))
{
	function input_file_image_group($name="",$label="",$value="",$action=array(),$required="", $margin="", $attr = array(),$lenght="")
	{
		$CI =& get_instance();
		$attribute = ' ';
		if(!empty($attr) OR is_array($attr))
		{
			foreach($attr as $key => $attrs)
			{
				$attribute .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$delete = ' ';
		if(!empty($action) OR is_array($action))
		{
			foreach($action as $key => $attrs)
			{
				$delete .= ' '.$key.'="'.$attrs.'"';
			}
		}
		$query  = "<div class='form-group'>";
		$query .= "<label for='".$name."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$query .= "<div class='col-sm-".$lenght."'>";
		} else {
			$query .= "<div class='col-sm-6'>";
		}
		if($value!=""){
			$query .= "<img src='".$value."' height='75'>";
			$query .= "&nbsp; <a style='cursor:pointer' class='del-dialog' '".$delete."'><img src='".base_url('assets/backend/images/icons/delete.png')."' height='25px'></i></a>";
		} else {
			$query .= "<input type='file' name='".$name."' value='".$value."' id='".$name."'$margin' data-validation='".$required." mime size' data-validation-allowing='jpg, png, jpeg' data-validation-max-size='1M' data-validation-error-msg='Field ini wajib diisi' data-validation-error-msg-mime='Field ini wajib diisi foto' data-validation-error-msg-size='Maksimal ukuran gambar adalah 1MB' accept='image/jpg,image/png,image/jpeg'>";
		}
		$query .= "<div class='text-danger'>".form_error($name)."</div>";
		$query .= "</div>";
		$query .= "</div>";
		return $query;
	}
}

if ( ! function_exists('select_join_group'))
{
	function select_join_group($show="",$column="",$table="",$id="",$field="",$label="",$condition="",$params="",$required="",$placeholder="",$help="",$disabled="",$lenght="")
	{
		$CI =& get_instance();
		$CI->load->model('model','',FALSE);
		if (!empty($condition)) {
			$query = $CI->model->get($table,$column,$condition);
		}
		else{
			$query = $CI->model->get($table,$column);
		}		

		$select  = "<div class='form-group'>";
		$select .= "<label for='".$field."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$select .= "<div class='col-sm-".$lenght."'>";
		} else {
			$select .= "<div class='col-sm-6'>";
		}
		$select .= "<select class='form-control search-select' '".$required."' data-placeholder='".$placeholder."' name='".$field."' id='".$field."' style='color:black;width:100%;' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' $disabled>";
		$select .= "<option></option>";
		foreach ($query as $key => $value) {
// $select .="<option value=''>No Select</option>";
			if($value[$id]==$params)
			{
				$select .= "<option value='".$value[$id]."' selected>".$value[$show]."</option>";
			}
			else {
				$select .= "<option value='".$value[$id]."'>".$value[$show]."</option>";

			}
		}

		$select .= "</select>";
		if ($help) {
			$select .= "<span class='help-block'><small>".$help.".</small></span>";
		}
		$select .= "<div class='text-danger'>".form_error($field)."</div>";
		$select .= "</div>";
		$select .= "</div>";
		return $select;
	}
}


if ( ! function_exists('select_join_multiple_group'))
{
	function select_join_multiple_group($show="",$column="",$table="",$id="",$field="",$label="",$condition="",$params="",$required="",$placeholder="",$help="",$disabled="",$lenght="")
	{
		$CI =& get_instance();
		$CI->load->model('model','',FALSE);
		if (!empty($condition)) {
			$query = $CI->model->get($table,$column,$condition);
		}
		else{
			$query = $CI->model->get($table,$column);
		}		

		$select  = "<div class='form-group'>";
		$select .= "<label for='".$field."' class='col-lg-2 col-sm-2 control-label'>".$label."</label>";
		if(!empty($lenght)){
			$select .= "<div class='col-sm-".$lenght."'>";
		} else {
			$select .= "<div class='col-sm-6'>";
		}
		$select .= "<select class='form-control search-select' '".$required."' data-placeholder='".$placeholder."' name='".$field."' id='".$field."' style='color:black;width:100%;' data-validation='".$required."' data-validation-error-msg='Anda belum mengisi field ini' $disabled multiple>";
		$select .= "<option></option>";
		foreach ($query as $key => $value) {
// $select .="<option value=''>No Select</option>";
			if($value[$id]==$params)
			{
				$select .= "<option value='".$value[$id]."' selected>".$value[$show]."</option>";
			}
			else {
				$select .= "<option value='".$value[$id]."'>".$value[$show]."</option>";

			}
		}

		$select .= "</select>";
		if ($help) {
			$select .= "<span class='help-block'><small>".$help.".</small></span>";
		}
		$select .= "<div class='text-danger'>".form_error($field)."</div>";
		$select .= "</div>";
		$select .= "</div>";
		return $select;
	}
}

if ( ! function_exists('input_radio'))
{
	function input_radio($table="",$field="",$params="",$required="")
	{
		$CI =& get_instance();

		$type = $CI->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		$enum = explode("','", $matches[1]);
		$no = 1;
		foreach ($enum as $key => $value) {
			$radio =  "<label class='radio-inline'>";
			$key = $key + 1;

			if($value==$params)
			{
				$radio .= "<input type='radio' name='".$field."' value='".$key."' checked data-validation-error-msg='Pilih salah satu'  data-validation='".$required."' >".$value;
			}
			else{
				$radio .= "<input type='radio' name='".$field."' value='".$key."' data-validation='".$required."' data-validation-error-msg='Pilih salah satu' >".$value;
			}
			$radio .= "</label>";
			echo $radio;
		}
	}
}


function hash_password($string)
{
	$pengacak  = "3xP0r4D3v3L0p3R";
	$hash = md5($pengacak.md5($string).$pengacak);
	return $hash;
}

function range_years($start){
	$current_year = date('Y');
	for ($count = $current_year; $count >= $start; $count--)
	{
		$option = "<option value='{$count}'>{$count}</option>";
		echo $option;
	}	
}

if (!function_exists('count_all')) 
{
	function count_all($table="",$column="")
	{
		$CI =& get_instance();
		if ($column) {
			$CI->db->where($column);
		}
		$CI->db->from($table);
		return $CI->db->count_all_results(); 
	}
}

function getField($table="default",$field="",$params=""){

	$CI =& get_instance();

	$result = 0;	

	$CI->db->select($field);	
	if ($params) {
		$CI->db->where($params);
	}
	$query = $CI->db->get($table)->result_array();

	foreach($query as $row) {
		$result = $row[$field];
	}

	return $result;

}

function getMenu($field,$params="",$params2=""){

	$CI =& get_instance();

	empty($params) ? $params = getFunction() : $params = $params;
	empty($params2) ? $params2 = "" : $params2 = "/".$params2;

// $kodeInduk =  $CI->model->get_where('master_menu',array('namaMenu'=>getController()));
// $result = $CI->model->get_where('master_menu',array('kodeInduk'=>$kodeInduk[0]['idMenu'],'namaMenu'=>getFunction()));

	$result = $CI->model->get_where('master_menu',array('targetMenu'=>getModule()."/".getController()."/".$params.$params2));

	foreach($result as $row) {
		$result = $row[$field];
	}

	return $result;
}

function getCategory($field,$params=""){

	$CI =& get_instance();

// $kodeInduk =  $CI->model->get_where('master_menu',array('namaMenu'=>getController()));
// $result = $CI->model->get_where('master_menu',array('kodeInduk'=>$kodeInduk[0]['idMenu'],'namaMenu'=>getFunction()));

	$result = $CI->model->get_where('master_category',array('idCategory'=>$params));

	foreach($result as $row) {
		$result = $row[$field];
	}

	return $result;
}

function getBread(){
	$text = "
	<div class=\"row\">
		<div class=\"col-sm-12\">
			<h4 class=\"pull-left page-title\">".ucfirst(getModule())."</h4>
			<ol class=\"breadcrumb pull-right\">
				<li>".ucfirst(getModule())."</li>
				<li>".ucfirst(getController())."</li>
				<li class=\"active\">".ucfirst(getFunction())."</li>
			</ol>
		</div>
	</div>";

	return $text;
}

function getBreadCustom($breads = array()){
	$text = "
	<div class=\"row\">
		<div class=\"col-sm-12\">
			<h4 class=\"pull-left page-title\">{$breads['title']}</h4>
			<ol class=\"breadcrumb pull-right\">";
				foreach ($breads['childs'] as $bread) {
					if(end($breads['childs']) == $bread)
						$text .= "<li class=\"active\">".ucfirst($bread)."</li>";
					else{
						$text .= "<li>".ucfirst($bread)."</li>";
					}
				}
				$text .= "
			</ol>
		</div>
	</div>";

	return $text;
}

if(!function_exists('random_code'))
{
	function random_code()
	{
		$number = "";
		for($i=0; $i<5; $i++){
			$min = ($i == 0) ? 1:0;
			$number .= mt_rand($min,9);
		}
		return $number;
	}
}

if(!function_exists('random_password'))
{
	function random_password()
	{		
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 4; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
}

if(!function_exists('getMember'))
{
	function getMember($field="")
	{
		$CI =& get_instance();

		$query = $CI->model->join('user','*,
			user.idUser as id,
			master_provinsi.namaData as nama_provinsi,
			master_kota.namaData as nama_kota',array(
				array(
					'table'=>'user_info','parameter'=>'user.idUser=user_info.idUser'
					),
				array(
					'table'=>'master_data as master_provinsi','parameter'=>'user_info.provinsi=master_provinsi.idData'
					),
				array(
					'table'=>'master_data as master_kota','parameter'=>'user_info.kota=master_kota.idData'
					)
				),array('user.usernameUser'=>$CI->session->userdata('usernameUser')));

		return @$query[0][$field];
	}
}

if(!function_exists('setTanggal'))
{
	function setTanggal($string="")
	{

		$date = date('Y-m-d',strtotime($string));

		return $date;

	}
}

if(!function_exists('getTanggal'))
{
	function getTanggal($string="")
	{

		$date = date('d-m-Y',strtotime($string));

		return $date;

	}
}


if ( ! function_exists('input_price'))
{
	function input_price($name="",$value="",$placeholder="",$required="",$style="")
	{
		if($style){
			$style = "style='$style'";
		}
		$query = "<input type='text' name='".$name."' value='".$value."' class='form-control' id='".$name."' data-validation='".$required."' data-placeholder='".$placeholder."' data-validation-error-msg='Anda belum mengisi field ini' onkeyup='nominal(this)' ".$style.">";
		return $query;
	}
}

if ( ! function_exists('input_file_image'))
{
	function input_file_image($name="",$value="",$required="", $margin="")
	{
		$query = "<input type='file' name='".$name."' value='".$value."' id='".$name."'$margin' data-validation='".$required." mime size' data-validation-allowing='jpg, png, jpeg' data-validation-max-size='1M' data-validation-error-msg='Field ini wajib diisi' data-validation-error-msg-mime='Field ini wajib diisi foto' data-validation-error-msg-size='Maksimal ukuran gambar adalah 1MB' accept='image/jpg,image/png,image/jpeg'>";
		return $query;
	}
}

if (!function_exists('konversi_uang')) {
	function konversi_uang($angka="")
	{
		$nominal = number_format($angka,0,',','.');
		return $nominal;
	}
}

if (!function_exists('konversi_desimal')) {
	function konversi_desimal($angka="")
	{
		$nominal = number_format((float)$angka, 2, '.', '');
		return $nominal;
	}
}
if (!function_exists('getUrlCurrently')) {
	function getUrlCurrently($filter = array()) {
		$pageURL = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://";

		$pageURL .= $_SERVER["SERVER_NAME"];

		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= ":".$_SERVER["SERVER_PORT"];
		}

		$pageURL .= $_SERVER["REQUEST_URI"];


		if (strlen($_SERVER["QUERY_STRING"]) > 0) {
			$pageURL = rtrim(substr($pageURL, 0, -strlen($_SERVER["QUERY_STRING"])), '?');
		}

		$query = $_GET;
		foreach ($filter as $key) {
			unset($query[$key]);
		}

		if (sizeof($query) > 0) {
			$pageURL .= '?' . http_build_query($query);
		}

		return $pageURL;
	}
}

if(!function_exists('encode'))
{
	function encode($data="",$pad = NULL)
	{

		$data = str_replace(array('+', '/'), array('-', '_'), base64_encode($data));
		if (!$pad) {
			$data = rtrim($data, '=');
		}
		return $data;

	}
}

if(!function_exists('decode'))
{
	function decode($data="")
	{

		return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));

	}
}

if (!function_exists('setAngka')) {
	function setAngka($angka="")
	{
		$angka = str_replace(".", "", $angka);
		return $angka;
	}
}

function slug($string)
{
	$c = array (' ');
	$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	$string = str_replace($d, '', $string);
	$string = strtolower(str_replace($c, '-', $string));
	return $string;
}

if ( ! function_exists('getDateTime'))
{
	function getDateTime($date="")
	{						
		$array_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
		$array_bulan = array("1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli",
			"8" => "Agustus", "9" => "September", "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
			"08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "December");
		$text = $array_hari[date('N', $date)].", ".date('d', $date)." ".$array_bulan[date('m', $date)]." ".date('Y', $date)." ".date('H:i', $date)." WIB";
		return $text;
	}
}

function romanic_number($integer, $upcase = true) 
{ 
	$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
	$return = ''; 
	while($integer > 0) 
	{ 
		foreach($table as $rom=>$arb) 
		{ 
			if($integer >= $arb) 
			{ 
				$integer -= $arb; 
				$return .= $rom; 
				break; 
			} 
		} 
	} 

	return $return; 
} 

if ( ! function_exists('generateCode'))
{
	function generateCode($str="",$id="")
	{						

		if ($id < 10) {
			$num = "000".$id;
		}elseif ($id >= 10 AND $id < 100) {
			$num = "00".$id;
		}elseif ($id >= 100 AND $id < 1000) {
			$num = "0".$id;
		}elseif ($id >= 1000) {
			$num = $id;
		}

		$string = $str.$num;
		return $string;
	}
}

function kekata($x) {
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) {
		$temp = " ". $angka[$x];
	} else if ($x <20) {
		$temp = kekata($x - 10). " belas";
	} else if ($x <100) {
		$temp = kekata($x/10)." puluh". kekata($x % 10);
	} else if ($x <200) {
		$temp = " seratus" . kekata($x - 100);
	} else if ($x <1000) {
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
	} else if ($x <2000) {
		$temp = " seribu" . kekata($x - 1000);
	} else if ($x <1000000) {
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	} else if ($x <1000000000) {
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	} else if ($x <1000000000000) {
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	} else if ($x <1000000000000000) {
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	}     
	return $temp;
}


function terbilang($x) {
	if($x<0) {
		$hasil = "minus ". trim(kekata($x));
	} else {
		$hasil = trim(kekata($x));
	}     
	return $hasil;
}

if (!function_exists('getBulan')) {
	function getBulan($bln, $tipe='full') {
		$bln = $bln * 1;
		if($tipe == 'full') {
			$nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		}elseif ($tipe == 'romawi') {
			$nama_bulan = array(1=>"I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		} else {
			$nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		}
		return $nama_bulan[$bln];
	}
}

function redirect_back($url)
{
	$CI =& get_instance();
	$CI->session->set_userdata('redirect_back', $url);
}

function is_base64_encoded($data)
{
	if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function get_enum_values($table,$field)
{
	$CI =& get_instance();
	$type = $CI->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
	preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
	$enum = explode("','", $matches[1]);
	return $enum;
}