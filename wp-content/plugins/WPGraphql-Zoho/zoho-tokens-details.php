
<?php 
/**
 * Plugin Name:       Zoho with WPGraphql
 * Description:       Zoho with wordpress and Graphql.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Wali ur Rehman
 * **/
$input=array();
add_action( 'graphql_register_types', function() {

	register_graphql_mutation( 'ZohoAddComapny', [
		'inputFields' => [
			'user_id' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'name' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'email' => [
						'type' => [ 'non_null' => 'String' ],
					],
			'phone' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'logo' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'zip' => [
				'type' => 'String',
			],
			'city' => [
				'type' => 'String',
			],
			'state' => [
				'type' => 'String',
			],
			'website_url' => [
				'type' => 'String',
			],
			'mailing_address' => [
				'type' => 'String',
			],
		],
		'outputFields' => [
				'status' => [
					'type' => 'String',
				],

			],
			'mutateAndGetPayload' => function( $input ) {
				insertCompany($input);
				return [
					'status' => 'Company Has Been Registered'
				];
			}
	]);
	register_graphql_mutation( 'ZohoUpdateComapny', [
		'inputFields' => [
			'id' => [
				'type' => [ 'non_null' => 'Integer' ],
			],
			'name' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'email' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'phone' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'logo' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'zip' => [
				'type' => 'String',
			],
			'city' => [
				'type' => 'String',
			],
			'state' => [
				'type' => 'String',
			],
			'website_url' => [
				'type' => 'String',
			],
			'mailing_address' => [
				'type' => 'String',
			],
		],
		'outputFields' => [
				'status' => [
					'type' => 'String',
				],

			],
			'mutateAndGetPayload' => function( $input ) {
				global $wpdb;
				$wpdb->update('wp_zoho_companies', $input, array( 'id' => $input['id'] ));
			
				return [
					'status' => 'Company Has Been Updated'
				];
			}
	]);
	register_graphql_mutation( 'addZohoCredentials', [
		'inputFields' => [
			'grant_token' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'refresh_token' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'access_token' => [
						'type' => [ 'non_null' => 'String' ],
					],
			'client_id' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'client_secret' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'scopes' => [
				'type' => [ 'non_null' => 'String' ],
			],
		],
		'outputFields' => [
			'status' => [
				'type' => 'Boolean',
			],
		],
		'mutateAndGetPayload' => function( $input ) {
      	insertZohoCredentialDetails($input);
    	// $zoho_response = CallAPIs('GET', "https://desk.zoho.com/api/v1/tickets?include=contacts,assignee,departments,team,isRead", false);
		// $obj = json_decode($zoho_response, true);
            return [
				'status' =>true
            ];
		}
	]);
	//done don't touch please
	register_graphql_mutation( 'ZohoCreateContact', [
		'inputFields' => [
			'user_id' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'email' => [
				'type' => 'String',
			  ],
			  'firstName' => [
				'type' => 'String',
			  ],
			  'lastName' => [
				'type' => 'String',
			  ],
			  'type' => [
				'type' => 'String',
			  ],
			  'facebook' => [
				'type' => 'String',
			  ],
			  'twitter' => [
				'type' => 'String',
			  ],
			  'secondaryEmail' => [
				'type' => 'String',
			  ],
			  'phone' => [
				'type' => 'String',
			  ],
			  'mobile' => [
				'type' => 'String',
			  ],
			  'city' => [
				'type' => 'String',
			  ],
			  'country' => [
				'type' => 'String',
			  ],
			  'state' => [
				'type' => 'String',
			  ],
			  'street' => [
				'type' => 'String',
			  ],
			  'zip' => [
				'type' => 'String',
			  ],
			  'description' => [
				'type' => 'String',
			  ],
			  'title' => [
				'type' => 'String',
			  ],
			  'photoURL' => [
				'type' => 'String',
			  ],
			  'webUrl' => [
				'type' => 'String',
			  ],
			  'zip' => [
				'type' => 'String',
			  ],
			  'isDeleted' => [
				'type' => 'boolean',
			  ],
			  'isTrashed' => [
				'type' => 'boolean',
			  ],
			  'isSpam' => [
				'type' => 'boolean',
			  ],
			  'createdTime' => [
				'type' => 'String',
			  ],
			  'modifiedTime' => [
				'type' => 'String',
			  ],
			  'accountId' => [
				'type' => 'String',
			  ],
			  'ownerId' => [
				'type' => 'String',
			  ],
		],
		'outputFields' => [
			'zohoContact' => [
				'type' => 'zohoContact',
			],
			'status' => [
				'type' =>'Integer'
			] ,
			'error' => [
				'type' => 'String'
			],
			'message' => [
				'type' => 'String'
			]
		],
		'mutateAndGetPayload' => function( $input ) {
			$user_id=$input['user_id'];
			unset($input['user_id']);
			$zoho_response = CallAPIs('POST', "https://desk.zoho.com/api/v1/contacts", $input);
			$contact_id=$zoho_response['body']->id;

			$input['user_id']=$user_id;
			$input['contactId']=$contact_id;
			insertZohoContacts($input);
		
			if($zoho_response['status']==200)
			{
				return [
					'error' => null,
					'message'=> 'Success',
					'zohoContact' =>$zoho_response['body'],
					'status' => $zoho_response['status'],
				];
			}
			else{
				return [
					'error' => $zoho_response['error'],
					'message'=> $zoho_response['message'],
					'zohoContact' =>null,
					'status' => $zoho_response['status']
				];
			}
		}
	]);
	register_graphql_mutation( 'ZohoUpdateContact', [
		'inputFields' => [
			'user_id' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'firstName' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'lastName' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'email' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'type' => [
				'type' => 'String',
			  ],
			  'facebook' => [
				'type' => 'String',
			  ],
			  'twitter' => [
				'type' => 'String',
			  ],
			  'secondaryEmail' => [
				'type' => 'String',
			  ],
			  'phone' => [
				'type' => 'String',
			  ],
			  'mobile' => [
				'type' => 'String',
			  ],
			  'city' => [
				'type' => 'String',
			  ],
			  'country' => [
				'type' => 'String',
			  ],
			  'state' => [
				'type' => 'String',
			  ],
			  'street' => [
				'type' => 'String',
			  ],
			  'zip' => [
				'type' => 'String',
			  ],
			  'description' => [
				'type' => 'String',
			  ],
			  'title' => [
				'type' => 'String',
			  ],
			  'photoURL' => [
				'type' => 'String',
			  ],
			  'webUrl' => [
				'type' => 'String',
			  ],
			  'zip' => [
				'type' => 'String',
			  ],
			  'isDeleted' => [
				'type' => 'boolean',
			  ],
			  'isTrashed' => [
				'type' => 'boolean',
			  ],
			  'isSpam' => [
				'type' => 'boolean',
			  ],
			  'createdTime' => [
				'type' => 'String',
			  ],
			  'modifiedTime' => [
				'type' => 'String',
			  ],
			  'accountId' => [
				'type' => 'String',
			  ],
			  'ownerId' => [
				'type' => 'String',
			  ],
		],
		'outputFields' => [
			'zohoContact' => [
				'type' => 'zohoContact',
			],
			'status' => [
				'type' =>'Integer'
			] ,
			'error' => [
				'type' => 'String'
			],
			'message' => [
				'type' => 'String'
			],
			'clientId'=>
			[
				'type'=>'String'
			]
		],
		'mutateAndGetPayload' => function( $input ) {
			global $wpdb;
			$user_id = base64_decode($input['user_id']); // the result is not a stringified number, neither printable
			$string=str_replace('user:', '',$user_id  );
			$user_id= json_decode($string);
			$input['user_id']=$user_id;
			unset($input['user_id']);	
			$result = $wpdb->get_results('SELECT contactId FROM wp_zoho_contacts WHERE user_id='.$user_id.'');
			$contact_id=$result[0]->contactId;
			$zoho_response = CallAPIs('PATCH', "https://desk.zoho.com/api/v1/contacts/".$contact_id, $input);
			$input['user_id']=$user_id;
			$input['contactId']=$contact_id;

			if($zoho_response['status']==200)
			{	
				$wpdb->update('wp_zoho_contacts', $input, array( 'user_id' => $user_id ));
				return [
					'error' => null,
					'message'=> 'Success',
					'zohoContact' =>$zoho_response['body'],
					'status' => $zoho_response['status'],
				];
			}
			else{
				return [
					'error' => $zoho_response['error'],
					'message'=> $zoho_response['message'],
					'zohoContact' =>null,
					'status' => $zoho_response['status']
				];
			}
		}
	]);
	//done don't touch please
	register_graphql_mutation( 'ZohoCreateticket', [
		'inputFields' => [
			'subject' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'description' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'priority' => [
				'type' => [ 'non_null' => 'String' ],
			], 
			'user_id' => [
				'type' => ['non_null' => 'String']
			],
			'departmentId' => [
				'type'=> ['non_null' => 'String']
			],
			'company_id'=>[
				'type' => ['non_null' => 'Integer']
			],
		],
		'outputFields' => [
			'zohoTicket' => [
				'type' => 'zohoTicket',
			],
			'status' => [
				'type' =>'Integer'
			] ,
			'error' => [
				'type' => 'String'
			],
			'message' => [
				'type' => 'String'
			],
			'contactId' =>[
				'type'=>'String'
			]
		],
		'mutateAndGetPayload' => function( $input ) {
			global $wpdb;
			$user_id = base64_decode($input['user_id']); // the result is not a stringified number, neither printable
			$string=str_replace('user:', '',$user_id  );
			$user_id= json_decode($string);
			$input['user_id']=$user_id;

			$result = $wpdb->get_results('SELECT contactId FROM wp_zoho_contacts WHERE user_id='.$user_id.'');
			$input['contactId']=$result[0]->contactId;
			$company_id=$input['company_id'];
			$user_id=$input['user_id'];
			unset($input['company_id']);
			unset($input['user_id']);
			// return ['zohoTicket' =>$input];
			$zoho_response = CallAPIs('POST', "https://desk.zoho.com/api/v1/tickets", $input);
			
			if($zoho_response['status']==200)
			{
				$ticket_id=$zoho_response['body']->id;
				insertZohoTickets($input,$user_id, $company_id,$ticket_id);
				return [
					'error' => null,
					'message'=> 'Success',
					'zohoTicket' =>$zoho_response['body'],
					'status' => $zoho_response['status'],
					'contactId' => $result[0]->contactId
				];
			}
			else{
				return [
					'error' => $zoho_response['error'],
					'message'=> $zoho_response['message'],
					'zohoTicket' =>null,
					'status' => $zoho_response['status'],
					'contactId' => 	$client_id
				];
			}
		}
	]);
	//zoho update ticket
	register_graphql_mutation( 'ZohoUpdateticket', [
		'inputFields' => [
			'id' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'subject' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'description' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'priority' => [
				'type' => [ 'non_null' => 'String' ],
			], 
			'departmentId' => [
				'type'=> ['non_null' => 'String']
			],
		],
		'outputFields' => [
			'zohoTicket' => [
				'type' => 'zohoTicket',
			],
			'status' => [
				'type' =>'Integer'
			] ,
			'error' => [
				'type' => 'String'
			],
			'message' => [
				'type' => 'String'
			],
			'contactId' =>[
				'type'=>'String'
			]
		],
		'mutateAndGetPayload' => function( $input ) {

			// return ['zohoTicket' =>$input];
			$zoho_response = CallAPIs('PATCH', "https://desk.zoho.com/api/v1/tickets/".$input['id'], $input );
			$ticket_id=$input['id'];
			if($zoho_response['status']==200)
			{
				updateZohoTickets($input,$ticket_id);
				return [
					'error' => null,
					'message'=> 'Success',
					'zohoTicket' =>$zoho_response['body'],
					'status' => $zoho_response['status'],
					'contactId' => $result[0]->contactId
				];
			}
			else{
				return [
					'error' => $zoho_response['error'],
					'message'=> $zoho_response['message'],
					'zohoTicket' =>null,
					'status' => $zoho_response['status'],
					'contactId' => 	$client_id
				];
			}
		}
	]);


	register_graphql_mutation( 'ZohoCreateUser', [
		'inputFields' => [
			'name' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'password' => [
				'type' => [ 'non_null' => 'String' ],
			],
			'email' => [
				'type' => [ 'non_null' => 'String' ],
			], 
			'created_by'=>[
				'type'=> ['non_null' => 'String']
			],
			'user_role'=>[
				'type'=> ['non_null' => 'String']
			],
		],
		'outputFields' => [
			'zohoUser' => [
				'type' =>'zohoUser'
			],
			'status'=>[
				'type'=>'String'
			],
		],
		'mutateAndGetPayload' => function( $input ) {
			$created_by = base64_decode($input['created_by']); // the result is not a stringified number, neither printable
			$string=str_replace('user:', '',$created_by  );
			$created_by= json_decode($string);
			$input['created_by']=$created_by;

			global $wpdb;
			if(email_exists( $input['email'] ))
			{
				return ['status' => 'Email already Exists'];
			}else {
				$registered=wp_create_user($input['name'],$input['password'],$input['email']);
				if($registered){
					$wpdb->update('wp_users', array('created_by'=>$created_by, 'role'=>$input['user_role']), array( 'id' => $registered ));
					return ['zohoUser' => $input];
				}else {
					return ['status' => 'Something is Wrong'];
				}
			}	
		}
	]);
    register_graphql_mutation( 'ZohoUpdateUser', [
		'inputFields' => [
			'id'=>[
				'type'=>['non_null'=> 'String']
			],
			'user_role'=>[
				'type'=> ['non_null' => 'String']
			],
		],
		'outputFields' => [
			'userId' => [
				'type' =>'String'
			],
            'status' => [
				'type' =>'String'
			] 
		],
		'mutateAndGetPayload' => function( $input ) {
			$id = base64_decode($input['id']); // the result is not a stringified number, neither printable
			$string=str_replace('user:', '',$id  );
			$id= json_decode($string);
			$input['id']=base64_encode($id);
         
			global $wpdb;
			$updated=$wpdb->update('wp_users', array('role'=>$input['user_role']), array( 'id' => $id ));
            if($updated){
				return [
                	'userId' =>$input['id'],
                	'status'=>'User Role Updated'
                ];
			}else {
				return [
                	'userId' => 'User Not Found',
                	'status'=>'Not Updated'	
                ];
			}					
		}
	]);

	//ok

	register_graphql_mutation( 'ZohoCreateTicketComment', [
		'inputFields' => [
			'id'=>[
				'type'=>['non_null'=> "String"]
			],
			'content'=>[
				'type'=> ['non_null' => 'String']
			],
			'isPublic'=>[
				'type'=> ['non_null' => 'Boolean']
			],
			'attachmentIds'=>[
				'type'=>  'String'
			],
			'contentType'=>[
				'type'=> ['non_null' => 'String']
			],
		],
		'outputFields' => [
			'status' => [
				'type' =>'Integer'
			] ,
			'error' => [
				'type' => 'String'
			],
			'message' => [
				'type' => 'String'
			],
			'getZohoTicketComment'=>['type'=>'zohoTicketComment'],
			'inserted' =>['type' => 'Boolean'],
			'size' =>['type' => 'string']
		],
		'mutateAndGetPayload' => function( $input ) {

            $zoho_response = CallAPIs('POST', "https://desk.zoho.com/api/v1/tickets/".$input['id']."/comments", $input);
		
			// $data['size']=$zoho_response['body']->attachments[0]->size;
			// $data['href']=$zoho_response['body']->attachments[0]->href;
			// $data['imgName']=$zoho_response['body']->attachments[0]->name;
			// $data['imgid']=$zoho_response['body']->attachments[0]->id;
			// return ['size'=>$data['imgid']];
			if($zoho_response['status']==200)
			{
				$data=array();
				$data['id']=$zoho_response['body']->id;
				$data['isPublic']=$zoho_response['body']->isPublic;
				$data['commentedTime']=$zoho_response['body']->commentedTime;
				$data['contentType']=$zoho_response['body']->contentType;
				$data['content']=$zoho_response['body']->content;
				$data['commenterId']=$zoho_response['body']->commenterId;
				$data['commentorName']=$zoho_response['body']->commenter->name;
				$data['photoURL']=$zoho_response['body']->commenter->name;
				$data['roleName']=$zoho_response['body']->commenter->roleName;
				$data['type']=$zoho_response['body']->commenter->type;
				$data['email']=$zoho_response['body']->commenter->email;
				global $wpdb;
				$inserted=$wpdb->insert('wp_zoho_tickets_comments', $data);
				return [
					'error' => null,
					'message'=> 'Success',
					'status' => $zoho_response['status'],
					'getZohoTicketComment'=>$zoho_response['body'],
					'inserted' => $inserted
				];
			}
			else{
				return [
					'error' => $zoho_response['error'],
					'message'=> $zoho_response['message'],
					'status' => $zoho_response['status'],
					'ZohoTicketCommet' => Null,
				];
			}		
		}
	]);

} );


