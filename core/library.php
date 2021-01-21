<?php 

function get_rank($rep){
	$class = '';
	if ($rep <= 100){
		$class = "Jedi Youngling";
		return "<span class='badge badge-pill badge-primary'>".$class."</span>";
	} else if ($rep > 100 && $rep <= 500){
		$class = "Jedi Padawan";
		return "<span class='badge badge-pill badge-secondary'>".$class."</span>";
	} else if ($rep > 500 && $rep <= 1500){
		$class = "Jedi Knight";
		return "<span class='badge badge-pill badge-warning'>".$class."</span>";
	} else if ($rep > 1500 && $rep <= 4000){
		$class = "Jedi Master";
		return "<span class='badge badge-pill badge-danger'>".$class."</span>";
	} else if ($rep > 4000){
		$class = "Jedi Grand Master";
		return "<span class='badge badge-pill badge-dark'>".$class."</span>";
	}

}

function format_list($data){
	$element = '<ul style="list-style-type:none;padding:0;">';
	if (isset($data) && !empty($data)){
		$data = explode(',',$data);
		foreach($data as $d){
			$element .= '<li class="alert alert-warning" style="padding:5px 10px;margin:3px 0;">' . $d . '</li>';
		} 
	} else {
		return "<div class='alert alert-warning'>Per request.</div>";
	}
	return $element . '</ul>';
}

?>