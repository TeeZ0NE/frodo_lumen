<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 5:23 PM
 */

namespace App\Http\Libs;

/**
 * Class StatusMessage
 * @package App\Http\Libs
 */
class StatusMessage
{
	protected const STATUS_OK = 'success';
	protected const STATUS_ERR = 'error';

	/**
	 * Message 4 user
	 *
	 * @param bool $status
	 * @param null $description
	 * @param string $data_title
	 * @param null $data
	 * @return \Illuminate\Support\Collection
	 */
	public static function statusMessage(bool $status, $description = null, $data_title = 'data',
	                                     $data = null)
	{
		$dataOfMessage = [
			'status' => ($status) ? self::STATUS_OK : self::STATUS_ERR,
		];
		if (!empty($description)) $dataOfMessage['description'] = $description;
		if (!empty($data)) $dataOfMessage[$data_title] = $data;

		return collect($dataOfMessage);
	}
}