function insertCompany($input)
{
	
  	global $wpdb;
	$user_id = base64_decode($input['user_id']); // the result is not a stringified number, neither printable
	$string=str_replace('user:', '',$user_id  );
	$user_id= json_decode($string);
	$input['user_id']=$user_id;
	$wpdb->insert('wp_zoho_companies', $input);
	return $input;
}

function insertZohoCredentialDetails($input)
{	
  	global $wpdb;
  	$zoho=array();
	$zoho['grant_token']= $input['grant_token'];
	$zoho['refresh_token'] =$input['refresh_token'];
	$zoho['access_token'] =$input['access_token'];
    $zoho['client_secret'] =$input['client_secret'] ;
	$zoho['client_id'] =$input['client_id'] ;
    $zoho['scopes'] =$input['scopes'] ;

	$results = $wpdb->get_results( 'SELECT * FROM wp_zoho_credentials');
	if ($results)
	{
		foreach($results as $result)
		{
			$wpdb->update( 'wp_zoho_credentials',$zoho, array( 'id' => $result->id ) );
			break;
		}
	}else{
		$wpdb->insert('wp_zoho_credentials', $zoho);
	}
	return $zoho;
}
function updateZohoContacts($input)
{
  	global $wpdb;
	$wpdb->update('wp_zoho_contacts', $input, array( 'user_id' => $user_id ));
	return $input;
}


