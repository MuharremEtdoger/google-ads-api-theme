<?php
	function ars_get_svg_icon($type){
		$svgs_array=array(
			'mail-line'=>'<svg class="align-middle feather feather-mail me-2"fill=none height=24 stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=2 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
			'pass' => '<svg class="align-middle feather feather-lock me-2"fill=none height=24 stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=2 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><rect height=11 rx=2 ry=2 width=18 x=3 y=11></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',			
			'user' => '<svg class="align-middle feather feather-user me-2"fill=none height=24 stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=2 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx=12 cy=7 r=4></circle></svg>',
		);
		return $svgs_array[$type];
	}