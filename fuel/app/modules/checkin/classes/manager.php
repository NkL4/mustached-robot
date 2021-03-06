<?php

namespace Checkin;

class Manager
{

	public function get_public_checkins($order = 'desc')
	{
		return \DB::select()->from('checkins')->where('count', '=', 1)->where('public', '=', '1')->order_by('created_at', $order)->execute()->as_array();
	}

	public function get_checkin($id)
	{
		return \DB::select()->from('checkins')->where('id', '=', $id)->execute()->as_array();
	}

	/**
	 * Return a list of a user's checkins
	 * 
	 * @param int $user_id 		Id of the user
	 * @param string $order  	Order of the result (asc or desc). (optional, default = 'asc')
	 * @return Array 			Array of checkins associative array
	 */
	public function get_user_checkins($user_id, $order = 'asc')
	{
		return \DB::select('checkins.*')->from('checkins')->where('checkins.user_id', '=', $user_id)->join('users', 'right')->on('users.id', '=', 'checkins.user_id')->order_by('checkins.created_at', $order)->execute()->as_array();
	}


	/**
	 * Return the checkins in a given timeframe
	 * @param  String $start  Start date (format yyyy-mm-dd)
	 * @param  String $end    End date (format yyyy-mm-dd)
	 * @return Array  		  Associative array of checkins
	 */
	public function get_checkins($start, $end)
	{
		return \DB::select()->from('checkins')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->execute()->as_array();
	}

	/**
	 * Return the checkins in a given timeframe and their associated user
	 * @param  $start String Start date (format yyyy-mm-dd)
	 * @param  $end   String End date (format yyyy-mm-dd)
	 * @return        
	 */
	public function get_checkins_and_users($start, $end)
	{
		return Model_Checkin::find('all', array(
				'related'  => array('user'),							
				'order_by' => array('created_at' => 'desc'),
				'where'    => array(
					array('created_at', '>=', $start),
					array('created_at', '<=', $end)
				),
		));
	}

	/**
	 * Return a list of the users who have the most checkins in a given timeframe
	 * @param  $start String Start date (format yyyy-mm-dd)
	 * @param  $end   String End date (format yyyy-mm-dd)
	 * @return        Array  Associative array of users         
	 */
	public function get_leaders($start, $end)
	{
		
		$leaders = \DB::select('users.email', 'users.firstname', 'users.lastname', array(\DB::expr('count(users.id)'), 'checkin_number'))
							->from('users')
							->join('checkins')
							->on('users.id', '=', 'checkins.user_id')
							->where('checkins.created_at', '>=', $start)
							->where('checkins.created_at', '<=', $end)
							->group_by('users.email')
							->order_by('checkin_number', 'desc')
							->execute()->as_array();

		
		return $leaders;

	}



}