function insertZohoContacts($input)
{
  	global $wpdb;
	$user_id = base64_decode($input['user_id']); // the result is not a stringified number, neither printable
	$string=str_replace('user:', '',$user_id  );
	$user_id= json_decode($string);
	$input['user_id']=$user_id;
	$results=$wpdb->get_results('SELECT user_id FROM wp_zoho_contacts');

	if($results)
	{
		foreach ($results as $result)
		{
			if($result->user_id==$user_id)
			{
				$update=true;
				break;
			}
		}
		if($update)
		{
			$wpdb->update('wp_zoho_contacts', $input, array( 'user_id' => $user_id ));
			return $input;
		}else{
			$wpdb->insert('wp_zoho_contacts', $input);
			return $input;
		}
	}

	$wpdb->insert('wp_zoho_contacts', $input);
	return $input;


  	$zoho=array();
    $zoho['user_id']= $user_id;
	$zoho['firstName']= $input->firstName;
	$zoho['lastName'] =$input->lastName;
	$zoho['email'] =$input->email;
    $zoho['contactId'] =$input->id;
	$zoho['zip'] =$input->zip;
	$zoho['country'] =$input->country;
	$zoho['secondaryEmail'] =$input->secondaryEmail;
	$zoho['city'] =$input->city;
	$zoho['facebook'] =$input->facebook;
	$zoho['mobile'] =$input->mobile;
	$zoho['ownerId'] =$input->ownerId;
	$zoho['type'] =$input->type;
	$zoho['title'] =$input->title;
	$zoho['accountId'] =$input->accountId;
	$zoho['twitter'] =$input->twitter;
	$zoho['phone'] =$input->phone;
	$zoho['street'] =$input->street;
	$zoho['state'] =$input->state;
	$results=$wpdb->get_results('SELECT user_id FROM wp_zoho_contacts');
	$update=false;
	if($results)
	{
		foreach ($results as $result)
		{
			if($result->user_id==$user_id)
			{
				$update=true;
				break;
			}
		}
		if($update)
		{
			$wpdb->update('wp_zoho_contacts', $zoho, array( 'user_id' => $user_id ));
		}else{
			$wpdb->insert('wp_zoho_contacts', $zoho);
		}
	}else{
		$wpdb->insert('wp_zoho_contacts', $zoho);
	}

	return $zoho;
}

