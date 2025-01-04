<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include 'google-ads-php/vendor/autoload.php';
	use GetOpt\GetOpt;
	use Google\Ads\GoogleAds\Examples\Utils\ArgumentNames;
	use Google\Ads\GoogleAds\Examples\Utils\ArgumentParser;
	use Google\Ads\GoogleAds\Lib\V17\GoogleAdsClient;
	use Google\Ads\GoogleAds\Lib\V17\GoogleAdsClientBuilder;	
	use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
	use Google\Ads\GoogleAds\V17\Resources\CustomerClient;
	use Google\Ads\GoogleAds\V17\Services\Client\CustomerServiceClient;	
	use Google\Ads\GoogleAds\V17\Services\SearchGoogleAdsStreamRequest;
	use Google\Ads\GoogleAds\V17\Services\ListAccessibleCustomersRequest;
	use Google\Ads\GoogleAds\Util\FieldMasks;
	use Google\Ads\GoogleAds\Util\V17\ResourceNames;
	use Google\Ads\GoogleAds\V17\Enums\ManagerLinkStatusEnum\ManagerLinkStatus;
	use Google\Ads\GoogleAds\V17\Errors\GoogleAdsError;
	use Google\Ads\GoogleAds\V17\Resources\CustomerClientLink;
	use Google\Ads\GoogleAds\V17\Resources\CustomerManagerLink;
	use Google\Ads\GoogleAds\V17\Services\CustomerClientLinkOperation;
	use Google\Ads\GoogleAds\V17\Services\CustomerManagerLinkOperation;
	use Google\Ads\GoogleAds\V17\Services\MutateCustomerClientLinkRequest;
	use Google\Ads\GoogleAds\V17\Services\MutateCustomerManagerLinkRequest;
	use Google\Ads\GoogleAds\V17\Services\SearchGoogleAdsRequest;
	use Google\ApiCore\ApiException;
	class ArsGoogleAds{
		public GoogleAdsClient $googleAdsClient;
		public $managerCustomerId;
		public $loginCustomerId;
		public static array $accountList=[]; 
		private static array $rootCustomerClients = [];
		function set_managerCustomerId_loginCustomerId(){
			$this->managerCustomerId=CUSTOMER_ID;
			$this->loginCustomerId=LOGIN_CUSTOMER_ID;				
		}
		function set_googleAdsClient(){
			$oAuth2Credential = (new OAuth2TokenBuilder())->fromFile('google_ads_php.ini')->build();
			$googleAdsClient = (new GoogleAdsClientBuilder())->fromFile('google_ads_php.ini')->withOAuth2Credential($oAuth2Credential)->build();		
			$googleAdsServiceClient = $googleAdsClient->getGoogleAdsServiceClient();
			$this->googleAdsClient=$googleAdsClient;
		}
		public function getCustomerList(){
			$customers=array();			
			$customerServiceClient = $this->googleAdsClient->getCustomerServiceClient();
			$accessibleCustomers =$customerServiceClient->listAccessibleCustomers(new ListAccessibleCustomersRequest());
			foreach ($accessibleCustomers->getResourceNames() as $resourceName) {
				$customers[]=$resourceName;
			}
			return $customers;
		}
		public function getCustomerListIDS(){
			$accessibleCustomerIds = [];
			$customerServiceClient = $this->googleAdsClient->getCustomerServiceClient();
			$accessibleCustomers =$customerServiceClient->listAccessibleCustomers(new ListAccessibleCustomersRequest());
			foreach ($accessibleCustomers->getResourceNames() as $customerResourceName) {
				$customer = CustomerServiceClient::parseName($customerResourceName)['customer_id'];
				$accessibleCustomerIds[] = intval($customer);
			}
			return $accessibleCustomerIds;
		}	
		function convertAccountsStateClass($state){
			$states=array(
				0=>array(
					'title'=>'UNSPECIFIED',
				),
				1=>array(
					'title'=>'UNKNOWN',
				),
				2=>array(
					'title'=>'SUSPENDED',
				),
				3=>array(
					'title'=>'ENABLED',
				),
				4=>array(
					'title'=>'CLOSED',
				),
				5=>array(
					'title'=>'CANCELED',
					'class'=>'badge badge-pill badge-soft-danger',
				),
			);
			$_return=$states;
			if(isset($states[$state])){
				$_return=$states[$state];
			}
			return $_return;
		}
		function getCustomerListsQuery(){
			$accessibleCustomerDatas = [];
			$googleAdsServiceClient = $this->googleAdsClient->getGoogleAdsServiceClient();
			$query = 'SELECT customer_client.id, customer_client.descriptive_name,customer_client.level,customer_client.client_customer,customer_client.status,customer_client.resource_name,customer_client.manager FROM customer_client WHERE customer_client.level=1';
			$stream = $googleAdsServiceClient->searchStream(
				SearchGoogleAdsStreamRequest::build($this->loginCustomerId, $query)
			);			
			foreach ($stream->iterateAllElements() as $googleAdsRow) {
				$_tmp=array();
				$_clients=$googleAdsRow->getcustomerClient();
				$_tmp['id']=$googleAdsRow->getcustomerClient()->getid();
				$_tmp['descriptiveName']=$googleAdsRow->getcustomerClient()->getdescriptiveName();
				$_tmp['status']=$googleAdsRow->getcustomerClient()->getStatus();
				$_tmp['status_detail']=self::convertAccountsStateClass($_tmp['status']);
				$accessibleCustomerDatas[]=$_tmp;
			}
			return $accessibleCustomerDatas;		
			
		}
		function showCampaingList(int $customerId){		
			$campaings=array();
			$googleAdsServiceClient = $this->googleAdsClient->getGoogleAdsServiceClient();
			$query = 'SELECT 
				campaign.id, 
				campaign.name, 
				campaign.end_date, 
				campaign.optimization_score, 
				campaign.payment_mode, 
				metrics.clicks, 
				metrics.impressions, 
				metrics.interactions,
				metrics.ctr,
			FROM keyword_view ORDER BY campaign.id';
			$query = 'SELECT 
				metrics.impressions, 
				metrics.ctr, 
				metrics.conversions, 
				campaign.end_date, 
				campaign.id, 
				campaign.name 
			FROM keyword_view';
			$query = 'SELECT campaign_budget.id, metrics.active_view_ctr, metrics.active_view_cpm, metrics.impressions, metrics.ctr, metrics.conversions, campaign.end_date, campaign.id, campaign.name, campaign_budget.period, campaign_budget.recommended_budget_amount_micros, campaign_budget.amount_micros, campaign_budget.total_amount_micros, campaign_budget.recommended_budget_estimated_change_weekly_cost_micros, metrics.lead_cost_of_goods_sold_micros, metrics.active_view_measurable_cost_micros FROM campaign';
			$stream = $googleAdsServiceClient->searchStream(
				SearchGoogleAdsStreamRequest::build($customerId, $query)
			);
			
			foreach ($stream->iterateAllElements() as $googleAdsRow) {
				if(isset($_GET['test'])){
				echo '<pre>';
				print_r($googleAdsRow);
			echo '</pre>';
				}
				$campaings[$googleAdsRow->getCampaign()->getId()]=$googleAdsRow->getCampaign()->getName();
			}
			return $campaings;
		}
		function showAccountList(){
			$rootCustomerIds = [];
			if (1) {
				$rootCustomerIds = self::getCustomerListIDS();
			} else {
				$rootCustomerIds[] = $this->managerCustomerId;
			}
			$allHierarchies = [];
			$accountsWithNoInfo = [];
			foreach ($rootCustomerIds as $rootCustomerId) {
				$customerClientToHierarchy =self::createCustomerClientToHierarchy($this->loginCustomerId, $rootCustomerId);
				if (is_null($customerClientToHierarchy)) {
					$accountsWithNoInfo[] = $rootCustomerId;
				} else {
					$allHierarchies += $customerClientToHierarchy;
				}
			}
			// Prints the IDs of any accounts that did not produce hierarchy information.
			if (!empty($accountsWithNoInfo)) {
				print
					'Unable to retrieve information for the following accounts which are likely '
					. 'either test accounts or accounts with setup issues. Please check the logs for '
					. 'details:' . PHP_EOL;
				foreach ($accountsWithNoInfo as $accountId) {
					print $accountId . PHP_EOL;
				}
				print PHP_EOL;
			}
            
			return $allHierarchies;
		}
		function createCustomerClientToHierarchy( int $loginCustomerId, int $rootCustomerId){
			$oAuth2Credential = (new OAuth2TokenBuilder())->fromFile()->build();
			$googleAdsClient = (new GoogleAdsClientBuilder())->fromFile()
				->withOAuth2Credential($oAuth2Credential)
				->withLoginCustomerId($loginCustomerId ?? $rootCustomerId)
				//->usingGapicV2Source(true)
				->build();

			$googleAdsServiceClient = $googleAdsClient->getGoogleAdsServiceClient();
			$query = 'SELECT customer_client.client_customer, customer_client.level,'
				. ' customer_client.manager, customer_client.descriptive_name,'
				. ' customer_client.currency_code, customer_client.time_zone,'
				. ' customer_client.id FROM customer_client WHERE customer_client.level <= 1';

			$rootCustomerClient = null;
			$managerCustomerIdsToSearch = [$rootCustomerId];
			$customerIdsToChildAccounts = [];
			while (!empty($managerCustomerIdsToSearch)) {
				$customerIdToSearch = array_shift($managerCustomerIdsToSearch);
				$stream = $googleAdsServiceClient->searchStream(SearchGoogleAdsStreamRequest::build(
					$customerIdToSearch,
					$query
				));
				foreach ($stream->iterateAllElements() as $googleAdsRow) {
					$customerClient = $googleAdsRow->getCustomerClient();
					if ($customerClient->getId() === $rootCustomerId) {
						$rootCustomerClient = $customerClient;
						self::$rootCustomerClients[$rootCustomerId] = $rootCustomerClient;
					}
					if ($customerClient->getId() === $customerIdToSearch) {
						continue;
					}
					$customerIdsToChildAccounts[$customerIdToSearch][] = $customerClient;
					if ($customerClient->getManager()) {
						$alreadyVisited = array_key_exists(
							$customerClient->getId(),
							$customerIdsToChildAccounts
						);
						if (!$alreadyVisited && $customerClient->getLevel() === 1) {
							array_push($managerCustomerIdsToSearch, $customerClient->getId());
						}
					}
				}
			}

			return is_null($rootCustomerClient) ? null: [$rootCustomerClient->getId() => $customerIdsToChildAccounts];
		}
		function printAccountHierarchy(CustomerClient $customerClient, array $customerIdsToChildAccounts,int $depth) {

		}		
		
	}