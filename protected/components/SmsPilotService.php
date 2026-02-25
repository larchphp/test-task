<?php

class SmsPilotService
{
	const API_URL = 'https://smspilot.ru/api.php';

	public static function sendSms($phone, $text)
	{
		$apiKey = Yii::app()->params['smsPilotApiKey'];

		$url = self::API_URL . '?' . http_build_query(array(
			'send' => $text,
			'to' => $phone,
			'apikey' => $apiKey,
			'format' => 'json',
		));

		$response = @file_get_contents($url);
		if ($response === false) {
			Yii::log('SmsPilot: не удалось отправить SMS на ' . $phone, CLogger::LEVEL_ERROR, 'application.sms');
			return false;
		}

		$result = json_decode($response, true);
		if (isset($result['error'])) {
			Yii::log('SmsPilot ошибка: ' . $result['error']['description'], CLogger::LEVEL_ERROR, 'application.sms');
			return false;
		}

		Yii::log('SmsPilot: SMS отправлена на ' . $phone, CLogger::LEVEL_INFO, 'application.sms');
		return $result;
	}

	public static function notifySubscribers(Book $book)
	{
		$authorIds = array();
		foreach ($book->authors as $author) {
			$authorIds[] = $author->id;
		}

		if (empty($authorIds)) {
			return;
		}

		$subscriptions = Subscription::model()->findAll(array(
			'condition' => 'author_id IN (' . implode(',', array_map('intval', $authorIds)) . ')',
		));

		$sent = array();
		foreach ($subscriptions as $sub) {
			if (isset($sent[$sub->phone])) {
				continue;
			}
			$author = Author::model()->findByPk($sub->author_id);
			$text = 'Новая книга "' . $book->title . '" автора ' . ($author ? $author->full_name : 'Неизвестный') . ' добавлена в каталог!';
			self::sendSms($sub->phone, $text);
			$sent[$sub->phone] = true;
		}
	}
}