function insertZohoTickets($input,$user_id,$company_id,$ticket_id)
{
  	global $wpdb;
	$input['user_id']=$user_id;
	$input['company_id']=$company_id;
	$input['id']=$ticket_id;
	$wpdb->insert('wp_zoho_tickets', $input);
	return $input;
}
function updateZohoTickets($input, $ticketId)
{
  	global $wpdb;
	$wpdb->update('wp_zoho_tickets', $input, array( 'id' =>$ticketId ));
	return $input;
}

function CallAPIs($method, $url, $data = false)
{	
	$curl = curl_init();
	$postdata = json_encode($data);
	$access_token='';
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_zoho_credentials');
	if ($results)
	{
		foreach($results as $result)
		{
			$access_token = $result->access_token;
			break;
		}
	}
	$headers = [
		'orgId: 659082188',
		'Authorization:Zoho-oauthtoken '.$access_token.'',
		'Content-Type: application/json',
		// 'Content-Type:multipart/form-data'
	];

	switch ($method)
	{
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			if ($postdata)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
			break;
		case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			break;
		case "PATCH":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			if ($postdata)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
			break;
		case "GET":
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			break;
		default:

	}


	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers

	$result = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$header = substr($result, 0, $header_size);
	$body = substr($result, $header_size);

	curl_close($curl);
   
   
	if($httpcode==200)
	{
		$response['status']=$httpcode;
		$response['body']=json_decode($body);
		return $response;
	}else{
		$response['status']=$httpcode;
		$response['error']=json_decode($body)->errorCode;
		$response['message']=json_decode($body)->message;
		return $response;
	}
}
add_action( 'graphql_register_types', 'register_mutations_and_query_models' );

