<?php
	add_shortcode( 'ars_prj_front_page', 'ars_prj_front_page_func' );
	function ars_prj_front_page_func($atts){
		global $td_option;
		$ArsGoogleAds=new ArsGoogleAds();
		$ArsGoogleAds->set_googleAdsClient();
		$ArsGoogleAds->set_managerCustomerId_loginCustomerId();	
		$accounts=$ArsGoogleAds->getCustomerListsQuery();	
		$hesap_sayfasi=get_permalink($td_option['of_accounts_page']);
		$html='';
		$html.='<div class="page-content">';
		   $html.='<div class="container-fluid">';
			  $html.='<div class="row">';
				 $html.='<div class="col-lg-12">';
					$html.='<div class="card">';
					   $html.='<div class="card-body">';
						  $html.='<div class="ars-card-title-area">';
							$html.='<h4 class="card-title ars-card-title mb-4">'.__('Hesaplar','arsoltranslate').'</h4>';
							$html.='<div class="ars-card-title-actions">';
								$html.='<button type="button" class="btn btn-light waves-effect ars-vis-hidden"><i class="bi bi-arrow-clockwise"></i> '.__('Güncelle','arsoltranslate').'</button>';
						    $html.='</div>';
						  $html.='</div>';
						  $html.='<div class="table-responsive">';
							 $html.='<table class="table align-middle table-nowrap mb-0">';
								$html.='<thead class="table-light">';
								   $html.='<tr>';
									  $html.='<th class="align-middle">'.__('Sıra','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Hesap ID','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Başlık','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Durum','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Detay','arsoltranslate').'</th>';
								   $html.='</tr>';
								$html.='</thead>';
								$html.='<tbody>';
								   if($accounts){
									   $counter=0;
									   foreach($accounts as $account){
										   $counter++;
										   $html.='<tr>';
											  $html.='<td>'.$counter.'</td>';
											  $html.='<td>'.$account['id'].'</td>';
											  $html.='<td>'.$account['descriptiveName'].'</td>';
											  $html.='<td>';
												 $html.='<span class="'.$account['status_detail']['class'].' font-size-11">'.__($account['status_detail']['title'],'arsoltranslate').'</span>';
											  $html.='</td>';
											  $html.='<td>';										 
												 $html.='<a type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" href="'.$hesap_sayfasi.'?accounts='.$account['id'].'">';
													$html.='Kampanyalar';
												 $html.='</a>';
											  $html.='</td>';
										   $html.='</tr>';										   
									   }
								   }else{
									   $html.='<tr>';
										$html.='<td colspan="5" class="text-center">';
											$html.='<span class="badge badge-pill badge-soft-warning font-size-11">'.__('Hesap Bulunamadı','arsoltranslate').'</span>';
										$html.='</td>';
									   $html.='</tr>';
								   }
								$html.='</tbody>';
							 $html.='</table>';
						  $html.='</div>';
					   $html.='</div>';
					$html.='</div>';
				 $html.='</div>';
			  $html.='</div>';
		   $html.='</div>';
		$html.='</div>';	
		return $html;
	}
	function ars_prj_clearly_user_view_accounts($accounts_id,$accounts){
		$visible=array();
		if(is_array($accounts_id)){
			$visible=$accounts_id;
		}else{
			$visible[]=$accounts_id;
		}
		$n_accounts=array();
		if($accounts){
			foreach($accounts as $key=>$account){
				$id=$account['id'];
				$in_array=0;
				if(!in_array($id,$visible)){
					unset($accounts[$key]);
				}
			}
			foreach($accounts as $account){
				$n_accounts[]=$account;
			}
		}
		
		return $n_accounts;
	}
	add_shortcode( 'ars_prj_account_page', 'ars_prj_account_page_func' );
	function ars_prj_account_page_func($atts){
		$accounts_id=0;
		$ArsGoogleAds=new ArsGoogleAds();
		$ArsGoogleAds->set_googleAdsClient();
		$ArsGoogleAds->set_managerCustomerId_loginCustomerId();	
		$accounts=$ArsGoogleAds->getCustomerListsQuery();		
		if(isset($_GET['accounts'])){
			if($_GET['accounts']){
				$accounts=ars_prj_clearly_user_view_accounts($_GET['accounts'],$accounts);
			}
		}
		$customer_id=$accounts[0]['id'];
		$campains=$ArsGoogleAds->showCampaingList($customer_id);
		$html='';
		$html.='<div class="page-content">';
		   $html.='<div class="container-fluid">';
			  $html.='<div class="row">';
				 $html.='<div class="col-lg-12">';
					$html.='<div class="ars-top-info" style="    display: inline-block;
    border: none;
    padding: 10px;
    background: #fff;
    box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03);
    margin-bottom: 20px;">';
						$html.='<strong>Account ID:</strong> '.$customer_id.'<br>';
						$html.='<strong>Account Name:</strong> '.$accounts[0]['descriptiveName'];
					$html.='</div>';
					$html.='<div class="card">';
					   $html.='<div class="card-body">';
						  $html.='<div class="ars-card-title-area">';
							$html.='<h4 class="card-title ars-card-title mb-4">'.__($accounts[0]['descriptiveName'].' Kampanyaları','arsoltranslate').'</h4>';
							$html.='<div class="ars-card-title-actions">';
								$html.='<img src="https://ads-panel.arsoldijital.com/tarih-aralik.png" style="    width: 180px;
    display: inline-block;
    float: right;
    margin-left: 9px;
    margin-top: -3px;">';
								$html.='<span class="badge badge-pill badge-soft-success font-size-15 align-right" style="float: right;"><strong>Bakiyeniz: </strong>₺850,00</span>';
								$html.='<button type="button" class="btn btn-light waves-effect ars-vis-hidden"><i class="bi bi-arrow-clockwise"></i> '.__('Güncelle','arsoltranslate').'</button>';
						    $html.='</div>';
						  $html.='</div>';
						  $html.='<div class="table-responsive">';
							 $html.='<table class="table align-middle table-nowrap mb-0">';
								$html.='<thead class="table-light">';
								   $html.='<tr>';
									  $html.='<th class="align-middle">'.__('Sıra','arsoltranslate').'</th>';
									  //$html.='<th class="align-middle">'.__('ID','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Kampanya Adı','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Gösterim','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Etkileşim','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Etkileşim Or.','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Ort. <br>Maaliyet','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Maliyet','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Geçersiz <br>Tıklamalar','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Tıklamalar','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Dönş Oran.','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Dönüşümler','arsoltranslate').'</th>';
									  $html.='<th class="align-middle">'.__('Maliyet/<br>Dönüşüm','arsoltranslate').'</th>';
									  //$html.='<th class="align-middle">'.__('Durum','arsoltranslate').'</th>';
									  //$html.='<th class="align-middle">'.__('Detay','arsoltranslate').'</th>';
								   $html.='</tr>';
								$html.='</thead>';
								$html.='<tbody>';
								   if($campains){
									   $counter=0;
									   foreach($campains as $key=>$value){
										   $counter++;
										   $html.='<tr>';
											  $html.='<td>'.$counter.'</td>';
											 // $html.='<td>'.$key.'</td>';
											  $html.='<td>'.$value.'</td>';
											  $html.='<td>0</td>';
											  $html.='<td>0</td>';
											  $html.='<td>-</td>';
											  $html.='<td>₺0,00</td>';
											  $html.='<td>₺0,00</td>';
											  $html.='<td>-</td>';
											  $html.='<td>0</td>';
											  $html.='<td>-</td>';
											  $html.='<td>-</td>';
											  $html.='<td>-</td>';
											  /*$html.='<td>';
												 $html.='<span class="'.$account['status_detail']['class'].' font-size-11">'.__($account['status_detail']['title'],'arsoltranslate').'</span>';
											  $html.='</td>';
											  $html.='<td>';										 
												 $html.='<a type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" href="#">';
													$html.='Kampanyalar';
												 $html.='</a>';
											  $html.='</td>';*/
										   $html.='</tr>';										   
									   }
								   }else{
									   $html.='<tr>';
										$html.='<td colspan="5" class="text-center">';
											$html.='<span class="badge badge-pill badge-soft-warning font-size-11">'.__('Kampanya Bulunamadı','arsoltranslate').'</span>';
										$html.='</td>';
									   $html.='</tr>';
								   }
								$html.='</tbody>';
							 $html.='</table>';
						  $html.='</div>';
					   $html.='</div>';
					$html.='</div>';
				 $html.='</div>';
			  $html.='</div>';
		   $html.='</div>';
		$html.='</div>';	
		return $html;		
	}