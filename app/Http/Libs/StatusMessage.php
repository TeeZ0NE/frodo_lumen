<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 5:23 PM
 */

namespace App\Http\Libs;


class StatusMessage
{
	protected const STATUS_OK = 'success';
	protected const STATUS_ERR = 'error';

	public static function statusMessage(bool $status, $description = null)
	{
		$dataOfMessage = [
			'status' => ($status) ? self::STATUS_OK : self::STATUS_ERR,
		];
		if (!empty($description)) $dataOfMessage['description'] = $description;

		return collect($dataOfMessage);
	}
}