function register_mutations_and_query_models() {

	register_graphql_object_type('tickets', [
		'fields'=>[
			'type'=>['list_of'=>'ticket']
		]
	]);
	register_graphql_object_type( 'zohoContact', [
		'description' => __( 'Describe what a CustomType is', 'your-textdomain' ),
		'fields' => [
		  'id' => [
			'type' => 'String',
		  ],
		  'email' => [
			'type' => 'String',
		  ],
		  'firstName' => [
			'type' => 'String',
		  ],
		  'lastName' => [
			'type' => 'String',
		  ],
		  'type' => [
			'type' => 'String',
		  ],
		  'facebook' => [
			'type' => 'String',
		  ],
		  'twitter' => [
			'type' => 'String',
		  ],
		  'secondaryEmail' => [
			'type' => 'String',
		  ],
		  'phone' => [
			'type' => 'String',
		  ],
		  'mobile' => [
			'type' => 'String',
		  ],
		  'city' => [
			'type' => 'String',
		  ],
		  'country' => [
			'type' => 'String',
		  ],
		  'state' => [
			'type' => 'String',
		  ],
		  'street' => [
			'type' => 'String',
		  ],
		  'zip' => [
			'type' => 'String',
		  ],
		  'description' => [
			'type' => 'String',
		  ],
		  'title' => [
			'type' => 'String',
		  ],
		  'photoURL' => [
			'type' => 'String',
		  ],
		  'webUrl' => [
			'type' => 'String',
		  ],
		  'isDeleted' => [
			'type' => 'boolean',
		  ],
		  'isTrashed' => [
			'type' => 'boolean',
		  ],
		  'isSpam' => [
			'type' => 'boolean',
		  ],
		  'createdTime' => [
			'type' => 'String',
		  ],
		  'modifiedTime' => [
			'type' => 'String',
		  ],
		  'accountId' => [
			'type' => 'String',
		  ],
		  'ownerId' => [
			'type' => 'String',
		  ],
		  'user_id' => [
			'type' => 'String',
		  ],
		  'company_id' => [
			'type' => 'Integer',
		  ],
		],
	] );

	register_graphql_object_type( 'zohoTicket', [
		'description' => __( 'Describe what a CustomType is', 'your-textdomain' ),
		'fields' => [
		  'id' => [
			'type' => 'String',
		  ],
		  'subject' => [
			'type' => 'String',
		  ],
		  'description' => [
			'type' => 'String',
		  ],
		  'priority' => [
			'type' => 'String',
		  ],
		  'departmentId' => [
			'type' => 'String',
		  ],
		  'contactId' => [
			'type' => 'String',
		  ],
		  'departmentIds' => [
			'type' => 'String',
		  ],
		  'viewId' => [
			'type' => 'String',
		  ],
		  'assignee' => [
			'type' => 'String',
		  ],
		  'channel' => [
			'type' => 'String',
		  ],
		  'status' => [
			'type' => 'String',
		  ],
		  'sortBy' => [
			'type' => 'String',
		  ],
		  'receivedInDays' => [
			'type' => 'String',
		  ],
		  'include' => [
			'type' => 'String',
		  ],
		  'fields' => [
			'type' => 'String',
		  ],		  
		],
	] );
	register_graphql_object_type( 'zohoCompany', [
		'fields' => [
			'id' => [
			'type' => 'Integer',
				],
		  	'user_id' => [
				'type' => 'Integer',
		  	],
		  	'contact_id' => [
				'type' => 'Integer',
		  	],
			'name' => [
				'type' => 'String',
			],
			'email' => [
				'type' => 'String',
			],
			'logo' => [
				'type' => 'String',
			],
			'zip' => [
				'type' => 'String',
			],
			'city' => [
				'type' => 'String',
			],
			'state' => [
				'type' => 'String',
			],
			'phone' => [
				'type' => 'String',
			],
			'website_url' => [
				'type' => 'String',
			],
			'mailing_address' => [
				'type' => 'String',
			],
		],
	] );
	register_graphql_object_type( 'zohoTicketbyUserId', [
		'description' => __( 'Describe what a CustomType is', 'your-textdomain' ),
		'fields' => [
		  'departmentIds' => [
			'type' => 'String',
		  ],
		  'viewId' => [
			'type' => 'String',
		  ],
		  'assignee' => [
			'type' => 'String',
		  ],
		  'channel' => [
			'type' => 'String',
		  ],
		  'status' => [
			'type' => 'String',
		  ],
		  'sortBy' => [
			'type' => 'String',
		  ],
		  'receivedInDays' => [
			'type' => 'String',
		  ],
		  'include' => [
			'type' => 'String',
		  ],
		  'fields' => [
			'type' => 'String',
		  ],
		  'user_id' => [
			'type' => 'Integer',
		  ],
		  'name' => [
			'type' => 'String',
		  ],
		  'email' => [
			'type' => 'String',
		  ],
		  'logo' => [
			'type' => 'String',
		  ],
		  'phone' => [
			'type' => 'String',
		  ],
		  'id' => [
			'type' => 'Integer',
		  ],	
		  'tickets' => [
			'type' => ['list_of' =>'zohoTicket'],
		  ],  
		],
	] );
	register_graphql_object_type( 'zohoUser', [
		'fields' => [
        	'id' => [
				'type' => 'String',
		  	],
		  	'created_by' => [
				'type' => 'String',
		  	],
		  	'name' => [
				'type' => 'String',
		  	],
			'email' => [
				'type' => 'String',
			],
			'user_role' => [
				'type' => 'String',
			],
		],
	] );
	register_graphql_object_type( 'zohoTicketComment', [
		'fields' => [
        	'id' => ['type' => 'String'],
		  	'isPublic' => ['type' => 'String'],
		  	'commentedTime' => ['type' => 'String'],
			'contentType' => ['type' => 'String'],
			'content' => ['type' => 'String'],
			'commenterId' => ['type' => 'String'],
			'commenter' => ['type' => 'commenter'],
		],
	] );
	register_graphql_object_type( 'attachments', [
		'fields' => [
			'size'=>['type'=>'string'],
			'href'=>['type'=>'string'],
			'name'=>['type'=>'string'],
			'id'=>['type'=>'String']
		],
	] );
	register_graphql_object_type( 'commenter', [
		'fields' => [
			'firstName'=>['type'=>'string'],
			'lastName'=>['type'=>'string'],
			'photoURL'=>['type'=>'string'],
			'name'=>['type'=>'String'],
			'roleName'=>['type'=>'string'],
			'type'=>['type'=>'string'],
			'email'=>['type'=>'String']
		],
	] );
};

//zoho contacts and zoho tickets

function RefreshToken()
{	
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_zoho_credentials');
	if ($results)
	{
		foreach($results as $result)
		{
			// $wpdb->update( 'wp_zoho_credentials',array('access_token'=>'23455'), array( 'id' => $result->id ) );
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_POST, 1);
			$redirect_url='http://localhost:8000';
			// $url='https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.0964963bc54f8e8055150db7d1abda73.d33f36aedda0a0f05eae8098af3e4dc1&grant_type=refresh_token&client_id=1000.HNT5KUX4GBCXFIKXXTL88O8NEPRFRD&client_secret=67951b0d42f4a14b96ade319998392a0be60321d52&redirect_uri=http://localhost:8000&scope=Desk.tickets.ALL,Desk.contacts.ALL';

			$url='https://accounts.zoho.com/oauth/v2/token?refresh_token='.$result->refresh_token.'&grant_type=refresh_token&client_id='.$result->client_id.'&client_secret='.$result->client_secret.'&redirect_uri='.$redirect_url.'&scope='.'Desk.contacts.WRITE,Desk.contacts.READ,Desk.tickets.ALL,Desk.settings.READ,Desk.basic.READ,Desk.tickets.UPDATE,Desk.events.ALL,Desk.basic.READ,Desk.basic.CREATE'.'';
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
			$theResult = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$header = substr($theResult, 0, $header_size);
			$body = substr($theResult, $header_size);
			
			curl_close($curl);
			if($httpcode==200)
			{
				$wpdb->update( 'wp_zoho_credentials',array('access_token'=>json_decode($body)->access_token), array( 'id' => $result->id ) );
				//json_decode($body)->access_token
			}
			break;
		}
	}
}
add_action( 'wp_curl_jobs', 'RefreshToken' );

//getZohoContactByUserId
add_action( 'graphql_register_types', function() {
register_graphql_field( 
	'RootQuery', 
		'getZohoContactByUserId', [
			'type'=>[ 'list_of' => 'zohoContact' ],
			'args' => [
				'userId' => [
					'type' => ['non_null'=>'String'],
				],
			],
			'resolve' => function($root, $args, $context, $info ) {
				global $wpdb;
				$user_id = base64_decode($args['userId']); // the result is not a stringified number, neither printable
				$string=str_replace('user:', '',$user_id  );
				$user_id= json_decode($string);
				$contact=$wpdb->get_results('SELECT * FROM wp_zoho_contacts WHERE user_id='.$user_id.'');
				return $contact;
			},	
		],
	);
});
//getZohoContacts
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
			'getZohoContacts', [
				'type'=>[ 'list_of' => 'zohoContact' ],
				'resolve' => function($root, $args, $context, $info ) {
					global $wpdb;
					$contact=$wpdb->get_results('SELECT * FROM wp_zoho_contacts');
					return $contact;
				//	$contacts=CallAPIs('GET', "https://desk.zoho.com/api/v1/contacts?from=1&limit=10");
				//	return $contacts['body']->data;
				},
			],
		);
});
//getCompanies
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
			'getCompanies', [
				'type'=>[ 'list_of' => 'zohoCompany' ],

				'resolve' => function($source, $args, $context, $info ) {
					global $wpdb;
					$results=$wpdb->get_results('SELECT * FROM wp_zoho_companies');
					return $results;
				},
			],
		);
});
//getTicketsByCompanyId
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
			'getTicketsByCompanyId', [
				'type'=>[ 'list_of' => 'zohoTicket' ],
				'args' => [
					'comapnyId' => [
						'type' => ['non_null'=>'Integer'],
					],
				],
				'resolve' => function($root, $args, $context, $info ) {
					global $wpdb;
					$company_id=$args['comapnyId'];
					$tickets=$wpdb->get_results('SELECT * FROM wp_zoho_tickets WHERE company_id='.$company_id.'');
					return $tickets;
				},	
			],
		);
});
//getZohoCompaniesTicketsByUserId
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery',
			'getZohoCompaniesTicketsByUserId', [
				'type'=>[ 'list_of' => 'zohoTicketbyUserId' ],
				'args' => [
					'userId' => [
					  'type' => ['non_null'=>'String'],
					],
				],
				'resolve' => function($source, $args, $context, $info ) {
					global $wpdb;
					$user_id = base64_decode($args['userId']); // the result is not a stringified number, neither printable
					$string=str_replace('user:', '',$user_id  );
					$user_id= json_decode($string);
					$arryObj=array();
					$companies=$wpdb->get_results('SELECT * FROM wp_zoho_companies WHERE user_id='.$user_id.'');
		
					foreach ($companies as $company)
					{
						$ComapnyTickets=$wpdb->get_results('SELECT * FROM `wp_zoho_tickets` WHERE company_id='.$company->id.' LIMIT 3');
						$company->tickets=array();
						if($ComapnyTickets)
						{
							$company->tickets=$ComapnyTickets;
						}else{
							$company->tickets=NULL;
						}
					}
					return $companies;
				},
			],
		);
});

//getUsersByUserID
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
		'getZohoUsersByUserId', [
			'type'=>[ 'list_of' => 'zohoUser'],
			'args' => [
				'userId' => [
					'type' => ['non_null'=>'String'],
				],
			],
			'resolve' => function($root, $args, $context, $info ) {
				global $wpdb;
				$user_id = base64_decode($args['userId']); // the result is not a stringified number, neither printable
				$string=str_replace('user:', '',$user_id  );
				$user_id= json_decode($string);
				$users=$wpdb->get_results('SELECT * FROM wp_users WHERE created_by='.$user_id.'');
				foreach($users as $user){
					$user->id=base64_encode($user->ID);
					$user->create_by=base64_encode($user->create_by);
					$user->name=$user->user_nicename;
					$user->email=$user->user_email;
				}
				return $users;
			},	
		],
	);
});

//getAdminsAndEditors
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
		'getAdminsAndEditors', [
			'type'=>[ 'list_of' => 'zohoUser'],
			'resolve' => function($root, $args, $context, $info ) {
				global $wpdb;
				$users=$wpdb->get_results('SELECT * FROM wp_users WHERE role="editor" OR role="admin" ');
				foreach($users as $user){
					$user->id=base64_encode('user:'.$user->ID);
					$user->created_by=base64_encode('user:'.$user->created_by);
					$user->name=$user->user_nicename;
					$user->email=$user->user_email;
                    $user->user_role=$user->role;
				}
				return $users;
			},	
		],
	);
});


//getAdminsAndEditorsByUserId
add_action( 'graphql_register_types', function() {
	register_graphql_field( 
		'RootQuery', 
		'getAdminsAndEditorsByUserId', [
			'type'=>[ 'list_of' => 'zohoUser'],
			'args' => [
				'createdBy' => [
					'type' => ['non_null'=>'String'],
				],
			],
			'resolve' => function($root, $args, $context, $info ) {
				global $wpdb;
				$created_by = base64_decode($args['createdBy']); // the result is not a stringified number, neither printable
				$string=str_replace('user:', '',$created_by  );
				$created_by= json_decode($string);
				$users=$wpdb->get_results('SELECT * FROM wp_users WHERE (role="editor" OR role="admin") AND created_by='.$created_by.' ');
				foreach($users as $user){
					$user->id=base64_encode('user:'.$user->ID);
					$user->created_by=base64_encode('user:'.$user->created_by);
					$user->name=$user->user_nicename;
					$user->email=$user->user_email;
                    $user->user_role=$user->role;
				}
				return $users;
			},	
		],
	);
});

// To Upload Image
add_action( 'rest_api_init', 'upload_zoho_image' );
function upload_zoho_image(){
  register_rest_route('/api/v1/','uploads',array(
    'methods'=>'POST','callback'=>'attachments'
  ));
}
function attachments( $request )
{
	// $data=$request->get_file_params();
	$name=$_FILES['file']['name'];
	$tempPath=$_FILES['file']['tmp_name'];
	// $type=$_FILES['image']['type'];
	// $fileExt = strtolower(pathinfo($name,PATHINFO_EXTENSION)); // get image extension
	move_uploaded_file($tempPath,$name); // move file from system temporary path to our upload folder path 
	$image="https://22f7-2400-adc5-1c7-6a00-4922-8be3-c256-cdc0.ngrok.io//gatsby/" .$name;

	$zoho_response = CallAPIsforImages('POST', "https://desk.zoho.com/api/v1/uploads",$image );
	// curl_setopt($ch,CURLOPT_URL, $url);
 	return [
		'error' => $zoho_response['error'],
 		'message'=> $zoho_response['message'],
 		'status' => $zoho_response['status'],
		'data' =>  $zoho_response['body'],
		'file'=> $image
	];
    // $params = $request->get_body();

    return new WP_REST_Response( $params, 200 );
}


function CallAPIsforImages($method, $url, $image = false)
{	
	$data=file_get_contents($image);
	$curl = curl_init();
	$access_token='';
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_zoho_credentials');
	if ($results)
	{
		foreach($results as $result)
		{
			$access_token = $result->access_token;
			break;
		}
	}
	$headers = [
		'orgId: 659082188',
		'Authorization:Zoho-oauthtoken '.$access_token.'',
		'Content-Type:multipart/form-data'
	];

	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	// curl_setopt($ch, CURLOPT_HEADER, 0);
    // curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers

	$result = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$header = substr($result, 0, $header_size);
	$body = substr($result, $header_size);
	 curl_close($curl);
   
   
	if($httpcode==200)
	{
		$response['status']=$httpcode;
		$response['body']=json_decode($body);
		return $response;
	}else{
		$response['status']=$httpcode;
		$response['error']=json_decode($body)->errorCode;
		$response['message']=json_decode($body)->message;
		return $response;
	}
}

